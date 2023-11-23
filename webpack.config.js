const path = require('path');
const homedir = require('os').homedir();
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const pkg = require('./package.json');

const src = './src/';
const dist = './dist/';
const publicDist = './public/dist/';

module.exports = {
  entry: [
    (src + 'js/scripts.js'),
    (src + 'sass/style.scss')
  ],
  output: {
    path: path.resolve(__dirname, publicDist),
    publicPath: '/dist/',
    filename: 'scripts.min.js',
    chunkFilename: (pathData) => {
      return pathData.chunk.name === 'main' ? 'scripts.min.js' : 'modules/[name].js';
    },
  },
  experiments: {
    topLevelAwait: true
  },
  plugins: [
    require('tailwindcss'),
    require('autoprefixer'),
    new MiniCssExtractPlugin({
      filename: 'style.min.css',
      chunkFilename: '[id].css',
    }),
    new BrowserSyncPlugin({
      files: [
        dist + "*.css",
        dist + "*.js",
        "templates/**/*.twig"
      ],
      proxy: 'https://' + pkg.valetDomain,
      host: pkg.valetDomain,
      open: 'external',
      https: {
        key: homedir + '/.config/valet/Certificates/' + pkg.valetDomain + '.key',
        cert: homedir + '/.config/valet/Certificates/' + pkg.valetDomain + '.crt',
      },
      notify: false
    }, {
      reload: true
    })
  ],
  module: {
    rules: [
      {
        test: /\.s[ac]ss$/i,
        use: [{
          loader: MiniCssExtractPlugin.loader
        }, {
          loader: 'css-loader',
        }, {
          loader: 'postcss-loader',
        }, {
          loader: 'sass-loader',
        }]
      },
      {
        test: /\.css$/,
        use: [
            {loader: "style-loader"},
            {loader: "css-loader"}
        ]
      },
      {
        test: /\.js$/,
        exclude: /(node_modules)/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: [
              [
                '@babel/preset-env',
                {
                  targets: {
                    ie: 11,
                  },
                }
              ]
            ],
          }
        }
      }
    ]
  }
}