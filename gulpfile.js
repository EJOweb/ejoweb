/* EJOweb gulpfile
 * v20160122
 *
 * npm install gulp gulp-util gulp-rename gulp-concat gulp-sass gulp-autoprefixer gulp-uglify gulp-jshint --save-dev
 */

//* Package variables
var gulp = require('gulp');
var gutil = require('gulp-util');
var rename = require('gulp-rename');
var concat = require('gulp-concat');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var uglify = require('gulp-uglify');
var jshint = require('gulp-jshint');

//* Config
var sass_dir = './_build/scss/';
var js_dir = './_build/js/';

//* Create expanded and minified stylesheet at the same time (performance is fast using libsass)
//* In case of error, show it only once
gulp.task('sass', function () {

    //* Create expanded stylesheet
    gulp.src([sass_dir + 'theme.scss'])
        .pipe(sass({
            outputStyle: 'expanded'
        }))
        .pipe(autoprefixer({browsers:['last 2 version']}))
        .on('error', gutil.log) // On error: show log and continue
        .pipe(gulp.dest('./assets/css/'));

    //* Create minified stylesheet
    gulp.src([sass_dir + 'theme.scss'])
        .pipe(sass({
            outputStyle: 'compressed'
        }))
        .pipe(autoprefixer({browsers:['last 2 version']}))
        .on('error', gutil.noop) // On error: just continue because log is already shown above
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('./assets/css/'));
});

//* Create expanded and minified stylesheet at the same time (performance is fast using libsass)
//* In case of error, show it only once
gulp.task('sass-editor', function () {

    //* Create expanded stylesheet
    gulp.src([sass_dir + 'editor-style.scss'])
        .pipe(sass({
            outputStyle: 'expanded'
        }))
        .pipe(autoprefixer({browsers:['last 2 version']}))
        .on('error', gutil.log) // On error: show log and continue
        .pipe(gulp.dest('./assets/css/'));

    //* Create minified stylesheet
    gulp.src([sass_dir + 'editor-style.scss'])
        .pipe(sass({
            outputStyle: 'compressed'
        }))
        .pipe(autoprefixer({browsers:['last 2 version']}))
        .on('error', gutil.noop) // On error: just continue because log is already shown above
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('./assets/css/'));
});

// Lint Task
gulp.task('lint', function() {
    gulp.src(js_dir + '*.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});

// Concatenate & Minify JS
gulp.task('scripts', function() {
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
gulp.task('watch', function() {
    gulp.watch( js_dir + '*.js', ['lint', 'scripts'] );
    gulp.watch( sass_dir + '**/*.scss', ['sass', 'sass-editor'] );
});

//* Default task
gulp.task('default', ['lint', 'sass', 'sass-editor', 'scripts', 'watch']);