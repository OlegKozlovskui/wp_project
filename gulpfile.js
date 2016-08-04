var gulp = require('gulp'),
    autoprefixer = require('gulp-autoprefixer'),
    sass = require('gulp-sass'),
    csso = require('gulp-csso'),
    uglify = require('gulp-uglify'),
    rename = require("gulp-rename");

gulp.task('sass', function () {
    return gulp.src('sass/style.scss')
        .pipe(sass())
        .pipe(autoprefixer('> 1%', 'last 2 versions', 'ie 9', 'Opera 12.1'))
        .pipe(gulp.dest('css'));
});

gulp.task('js', function () {
    return gulp.src('js/*.js');
});

gulp.task('compressCss', function () {
    return gulp.src('css/style.css')
        .pipe(csso())
        .pipe(rename("style.min.css"))
        .pipe(gulp.dest('css'));
});

gulp.task('compressJs', function () {
    return gulp.src('js/main.js')
        .pipe(uglify())
        .pipe(rename("main.min.js"))
        .pipe(gulp.dest('js'));
});

gulp.task('watch', function () {
    gulp.watch('sass/**/*.scss', ['sass']);
    gulp.watch('js/*.js', ['js']);
    gulp.watch('js/main.js', ['compressJs']);
    gulp.watch('css/style.css', ['compressCss']);
});

gulp.task('default', ['sass', 'watch', 'js', 'compressCss', 'compressJs']);