module.exports = {
  env: {
    browser: true,
    es6: true,
    node: true
  },
  extends: [
    'eslint:recommended'
  ],
  parserOptions: {
    ecmaVersion: 2020,
    sourceType: 'module'
  },
  rules: {
    'no-unused-vars': 'warn',
    'no-console': 'warn',
    'semi': ['error', 'always'],
    'quotes': ['error', 'single']
  },
  ignorePatterns: [
    '**/vendor/**',
    '**/*.min.js',
    'resources/assets/js/modules/require.js',
    'resources/assets/js/modules/vue-date-picker.js',
    'public/js/**'
  ]
};
