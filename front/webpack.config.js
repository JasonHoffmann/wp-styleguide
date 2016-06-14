var ExtractTextPlugin = require("extract-text-webpack-plugin");

module.exports = {
    // 入口
    entry: ['./app.js'],
    output: {
      path: "/dist/js",
      publicPath: "/dist/",
      filename: "app.js"
    },
    module: {
        loaders: [
          {
  					test: /\.vue$/, // a regex for matching all files that end in `.vue`
  					loader: 'vue'   // loader to use for matched files
					}        
				]
    },
		vue : {
			loaders: {
				css: ExtractTextPlugin.extract('css')
			}
		},
		plugins: [
			new ExtractTextPlugin('styles.css')
		],
    babel: {
        presets: ['es2015'],
        plugins: ['transform-runtime']
    },
    resolve: {
      modulesDirectories: ['node_modules']
}
};