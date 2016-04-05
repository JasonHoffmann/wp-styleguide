var gulp = require('gulp'),
    include = require('gulp-include'),
    jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    plumber = require('gulp-plumber'),
    webpack = require('gulp-webpack');


var paths = {
  js: {
    src: ['./app.js'],
    compile:  ['./app.js', './app/**/*.js', '!app/build/*.js', '!app/vendor/*.js'],
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
gulp.task('app', function() {
    return gulp.src(paths.js.src)
      .pipe(webpack({
        output: {
          filename: 'app.js',
        },
      }))
      .pipe(gulp.dest(paths.js.dest));
});

//gulp.task('vueify', function () {
//  return gulp.src('./app/**/*.vue')
//    .pipe(vueify())
//    .pipe(gulp.dest('./app/build/components.js'));
//});

gulp.task('watch', function(){
  gulp.watch(paths.js.compile, ['lint', 'app']);
});

gulp.task('default', ['lint', 'app', 'watch']);