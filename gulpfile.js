var gulp = require('gulp'),
    path = require('path'),
    clean = require('gulp-clean'),
    concat = require('gulp-concat'),
    rename = require('gulp-rename'),
    htmlreplace = require('gulp-html-replace'),
    cssmin = require('gulp-cssmin'),
    jsmin = require('gulp-uglify'),
    imagemin = require('gulp-imagemin'),
    watch = require('gulp-watch'),
    zip = require('gulp-zip'),
    ftp = require('gulp-ftp'),
    pkg = require('./package.json'),
    ftplogin = require('./ftplogin.json');

var paths = {
  styles: [
    'src/reset-html5.css',
    'src/style.css'
  ],
  scripts: [
    'src/script.js'
  ],
  images: 'src/images/**',
  copy: {
    root: [
      'src/*.php',
      'src/editor-style.css',
      'src/screenshot.png'
    ],
    fonts: 'src/fonts/**'
  }
};

gulp.task('clean', function() {
  return gulp.src(pkg.name, {read: false})
    .pipe(clean());
});

gulp.task('styles', function() {
  return gulp.src(paths.styles)
    .pipe(concat('style.css'))
    .pipe(cssmin())
    .pipe(gulp.dest(pkg.name));
});
 
gulp.task('scripts', function() {
  return gulp.src(paths.scripts)
    .pipe(concat('script.js', {newLine: ';'}))
    .pipe(jsmin())
    .pipe(gulp.dest(pkg.name));
});

gulp.task('images', function() {
  return gulp.src(paths.images)
    .pipe(imagemin({optimizationLevel: 3, progressive: true, interlaced: true}))
    .pipe(gulp.dest(pkg.name + '/images'));
});

gulp.task('copy', function() {
  gulp.src(paths.copy.root)
    .pipe(gulp.dest(pkg.name));
  gulp.src(paths.copy.fonts)
    .pipe(gulp.dest(pkg.name + '/fonts'));
});

gulp.task('replace', ['copy'], function() {
  gulp.src('src/master/master.html')
    .pipe(htmlreplace({
      css: {
        src: 'css/' + pkg.name + '.min.css',
        tpl: '<link rel="stylesheet" id="' + pkg.name + '-css" href="%s />'
      },
      js: {
        src: 'js/' + pkg.name + '.min.js',
        tpl: '<script src="%s async></script>'
      }
    }))
    .pipe(gulp.dest(pkg.name + '/master'));
});

gulp.task('watch', function() {
  gulp.watch(paths.styles, ['upload-css']);
  gulp.watch(paths.scripts, ['upload-js']);
  gulp.watch(paths.images, ['upload-images']);
  gulp.watch(paths.copy.root, ['upload-files']);
});

gulp.task('default', ['clean'], function() {
  gulp.start('styles', 'scripts', 'images', 'replace');
});

gulp.task('test', function() {
  gulp.start('styles-test', 'scripts-test');
});

gulp.task('zip', function() {
  gulp.src('**', { cwd: path.join(process.cwd(), pkg.name)})
    .pipe(zip(pkg.name + '-wp.zip'))
    .pipe(gulp.dest('.'));
});

gulp.task('upload', function () {
  gulp.src('**', { cwd: path.join(process.cwd(), pkg.name)})
    .pipe(ftp({
      host: ftplogin.host,
      user: ftplogin.user,
      pass: ftplogin.pass,
      remotePath: ftplogin.path
    }));
});

gulp.task('upload-css', ['styles'], function() {
  gulp.src('**', { cwd: path.join(process.cwd(), pkg.name + '/css')})
    .pipe(ftp({
      host: ftplogin.host,
      user: ftplogin.user,
      pass: ftplogin.pass,
      remotePath: ftplogin.path
    }));
});

gulp.task('upload-js', ['scripts'], function() {
  gulp.src('**', { cwd: path.join(process.cwd(), pkg.name + '/js')})
    .pipe(ftp({
      host: ftplogin.host,
      user: ftplogin.user,
      pass: ftplogin.pass,
      remotePath: ftplogin.path
    }));
});

gulp.task('upload-images', ['images'], function() {
  gulp.src('**', { cwd: path.join(process.cwd(), pkg.name + '/images')})
    .pipe(ftp({
      host: ftplogin.host,
      user: ftplogin.user,
      pass: ftplogin.pass,
      remotePath: ftplogin.path
    }));
});

gulp.task('upload-files', ['replace'], function() {
  gulp.src('*', { cwd: path.join(process.cwd(), pkg.name)})
    .pipe(ftp({
      host: ftplogin.host,
      user: ftplogin.user,
      pass: ftplogin.pass,
      remotePath: ftplogin.path
    }));
});