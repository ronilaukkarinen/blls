/*
REQUIRED STUFF
==============
*/

var gulp = require('gulp');
var sass = require('gulp-sass')(require('sass'));
var sourcemaps = require('gulp-sourcemaps');
var browsersync = require('browser-sync').create();
var notify = require('gulp-notify');
var prefix = require('gulp-autoprefixer');
var uglify = require('gulp-uglify-es').default;
var util = require('gulp-util');
var pixrem = require('gulp-pixrem');
var rename = require('gulp-rename');
var scsslint = require('gulp-scss-lint');
var phpcs = require('gulp-phpcs');
const eslint = require('gulp-eslint');
const plumber = require('gulp-plumber');
const webpack = require('webpack');
const VueLoaderPlugin = require('vue-loader/lib/plugin');
const browserify = require('browserify');
const source = require('vinyl-source-stream');
const buffer = require('vinyl-buffer');

/*
ERROR HANDLING
==============
*/

var handleError = function(task) {
  return function(err) {

    notify.onError({
      message: task + ' failed, check the logs..',
      sound: true
    })(err);

    util.log(util.colors.bgRed(task + ' error:'), util.colors.red(err));
  };
};

/*
FILE PATHS
==========
*/

var sassSrc = 'resources/assets/sass/**/*.{sass,scss}';
var sassFile = 'resources/assets/sass/app.scss';
var cssDest = 'public/css';
var markupSrc = 'resources/views/*.php';

/*
BROWSERSYNC
===========
*/

gulp.task('browsersync', function() {
  browsersync.init({
    proxy: 'http://127.0.0.1:8000',
    port: 3005,
    host: '127.0.0.1',
    open: true,
    notify: true,
    reloadDelay: 500,
    injectChanges: true,
    files: [
      'public/css/*.css',
      'public/js/**/*.js',
      'resources/views/**/*.php',
      'resources/assets/js/**/*.js'
    ],
    snippetOptions: {
      rule: {
        match: /<\/head>/i,
        fn: function (snippet, match) {
          return snippet + match;
        }
      }
    },
    middleware: [
      function(req, res, next) {
        res.setHeader('Access-Control-Allow-Origin', '*');
        next();
      }
    ]
  });
});

/*
STYLES
======
*/

gulp.task('scss-lint', function() {
  gulp.src([sassSrc, '!sass/navigation/_burger.scss', '!sass/base/_normalize.scss'])
    .pipe(scsslint());
});

gulp.task('styles', function() {
  return gulp.src(sassFile)
    .pipe(sourcemaps.init())
    .pipe(sass({
      outputStyle: 'expanded',
      includePaths: ['node_modules']
    }).on('error', sass.logError))
    .pipe(prefix())
    .pipe(pixrem())
    .pipe(rename('app.css'))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(cssDest))
    .on('end', function() {
      browsersync.reload();
    });
});

/*
SCRIPTS
=======
*/

const jsConfig = {
  vue: [
    'resources/assets/js/vue-app.js'
  ],
  dest: 'public/js'
};

// Regular JS modules
gulp.task('js', () => {
  // First copy moment.js directly
  gulp.src('node_modules/moment/min/moment-with-locales.min.js')
    .pipe(gulp.dest(jsConfig.dest));

  // Bundle app.js with browserify
  return browserify({
    entries: 'resources/assets/js/app.js',
    debug: true
  })
    .bundle()
    .pipe(source('app.js'))
    .pipe(buffer())
    .pipe(uglify({
      compress: { drop_console: false },
      mangle: true,
      output: { comments: false }
    }))
    .pipe(gulp.dest(jsConfig.dest))
    .pipe(browsersync.stream());
});

// Vue app
gulp.task('vue', () => {
  const webpackConfig = {
    mode: 'production',
    entry: require('path').resolve(__dirname, jsConfig.vue[0]),
    module: {
      rules: [
        {
          test: /\.vue$/,
          use: 'vue-loader'
        },
        {
          test: /\.js$/,
          use: {
            loader: 'babel-loader',
            options: {
              presets: ['@babel/preset-env']
            }
          },
          exclude: /node_modules/
        }
      ]
    },
    plugins: [
      new VueLoaderPlugin(),
      new webpack.ProvidePlugin({
        moment: 'moment'
      }),
      new webpack.optimize.LimitChunkCountPlugin({
        maxChunks: 1
      })
    ],
    resolve: {
      alias: {
        'moment': 'moment/moment.js',
        'vue$': 'vue/dist/vue.esm.js'
      }
    },
    output: {
      path: require('path').resolve(__dirname, 'public/js'),
      filename: 'vue-app.js',
      libraryTarget: 'window',
      library: '[name]'
    },
    optimization: {
      minimize: true
    }
  };

  return gulp.src(jsConfig.vue[0])
    .pipe(plumber(handleError('vue')))
    .pipe(require('webpack-stream')(webpackConfig, webpack))
    .pipe(gulp.dest(jsConfig.dest));
});

// Combined task
gulp.task('scripts', gulp.parallel('js', 'vue'));

/*
PHP
===
*/

gulp.task('php', function() {
return gulp.src(markupSrc)
  .pipe(phpcs({
    bin: '/usr/local/bin/phpcs',
    standard: 'phpcs.xml',
    warningSeverity: 0
  }))
  .pipe(phpcs.reporter('log'));
});

/*
WATCH
=====

Notes:
   - browsersync automatically reloads any files
     that change within the directory it's serving from
*/

// Run the JS task followed by a reload
gulp.task('js-watch', gulp.series('js', function(done) {
  browsersync.reload();
  done();
}));

// Update watch task to include Vue files and proper task ordering
gulp.task('watch', function(done) {
  // Watch Sass files
  gulp.watch(sassSrc, { ignoreInitial: false }, gulp.series('styles'));

  // Watch PHP files
  gulp.watch('resources/views/**/*.php', browsersync.reload);

  // Watch JS files including Vue
  gulp.watch([
    'resources/assets/js/**/*.js',
    'resources/assets/js/**/*.vue'
  ], gulp.series('scripts', function(done) {
    console.log('JS files changed, rebuilding...');
    browsersync.reload();
    done();
  }));

  done();
});

/*
DEFAULT
=======
*/

// Define build task
gulp.task('build', gulp.series('styles', 'js', 'vue'));

// Define dev task that includes browsersync
gulp.task('dev', gulp.series(
  'build',
  gulp.parallel('browsersync', 'watch')
));

// Make default task same as dev
gulp.task('default', gulp.series('dev'));

/*
LINT
====
*/

// Error handling
const errorHandler = {
  errorHandler: notify.onError({
    title: 'Gulp Error',
    message: 'Error: <%= error.message %>'
  })
};

// Add new lint task
gulp.task('lint', () => {
  return gulp.src('resources/assets/js/*.js')
    .pipe(plumber(errorHandler))
    .pipe(eslint())
    .pipe(eslint.format())
    .pipe(eslint.failAfterError());
});

// Add watch task for linting
gulp.task('watch', () => {
  gulp.watch('resources/assets/js/*.js', gulp.series('lint', 'js'));
});

// Default task
gulp.task('default', gulp.series('lint', 'js', 'watch'));

// Add this after your existing js task
gulp.task('watch', function() {
  // Watch JS files
  gulp.watch('resources/assets/js/modules/**/*.js', gulp.series('js'))
    .on('change', function(path) {
      console.log(`File ${path} was changed`);
      browsersync.reload();
    });
});

// Default task
gulp.task('default', gulp.series('watch', 'browsersync'));
