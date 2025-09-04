let mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .vue()
   .sass('resources/sass/app.scss', 'public/css')
   .options({
      processCssUrls: false
   });

mix.webpackConfig({
      output: {
          publicPath: '/public/',
          chunkFilename: '[name].bundle.js?id=[contenthash]'
      },
      optimization: {
          splitChunks: {
              automaticNameDelimiter: '-',
              name: false
          }
      }
  });
