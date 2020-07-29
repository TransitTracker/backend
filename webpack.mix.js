const mix = require('laravel-mix')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defnpm install --save-dev @babel/plugin-syntax-dynamic-importining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.extend('i18n', new class {
  webpackRules () {
    return [
      {
        resourceQuery: /blockType=i18n/,
        type: 'javascript/auto',
        loader: '@kazupon/vue-i18n-loader'
      }
    ]
  }
})

mix.webpackConfig({
  module: {
    rules: [
      {
        enforce: 'pre',
        test: /\.(js|vue)$/,
        loader: 'eslint-loader',
        exclude: /node_modules/
      }
    ]
  },
  output: {
    publicPath: ''
  }
})

mix.babelConfig({
  plugins: ['@babel/plugin-syntax-dynamic-import']
})

mix.js('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .extract(['vue', 'vuetify'])
  .version()

if (mix.inProduction()) {
  mix.disableNotifications()
} else {
  require('laravel-mix-bundle-analyzer')
  mix.bundleAnalyzer()
}
