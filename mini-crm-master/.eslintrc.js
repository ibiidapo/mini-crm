// https://eslint.org/docs/user-guide/configuring

module.exports = {
  root: true,
  parserOptions: {
    parser: 'babel-eslint',
    sourceType: 'module',
    ecmaVersion: 2017,
  },
  env: {
    browser: true,
    es6: true,
  }, // https://github.com/standard/standard/blob/master/docs/RULES-en.md
  extends: [
    'plugin:vue/recommended', // 'plugin:prettier/recommended',
    'eslint:recommended',
  ], // required to lint *.vue files
  plugins: [
    'vue', 'import',
  ],
  
  // add your custom rules here
  rules: {
    // allow debugger during development
    'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'linebreak-style': [
      'error', 'windows',
    ],
    'quotes': [
      'error', 'single',
    ],
    'semi': [
      'error', 'always',
    ],
    'no-empty': 1,
    'no-unused-vars': 1,
    'no-undef': 0,
    'no-mixed-spaces-and-tabs': 1,
    'no-undef-init': 1,
    'no-else-return': 'error',
    'no-multi-spaces': 'error',
    'no-whitespace-before-property': 'error',
    'new-cap': 'error',
    'no-console': 'error',
    'no-var': 'error',
    'vue/script-indent': [
      'warn', 2, {
        'baseIndent': 1,
      },
    ],
    'vue/html-indent': [
      'warn', 2,
    ],
  },
  globals: {},
};