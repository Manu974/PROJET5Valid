var Encore = require('@symfony/webpack-encore');
var Uglify = require('uglifyjs-webpack-plugin');
var minifyCss = require('optimize-css-assets-webpack-plugin');

Encore
    .setOutputPath('web/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .addEntry('src', './web/js/app.js')
    .addEntry('admin', [
        './web/js/src/admin/admin-app.js',
        './web/js/src/admin/admin-pages.js'
    ])
    .addStyleEntry('global', './web/css/app.css')
    .addStyleEntry('bootstrap', [
        './web/css/Skeleton-2.0.4/css/normalize.css',
        './web/css/Skeleton-2.0.4/css/skeleton.css',
    ])
    .enablePostCssLoader()
;

module.exports = Encore.getWebpackConfig();