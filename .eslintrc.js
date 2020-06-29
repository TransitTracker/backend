module.exports = {
  env: {
    browser: true,
    es6: true,
  },
  extends: [
    'standard',
    'plugin:vue/recommended',
    'plugin:vue/essential',
    'vuetify',
  ],
  globals: {
    Atomics: 'readonly',
    SharedArrayBuffer: 'readonly',
  },
  parserOptions: {
    parser: 'babel-eslint',
    ecmaVersion: 2018,
    sourceType: 'module',
  },
}
