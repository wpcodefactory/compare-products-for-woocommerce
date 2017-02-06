// Include project requirements.
var gulp = require('gulp'),
    uglify = require('gulp-uglify'),
    sass = require('gulp-sass'),
    livereload = require('gulp-livereload'),
    watch = require('gulp-watch'),
    concat = require('gulp-concat'),
    autoprefixer = require('gulp-autoprefixer'),
    sourcemaps = require('gulp-sourcemaps'),
    rename = require("gulp-rename");

// Sets assets folders.
var dirs = {
    js: '../assets/js',
    css: '../assets/css',
    vendor: '../assets/vendor',
    sass: '../assets/scss'
};

gulp.task('sass', function () {
    gulp.src(dirs.sass + '/*.scss')
        .pipe(sass({
            outputStyle: 'compressed'
        }))
        .on('error', sass.logError)
        .pipe(rename("alg-wc-cp.min.css"))
        .pipe(autoprefixer({
            browsers: ['last 3 versions'],
            cascade: false
        }))
        .pipe(gulp.dest(dirs.css));

    return gulp.src(dirs.sass + '/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'expanded'
        }))
        .on('error', sass.logError)
        .pipe(rename("alg-wc-cp.css"))
        .pipe(autoprefixer({
            browsers: ['last 3 versions'],
            cascade: false
        }))
        .pipe(gulp.dest(dirs.css))
        .pipe(livereload())
        .pipe(sourcemaps.write('../maps'))
        .pipe(gulp.dest(dirs.css));
});

gulp.task('watch', ['sass'], function () {
    livereload.listen();
    watch(dirs.sass + '/**/*.scss', function () {
        gulp.start('sass');
    });
});

gulp.task('default', function () {
    gulp.start(['sass', 'scripts']);
});