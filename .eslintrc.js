/* eslint-disable */
module.exports = {
  root: true,
  env: {
    browser: true,
    node: true,
  },
  parserOptions: {
    parser: 'babel-eslint',
  },
  extends: [
    'prettier',
    'plugin:prettier/recommended',
    'plugin:tailwind/recommended',
  ],
  plugins: ['prettier'],
  // add your custom rules here
  rules: {},
}