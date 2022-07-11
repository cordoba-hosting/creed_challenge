'use strict';

const gulp = require('gulp');
const concat = require('gulp-concat');
const combine = require('gulp-scss-combine');
const sass = require('gulp-sass')(require('sass'));
const del = require('del');
const cleanCSS = require('gulp-clean-css');
const sourcemaps = require('gulp-sourcemaps');

gulp.task('sass', function(done) {
    return gulp.src('./library/scss/*.scss')
        .pipe(combine())
        //.pipe(sourcemaps.init({ loadMaps: true }))
        .pipe(sass().on('error', sass.logError))
        //.pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./library/css'))
        .on('end', done);
});

gulp.task('watch', function() {
    gulp.watch(['./library/scss/**/*.scss'], gulp.series(['sass']));
});

gulp.task('clean', function() {
    return del([
        './library/css/*',
    ]);
});

gulp.task('build', gulp.series(['clean', 'sass']));

gulp.task('default', gulp.series(['clean', 'sass', 'watch']));