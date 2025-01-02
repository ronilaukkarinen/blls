/*
REQUIRED STUFF
==============
*/

var gulp        = require('gulp');
var sass        = require('gulp-sass')(require('sass'));
var sourcemaps  = require('gulp-sourcemaps');
var browsersync = require('browser-sync').create();
var notify      = require('gulp-notify');
var prefix      = require('gulp-autoprefixer');
var cleancss    = require('gulp-clean-css');
var uglify      = require('gulp-uglify-es').default;
var concat      = require('gulp-concat');
var util        = require('gulp-util');
var pixrem      = require('gulp-pixrem');
var exec        = require('child_process').exec;
var rename      = require('gulp-rename');
var stylefmt    = require('gulp-stylefmt');
var debug       = require('gulp-debug');
var scsslint    = require('gulp-scss-lint');
var php2html    = require('gulp-php2html');
var htmlmin     = require('gulp-htmlmin');
var phpcs       = require('gulp-phpcs');
var cache       = require('gulp-cached');

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
var jsSrc = 'resources/assets/js/**/*.js';
var jsDest = 'public/js';
var markupSrc = 'resources/views/*.php';

/*
BROWSERSYNC
===========
*/

gulp.task('browsersync', function() {
  var files = [
    jsSrc,
    markupSrc
  ];

  browsersync.init(files, {
    proxy: "blls.test",
    browser: null,
    notify: true,
    open: false,
    reloadDelay: 1000
  });
});

/*
STYLES
======
*/

var stylefmtfile = function( file ) {

  console.log(util.colors.white('[') + util.colors.yellow('Stylefmt') + util.colors.white('] ') + 'Automatically correcting file based on .stylelintrc...');
  var currentdirectory = process.cwd() + '/';
  var modifiedfile = file.path.replace( currentdirectory, '' );
  var filename = modifiedfile.replace(/^.*[\\\/]/, '')
  var correctdir = modifiedfile.replace( filename, '' );

  gulp.src(modifiedfile)

    // Cache this action to prevent watch loop
    .pipe(cache('stylefmtrunning'))

    // Run current file through stylefmt
    .pipe(stylefmt({ configFile: '.stylelintrc' }))

    // Overwrite
    .pipe(gulp.dest(correctdir))
};

gulp.task('scss-lint', function() {
  gulp.src([sassSrc, '!sass/navigation/_burger.scss', '!sass/base/_normalize.scss'])
    .pipe(scsslint());
});

gulp.task('styles', function() {
return gulp.src('resources/assets/sass/**/*.scss')
  .pipe(sourcemaps.init())
  .pipe(sass({
    outputStyle: 'compressed',
    includePaths: ['node_modules']
  }).on('error', sass.logError))
  .pipe(prefix())
  .pipe(pixrem())
  .pipe(cleancss())
  .pipe(rename({ suffix: '.min' }))
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('public/css'))
  .pipe(browsersync.stream());
});

/*
SCRIPTS
=======
*/

gulp.task('js', function() {
  return gulp.src([
    'node_modules/jquery/dist/jquery.js',
    'resources/assets/js/moment-with-locales.js',
    'resources/assets/js/macy.js',
    'resources/assets/js/scripts.js',
    'resources/assets/js/bills.js',
    'resources/assets/js/subscriptions.js',
    'resources/assets/js/paymentplans.js',
    'resources/assets/js/creditcards.js',
    'resources/assets/js/materialDateTimePicker.js'
  ])
  .pipe(concat('app.js'))
  .pipe(uglify({
    compress: true,
    mangle: true
  }).on('error', function(err) {
    util.log(util.colors.red('[Error]'), err.toString());
    this.emit('end');
  }))
  .pipe(gulp.dest(jsDest));
});

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

gulp.task('watch', gulp.series('browsersync', function(done) {
  gulp.watch(sassSrc, gulp.series('styles', 'scss-lint')).on('change', stylefmtfile);
  gulp.watch(jsSrc, gulp.series('js-watch'));
  done();
}));

/*
DEFAULT
=====
*/

gulp.task('build', gulp.series('styles', 'js', 'php'));
gulp.task('default', gulp.series('watch'));
