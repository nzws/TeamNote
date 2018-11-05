const gulp = require('gulp'),
  uglifyes = require('uglify-es'),
  composer = require('gulp-uglify/composer'),
  minify = {
    'js': composer(uglifyes, console),
    'css': require('gulp-clean-css')
  },
  concat = require('gulp-concat'),
  sass = require('gulp-sass'),
  plumber = require('gulp-plumber'),
  wait = require('gulp-wait'),
  browserify = require('browserify'),
  source = require('vinyl-source-stream'),
  runSequence = require('run-sequence');

gulp.task('build-js-depends', function () {
  return browserify({entries: ['js/bundle.js']})
  .bundle()
  .pipe(source('depends.js'))
  .pipe(gulp.dest('public/js/'));
});

gulp.task('build-js-main', function () {
  return gulp.src([
    'public/js/depends.js',
    'js/crs/**/*.js'
  ])
  .pipe(plumber({
    errorHandler: function (err) {
      console.log(err);
      this.emit('end');
    }
  }))
  .pipe(concat('bundle.min.js'))
  .pipe(gulp.dest('public/js/'));
});

gulp.task('build-js-minify', function () {
  return gulp.src('public/js/bundle.min.js')
  .pipe(minify.js().on('error', function(e) {
    console.log(e);
  }))
  .pipe(gulp.dest('public/js/'));
});

gulp.task('build-scss', function () {
  return gulp.src('scss/style.scss')
  .pipe(plumber({
    errorHandler: function (err) {
      console.log(err.messageFormatted);
      this.emit('end');
    }
  }))
  .pipe(wait(100)) // watchの際に保存と同時に走らされるとコケる場合があるので入れる
  .pipe(sass())
  .pipe(minify.css())
  .pipe(concat('style.min.css'))
  .pipe(gulp.dest('public/css/'));
});

gulp.task('build-js-production', function (callback) {
  runSequence('build-js-depends', 'build-js-main', 'build-js-minify', callback);
});

gulp.task('build-js-development', function (callback) {
  runSequence('build-js-depends', 'build-js-main', callback);
});

gulp.task('watch-assets', function () {
  const watcher = gulp.watch('scss/*.scss', ['build-scss']);
  watcher.on('change', function (evt) {
    console.log('file: ' + evt.path + ', ' + 'type: ' + evt.type);
  });

  const watcherJS = gulp.watch('js/**/*.js', ['build-js-main']);
  watcherJS.on('change', function (evt) {
    console.log('file: ' + evt.path + ', ' + 'type: ' + evt.type);
  });
});
