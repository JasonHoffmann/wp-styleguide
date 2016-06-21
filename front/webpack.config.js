var ExtractTextPlugin = require("extract-text-webpack-plugin");

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
			new ExtractTextPlugin('styles.css')
		],
		babel: { presets: ['es2015'], plugins: ['transform-runtime'] },
		resolve: { modulesDirectories: ['node_modules'] }
};