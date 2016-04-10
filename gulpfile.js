/* EJOweb gulpfile
 * v20160405
 *
 * npm install --save-dev gulp gulp-util gulp-plumber gulp-rename gulp-concat gulp-sass gulp-autoprefixer gulp-coffee gulp-uglify gulp-jshint
 * 
 * gulp-postcss overwegen: https://github.com/postcss/gulp-postcss
 */

/** 
 * Package Variables
 */

/* Gulp */
var gulp = require('gulp');
var gutil = require('gulp-util');
var plumber = require('gulp-plumber');
var rename = require('gulp-rename');
var concat = require('gulp-concat');

/* CSS */
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');

/* Javascript */
var coffee = require('gulp-coffee');
var uglify = require('gulp-uglify');
var jshint = require('gulp-jshint');

/** 
 * Config Variables
 */

//* Config
var sass_dir = './_build/scss/';
var js_dir = './_build/js/';

//* Autoprefixer browser support
var browser_support = 'last 2 version'; 

/** 
 * Code
 */

//* Create expanded and minified stylguesheet at the same time (performance is fast using libsass)
//* In case of error, show it only once
gulp.task('sass:main', function () {

    //* Create expanded stylesheet
    // gulp.src([sass_dir + 'theme.scss'])
    //     .pipe(sass({
    //         outputStyle: 'expanded'
    //     }))
    //     .pipe(autoprefixer({ remove: false, browsers:[browser_support] }))
    //     .on('error', gutil.log) // On error: show log and continue
    //     .pipe(gulp.dest('./assets/css/'));

    gulp.src([sass_dir + 'theme.scss'])
        .pipe(plumber())
        .pipe(sass({
            outputStyle: 'expanded'
        }))
        .pipe(autoprefixer({ remove: false, browsers:[browser_support] }))
        .pipe(gulp.dest('./assets/css/'));

    // //* Create minified stylesheet
    // gulp.src([sass_dir + 'theme.scss'])
    //     .pipe(plumber())
    //     .pipe(sass({
    //         outputStyle: 'compressed'
    //     }))
    //     .pipe(autoprefixer({ remove: false, browsers:[browser_support] }))
    //     .pipe(rename({
    //         suffix: '.min'
    //     }))
    //     .pipe(gulp.dest('./assets/css/'));
});

//* Create expanded and minified stylesheet at the same time (performance is fast using libsass)
//* In case of error, show it only once
gulp.task('sass:editor', function () {

    //* Create expanded stylesheet
    gulp.src([sass_dir + 'editor-style.scss'])
        .pipe(sass({
            outputStyle: 'expanded'
        }))
        .pipe(autoprefixer({ remove: false, browsers:[browser_support] }))
        .on('error', gutil.log) // On error: show log and continue
        .pipe(gulp.dest('./assets/css/'));

    //* Create minified stylesheet
    gulp.src([sass_dir + 'editor-style.scss'])
        .pipe(sass({
            outputStyle: 'compressed'
        }))
        .pipe(autoprefixer({ remove: false, browsers:[browser_support] }))
        .on('error', gutil.noop) // On error: just continue because log is already shown above
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('./assets/css/'));
});

// Javascript
gulp.task('js:main', function() {

    // Lint
    gulp.src(js_dir + '*.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'));

    // Concatenate & Minify JS
    gulp.src(js_dir + '*.js')
        .pipe(concat('theme.js'))
        .pipe(gulp.dest('./assets/js/'))
        .pipe(uglify())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('./assets/js/'));
});

// Watch Files For Changes
gulp.task('sass:watch', function() {
    // gulp.watch( sass_dir + '**/*.scss', ['sass:main', 'sass:editor'] );
    gulp.watch( sass_dir + '**/*.scss', ['sass:main'] );
});

// Watch Files For Changes
gulp.task('js:watch', function() {
    gulp.watch( js_dir + '*.js', ['js'] );
});

//* Default task
gulp.task('default', ['sass:main', 'sass:editor', 'js:main', 'sass:watch', 'js:watch']);
gulp.task('sass', ['sass:main', 'sass:watch']);
gulp.task('js', ['js:main', 'js:watch']);