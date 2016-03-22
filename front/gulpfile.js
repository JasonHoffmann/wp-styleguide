var gulp = require('gulp'),
    include = require('gulp-include'),
    jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    plumber = require('gulp-plumber');


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
    .pipe(include())
    .pipe(plumber())
    .pipe(gulp.dest(paths.js.dest))
    .pipe(uglify({
      mangle: false
    }))
    .pipe(gulp.dest(paths.js.dest));
});

gulp.task('watch', function(){
  gulp.watch(paths.js.compile, ['lint', 'app']);
});

gulp.task('default', ['lint', 'app', 'watch']);