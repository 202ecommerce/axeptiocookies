/**
 * Copyright since 2022 Axeptio
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to tech@202-ecommerce.com so we can send you a copy immediately.
 *
 * @author    202 ecommerce <tech@202-ecommerce.com>
 * @copyright 2022 Axeptio
 * @license   https://opensource.org/licenses/AFL-3.0  Academic Free License (AFL 3.0)
 */

const path = require('path');
const fs = require('fs');
const webpack = require('webpack');
const RemoveEmptyScriptsPlugin = require('webpack-remove-empty-scripts');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');
const parser = require('xml2json');

const getBuildVersion = (mode) => {
  if (mode === 'development') {
    return '@version@';
  }

  const data = fs.readFileSync('./202/build.xml', 'utf8');
  const buildXml = JSON.parse(parser.toJson(data));
  const properties = buildXml.project.property;
  for (let property of properties) {
    if ('name' in property && 'value' in property) {
      if (property.name === 'TARGETVERSION') {
        return property.value;
      }
    }
  }

  return '1.0.0';
}

const getConfig = (env, argv) => {
  const minimizers = [];
  const plugins = [
    new VueLoaderPlugin(),
    new RemoveEmptyScriptsPlugin(),
    new MiniCssExtractPlugin({
      filename: `[name].${getBuildVersion(argv.mode)}.css`,
    }),
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery',
      'window.jQuery': 'jquery'
    }),
  ];

  return {
    entry: {
      'js/admin': './views/_dev/js/admin/admin.js',
      'css/admin': './views/_dev/scss/admin.scss',
    },

    output: {
      filename: `[name].${getBuildVersion(argv.mode)}.js`,
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
                plugins: ['@babel/plugin-transform-runtime'],
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
    devtool: argv.mode === 'development' ? 'eval' : 'cheap-source-map',
    resolve: {
      extensions: ['.js', '.scss', '.css', '.vue', '.json'],
      alias: {
        'vue$': 'vue/dist/vue.esm.js',
        '~': path.resolve(__dirname, './node_modules'),
      },
    },
    stats: {
      children: false,
    },
  };
};

module.exports = (env, argv) => {
  const config = getConfig(env, argv);
  // Production specific settings
  if (argv.mode === 'production') {
    const terserPlugin = new TerserPlugin({
      extractComments: /^\**!|@preserve|@license|@cc_on/i, // Remove comments except those containing @preserve|@license|@cc_on
      parallel: true,
      terserOptions: {
        compress: {
          pure_funcs: [
            'console.log'
          ]
        }
      },
    });

    config.optimization.minimizer.push(terserPlugin);
  }

  return config;
};
