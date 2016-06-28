var gulp = require('gulp'),
    include = require('gulp-include'),
    jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    plumber = require('gulp-plumber'),
    webpack = require('gulp-webpack');
var ExtractTextPlugin = require("extract-text-webpack-plugin");
var watch = require('gulp-watch');


var paths = {
  js: {
    src: ['./app.js'],
    compile:  ['./app.js', './app/**/*.js', '!app/build/*.js', '!app/vendor/*.js'],
    watch: [ './app.js', './components/**/*.vue', './components/**/*.js', './common/**/*.js' ],
    dest: './app/build/'
  }
};

// ========================================
// Lint Js
// ========================================

// Finds and reports errors within app/**/js/
gulp.task('lint', function() {
  return gulp.src(paths.js.compile)
    .pipe(jshint())
    .pipe(jshint.reporter('default'));
});


// ========================================
// Compile js
// ========================================

// Compiles js from app.js
// gulp.task('app', function() {
//     return gulp.src(paths.js.src)
//       .pipe(webpack({
//         output: {
//           filename: 'app.js',
//         },
//         module: { loaders: [ 
//           { test: /\.vue$/, loader: 'vue'  },
//           { test: /\.js$/, exclude: /node_modules|vue\/src|vue-router\//,  loader: 'babel' }
//         ] },
// 				vue : {
// 					loaders: {
// 						css: ExtractTextPlugin.extract('css'),
// 						sass: ExtractTextPlugin.extract('css!sass'),
// 						scss: ExtractTextPlugin.extract('css!sass')
// 					}
// 				},
// 				plugins: [
// 					new ExtractTextPlugin('styles.css')
// 				],
//         babel: { presets: ['es2015'], plugins: ['transform-runtime'] },
//         resolve: { modulesDirectories: ['node_modules'] }
//       }))
//       .pipe(gulp.dest(paths.js.dest));
// });
// 
gulp.task('app', function() {
    return gulp.src(paths.js.src)
      .pipe(webpack( require('./webpack.config.js') ) )
      .pipe(gulp.dest(paths.js.dest));
});

gulp.task('watch', function(){
  gulp.watch(paths.js.watch, ['app']);
});

gulp.task('default', ['app', 'watch']);