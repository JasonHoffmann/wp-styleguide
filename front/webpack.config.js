var ExtractTextPlugin = require("extract-text-webpack-plugin");
var webpack = require('webpack');

module.exports = {
		output: {
			filename: 'app.js',
		},
		module: { loaders: [ 
			{ test: /\.vue$/, loader: 'vue'  },
			{ test: /\.js$/, exclude: /node_modules|vue\/src|vue-router\//,  loader: 'babel' }
		] },
		vue : {
			loaders: {
				css: ExtractTextPlugin.extract('css'),
				sass: ExtractTextPlugin.extract('css!sass'),
				scss: ExtractTextPlugin.extract('css!sass')
			}
		},
		plugins: [
			new ExtractTextPlugin('styles.css'),
		//	new webpack.optimize.UglifyJsPlugin({ compress: { warnings: false }})
		],
		babel: { presets: ['es2015'], plugins: ['transform-runtime'] },
		resolve: { modulesDirectories: ['node_modules'] }
};