const gulp          = require('gulp');
const sass          = require('gulp-sass');
const babel         = require("gulp-babel");
const concat        = require('gulp-concat');
const terser        = require("gulp-terser");
const postcss       = require('gulp-postcss');
const cssnano       = require('cssnano');
const ngAnnotate    = require('gulp-ng-annotate'); //Add angularjs dependency injection annotations
const browserSync   = require('browser-sync').create();
const autoprefixer  = require('autoprefixer');
// const sourcemaps = require('gulp-sourcemaps');

const paths = {
  styles: {
    src: "./app/src/sass/**/*.scss"
    //dest: 'styles'
  },
  js: {
    src: "./app/src/js/*.js"
  },
  php: {
    src: "./app/**/*.php"
  }
};

// ********************************* SASS:CSS *********************************
function style() {
	return gulp
		.src(paths.styles.src)
		.pipe(concat("default.css"))
		.pipe(sass())
		.on("error", sass.logError)
		.pipe(postcss([autoprefixer(), cssnano()]))
		.pipe(gulp.dest("./app/built/css"))
		.pipe(browserSync.stream())
}
// // ********************************* JS *********************************
function js() {
	return (
		gulp
		.src(paths.js.src)
		.pipe(concat("built.js"))
		.pipe(ngAnnotate({ add: true }))
		.on("error", function(err) {
			gutil.log(gutil.colors.red("[Error]"), err.toString());
		})
		.pipe(babel({ presets: ["@babel/env"] }))
		// .pipe(terser())
		.pipe(gulp.dest("./app/built/js"))
		.pipe(browserSync.stream())
	);
}

// ********************************* VENDOR:CSS *********************************
exports.cssvendor = () => {
	return gulp
		.src([
				'./app/src/vendor/css/bootstrap.min.css',
				'./app/src/vendor/css/fontawesome.css'
		])
		.pipe(concat('vendor.css'))
		.pipe(sass())
		.on('error', sass.logError)
		.pipe(postcss([autoprefixer(), cssnano()]))
		.pipe(gulp.dest('./app/built/css'));
}
// ********************************* VENDOR:JS *********************************
exports.jsvendor = () => {
  return gulp
    .src([
      "./app/src/vendor/js/jqueryv2.2.4.min.js",
      "./node_modules/angular/angular.js",
      "./app/src/vendor/js/bootstrap.min.js",
    ])
    .pipe(concat("vendor.js"))
    // .pipe(
    //   babel(
	// 	  {compact: false},
	// 	  {presets: ["@babel/env"]})
    // )
    // .pipe(terser())
    .pipe(gulp.dest("./app/built/js"));
}

// ********************************* WATCH *********************************
exports.watch = function watch() {
	browserSync.init({
		open: 'external',
		host: 'localhost',
		proxy: 'localhost/classifiedads',
		port: 80
	});
	// style();
	gulp.watch(paths.styles.src, style);
	gulp.watch(paths.js.src, js);
	gulp.watch(paths.php.src, js);
}

// exports.watch = watch;
exports.js = js;
exports.style = style;
