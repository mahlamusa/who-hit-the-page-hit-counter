var gulp = require('gulp');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var notify = require('gulp-notify');
var sass = require('gulp-sass');
var makepot = require('gulp-wp-pot');
var copy = require('gulp-copy');
var zip = require('gulp-zip');
var filter = require('gulp-filter');
var clean = require('gulp-clean');

gulp.task( "scripts", function(){
    return gulp.src('assets/src/js/*.js')
    .pipe(uglify())
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest('assets/js'))    
	.pipe(notify({message: 'Congratulations! JavaScripts Minified!', onLast: true}));
});


gulp.task( "styles", function(){
    return gulp.src('assets/src/css/*.css')
    .pipe(sass({outputStyle: 'compressed'})).on('error', function(err) {notify().write(err);})
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest('assets/css'))    
	.pipe(notify({message: 'Congratulations! Stylesheets Minified!', onLast: true}));
});

// make pot for i18n
var sourceStrings = [
    '*.php',
    '{includes,partials}/*/*.php',
    '{includes,partials}/*/*/*.php',
    '{includes,partials}/*.php',
];
gulp.task('makepot', function () {
	return gulp.src(sourceStrings)
		.pipe(makepot({package: 'Who Hit The Page Hit COunter'}))
        .pipe(gulp.dest('languages/who-hit-the-page-hit-counter.po'))
        .pipe(gulp.dest('languages/who-hit-the-page-hit-counter-en_US.po'))
        .pipe(gulp.dest('languages/who-hit-the-page-hit-counter-en_ZA.po'))
        .pipe(gulp.dest('languages/who-hit-the-page-hit-counter-en_UK.po'))
        .pipe(gulp.dest('languages/who-hit-the-page-hit-counter-ss_SW.po'))
        .pipe(gulp.dest('languages/who-hit-the-page-hit-counter-ss_ZA.po'))
        .pipe(gulp.dest('languages/who-hit-the-page-hit-counter-af_ZA.po'))
        .pipe(notify({message: 'Congratulations! Translation files created!', onLast: true}));
});

gulp.task('default', ['styles', 'scripts', 'watch-js', 'watch-css', 'makepot', 'watch-php', 'copy', 'zip']);

gulp.task('watch', function(){
    gulp.watch('assets/src/**/.{js,css}', ['scripts','styles']);
});

gulp.task('watch-css', function(){
    gulp.watch('assets/src/css/*.css', ['styles']);
});

gulp.task('watch-js', function(){
    gulp.watch('assets/src/js/*.js', ['scripts']);
});

var files = [
	'*.php',
    '{includes,partials}/*/*.php',
    '{includes,partials}/*/*/*.php',
    '{includes,partials}/*.php',
];

gulp.task('watch-php', function(){
    gulp.watch(files, ['makepot']);
});

/**
 * Packaging
 */ 

var copyFiles = [ 
    '*.php',
    '{includes,partials}/*/*.php',
    'assets/css/*.css',
    'assets/js/*.js',
    'assets/icons/*.png',
    '{includes,partials}/*/*/*.php',
    '{includes,partials}/*.php',
];

var sourceFiles =[
    './**/*', 
    '!./{node_modules,node_modules/**/*}', 
    '!./assets/{src,src/js/*,src/css/*}',
    '!./release/**/*',
    '!./release', 
    '!./gulpfile.js', 
    '!./package.json', 
    '!./package-lock.json',
    '!./composer.json',
    '!./composer.lock',
    '!./deploy.sh',
    '!./README.md'
]

var destination = '../_release/who-hit-the-page-hit-counter';
var options = [];
 
gulp.task('copy', function(){
    return gulp.src(sourceFiles)
        .pipe(copy(destination))
        .pipe(gulp.dest(destination)) 
        .pipe(notify({message: 'Congratulations! Files copied to destination!', onLast: true}));
});
 
gulp.task('zip', function() {
    return gulp.src(sourceFiles)
        .pipe(zip('who-hit-the-page-hit-counter.zip'))      
        .pipe(gulp.dest('../_release')) 
        .pipe(notify({message: 'Congratulations! Zip file created successfully!', onLast: true}));   
});

gulp.task('clean', function () {
    return gulp.src('../_release/who-hit-the-page-hit-counter', {read: false})
        .pipe(clean())
        .pipe(notify({message: 'Congratulations! All Clean!', onLast: true}));
});

gulp.task('package', ['copy','zip'] );
