const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
  mode: 'production',
  devtool: "inline-source-map",
  entry: {
    entry: ['./assets/index.ts', './assets/styles.scss']
  },
  output: {
    path: path.resolve(__dirname, 'assets/dist'),
    filename: 'bundle.js'
  },
  resolve: {
    // Add `.ts` and `.tsx` as a resolvable extension.
    extensions: [".ts", ".tsx", ".js"]
  },
  plugins: [
    new MiniCssExtractPlugin({
      // Options similar to the same options in webpackOptions.output
      // both options are optional
      filename: "bundle.css",
      chunkFilename: "[id].css"
    })
  ],
  module: {
    rules: [
      // all text files will be handled by raw loader || placed here as default
      { test: /\.txt$/, use: 'raw-loader' },
      // all fonts will be handled by file-loader
      {
        test: /\.(eot|svg|ttf|woff|woff2)(\??\#?v=[.0-9]+)?$/,
        loader: 'file-loader?name=fonts/[name].[ext]',
      },
      // all files with a `.ts` or `.tsx` extension will be handled by `ts-loader`
      { test: /\.tsx?$/, loader: "ts-loader" },
      {
        test: /\.s?css$/,
        use: [
          { loader: MiniCssExtractPlugin.loader },
          { loader: 'css-loader', options: { sourceMap: true } },
          { loader: 'postcss-loader', options: { sourceMap: true } },
          { loader: 'sass-loader', options: {
            sourceMap: true,
            includePaths: ['./node_modules']
            }
          }
        ]
      }
    ]
  }
};
