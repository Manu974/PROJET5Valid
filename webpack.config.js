var Encore = require('@symfony/webpack-encore');
var Uglify = require('uglifyjs-webpack-plugin');
var minifyCss = require('optimize-css-assets-webpack-plugin');

Encore
    .setOutputPath('web/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .addEntry('app', './web/js/app.js')
    .addStyleEntry('global', './web/css/app.css')
    .enablePostCssLoader()
;

module.exports = Encore.getWebpackConfig();