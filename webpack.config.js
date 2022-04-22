/*
 * NOTICE OF LICENSE
 *
 * This source file is subject to a commercial license from SARL 202 ecommerce
 * Use, copy, modification or distribution of this source file without written
 * license agreement from the SARL 202 ecommerce is strictly forbidden.
 * In order to obtain a license, please contact us: tech@202-ecommerce.com
 * ...........................................................................
 * INFORMATION SUR LA LICENCE D'UTILISATION
 *
 * L'utilisation de ce fichier source est soumise a une licence commerciale
 * concedee par la societe 202 ecommerce
 * Toute utilisation, reproduction, modification ou distribution du present
 * fichier source sans contrat de licence ecrit de la part de la SARL 202 ecommerce est
 * expressement interdite.
 * Pour obtenir une licence, veuillez contacter 202-ecommerce <tech@202-ecommerce.com>
 * ...........................................................................
 *
 * @author    202-ecommerce <tech@202-ecommerce.com>
 * @copyright Copyright (c) 202-ecommerce
 * @license   Commercial license
 * @version   [version]
 */

const path = require('path');
const fs = require('fs');
const webpack = require('webpack');
const FixStyleOnlyEntriesPlugin = require('webpack-fix-style-only-entries');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');

const minimizers = [];
const plugins = [
  new VueLoaderPlugin(),
  new FixStyleOnlyEntriesPlugin(),
  new MiniCssExtractPlugin({
    filename: '[name].css',
  }),
  new webpack.ProvidePlugin({
    $: 'jquery',
    jQuery: 'jquery',
    'window.jQuery': 'jquery'
  }),
];

const config = {
  entry: {
    'js/admin': './views/_dev/js/admin/admin.js',
    'css/admin': './views/_dev/scss/admin.scss',
  },

  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, './views/')
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: [
          {
            loader: 'babel-loader',
            options: {
              presets: ['@babel/preset-env'],
            },
          },
        ],
      },
      {
        test: /\.(s)?css$/,
        use: [
          {loader: MiniCssExtractPlugin.loader},
          {loader: 'css-loader'},
          {loader: 'postcss-loader'},
          {loader: 'sass-loader'},
        ],
      },
      {
        test: /\.vue$/,
        loader: 'vue-loader',
        options: {
          loaders: {
            'scss': [
              'vue-style-loader',
              'css-loader',
              'sass-loader'
            ],
            'sass': [
              'vue-style-loader',
              'css-loader',
              'sass-loader?indentedSyntax'
            ]
          }
        }
      },
    ],
  },

  externals: {
    $: '$',
    jquery: 'jQuery',
  },

  plugins,

  optimization: {
    minimizer: minimizers
  },
  devtool: this.mode === 'development' ? 'eval' : 'cheap-source-map',
  resolve: {
    extensions: ['.js', '.scss', '.css', '.vue', '.json'],
    alias: {
      'vue$': 'vue/dist/vue.esm.js',
      '~': path.resolve(__dirname, './node_modules'),
      '@app': path.resolve(__dirname, './bb/themes/new-theme/js/app'),
      '@components': path.resolve(__dirname, './bb/themes/new-theme/js/components'),
    },
  },
  stats: {
    children: false,
  },
};

module.exports = (env, argv) => {
  // Production specific settings
  if (argv.mode === 'production') {
    const terserPlugin = new TerserPlugin({
      cache: true,
      sourceMap: true,
      extractComments: /^\**!|@preserve|@license|@cc_on/i, // Remove comments except those containing @preserve|@license|@cc_on
      parallel: true,
      terserOptions: {
        drop_console: true,
      },
    });

    config.optimization.minimizer.push(terserPlugin);
  }

  return config;
};
