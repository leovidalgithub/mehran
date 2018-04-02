const gulp = require('gulp');
const sass = require('gulp-sass');
const minifyCSS = require('gulp-csso');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const autoprefixer = require('autoprefixer'); // autoprefixer
const postcss = require('gulp-postcss'); // autoprefixer
const php = require('gulp-connect-php7');
const browserSync = require('browser-sync');
const ngAnnotate = require('gulp-ng-annotate'); //Add angularjs dependency injection annotations
const gutil = require('gulp-util'); // to catch errors
const babel = require('gulp-babel');

// ********************************* SASS *********************************
gulp.task('sass', function () {
    return gulp.src('./app/src/sass/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(concat('default.css'))
        .pipe(postcss([autoprefixer({ browsers: ["> 0%"] })]))
        .pipe(minifyCSS())
        .pipe(gulp.dest('./app/built/css'))
});

// // ********************************* JS *********************************
gulp.task('js', function () {
    return gulp.src('./app/src/js/*.js')
        .pipe(concat('built.js'))
        .pipe(ngAnnotate({ add: true }))
        .pipe(babel({
            presets: ['env']
        }))
        .on('error', function (err) { gutil.log(gutil.colors.red('[Error]'), err.toString()); })
        .pipe(uglify())
        .pipe(gulp.dest('./app/built/js'))
});

// // ********************************* WATCH *********************************
gulp.task('watch', function () {
    gulp.watch('./app/src/sass/**/*.scss', ['sass']);
    gulp.watch('./app/src/js/*.js', ['js']);
});

// // ********************************* VENDOR:CSS *********************************
gulp.task('vendor:css', function () {
    return gulp.src([
        './app/src/vendor/css/bootstrap.min.css',
        './app/src/vendor/css/fontawesome.css'
    ])
        .pipe(concat('vendor.css'))
        .pipe( minifyCSS())
        .pipe(gulp.dest('./app/built/css'));
});

// //********************************* VENDORS JS (angular, jquery, bootstrap)
gulp.task('vendor:js', function () {
    return gulp.src([
        './app/src/vendor/js/jqueryv2.2.4.min.js',
        './node_modules/angular/angular.js',
        './app/src/vendor/js/bootstrap.min.js'
        ])
        .pipe(concat('vendor.js'))
        .pipe( uglify() )
        .pipe(gulp.dest('./app/built/js'))
});

// // ********************************* DEFAULT TASK *********************************
// gulp.task('default', ['browser-sync', 'watch']);
