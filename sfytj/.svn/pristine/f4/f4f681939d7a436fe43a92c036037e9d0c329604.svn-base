/*!
 * gulp
 * $ npm install gulp-ruby-sass gulp-autoprefixer gulp-minify-css gulp-jshint gulp-concat gulp-uglify gulp-notify gulp-rename gulp-livereload gulp-cache del gulp-webserver --save-dev
 */

// Load plugins
var gulp = require('gulp'),
    sass = require('gulp-ruby-sass')
    // autoprefixer = require('gulp-autoprefixer'),
    minifycss = require('gulp-minify-css'),
    // jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    // imagemin = require('gulp-imagemin'),
    // pngquant = require('imagemin-pngquant');
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    cache = require('gulp-cache'),
    livereload = require('gulp-livereload'),
    del = require('del'),
    webserver  = require('gulp-webserver');

    //开启本地 Web 服务器功能
gulp.task('webserver', function() {
  gulp.src( './' )
    .pipe(webserver({
      livereload:       true,
      directoryListing: false,
      open:'sfytj/dist/html/common/index.html'
    }));
});
  
//拷贝html和jpg图片
gulp.task('copy', function () {
    gulp.src('src/html/**/*')
    .pipe(gulp.dest('C:/xampp/htdocs/sfytj/dist/html'));
    gulp.src('src/html/**/*')
    .pipe(gulp.dest('sfytj/dist/html'));
    gulp.src('src/images/**/*')
    .pipe(gulp.dest('C:/xampp/htdocs/sfytj/dist/images')); 
    gulp.src('src/images/**/*')
    .pipe(gulp.dest('sfytj/dist/images'));
});

// 编译sass并压缩合并
gulp.task('styles',  function() {
    return sass('src/styles/main.scss', { style: 'expanded' })
        // .pipe(autoprefixer('last 2 version'))
        .pipe(gulp.dest('C:/xampp/htdocs/sfytj/dist/styles'))
        .pipe(gulp.dest('sfytj/dist/styles'))
        .pipe(rename({ suffix: '.min' }))
        .pipe(minifycss())
        .pipe(gulp.dest('C:/xampp/htdocs/sfytj/dist/styles'))
        .pipe(gulp.dest('sfytj/dist/styles'));

});

// 检查js并压缩合并及混淆
gulp.task('scripts', function() {
    return gulp.src('src/scripts/**/*.js')
        // .pipe(jshint('.jshintrc'))
        // .pipe(jshint.reporter('default'))
        .pipe(concat('main.js'))
        .pipe(gulp.dest('C:/xampp/htdocs/sfytj/dist/scripts'))
        .pipe(gulp.dest('sfytj/dist/scripts'))
        .pipe(rename({ suffix: '.min' }))
        .pipe(uglify())
        .pipe(gulp.dest('C:/xampp/htdocs/sfytj/dist/scripts'))
        .pipe(gulp.dest('sfytj/dist/scripts'));

});

// 压缩图片除jpg
// gulp.task('images', function() {
//   return gulp.src('src/images/**/*.{gif,png,svg}')
//         .pipe(imagemin({
//             progressive: true,
//             svgoPlugins: [{removeViewBox: false}],
//             use: [pngquant()]
//         }))
//         .pipe(gulp.dest('C:/xampp/htdocs/sfytj/dist/images'));
     
// });

// 清理目标文件夹
gulp.task('clean', function() {
          return del(['sfytj/dist/styles', 'sfytj/dist/scripts', 'sfytj/dist/images','sfytj/dist/html']);
         });

// Default task
gulp.task('default', ['clean'], function() {
  gulp.start('styles', 'scripts', 'copy');
  
});

// 监听文件变化
gulp.task('watch', function() {

  // Watch .scss files
  gulp.watch('src/styles/**/*.scss', ['styles','copy']);

  // Watch .js files
  gulp.watch('src/scripts/**/*.js', ['scripts','copy']);

  // Watch image files
  gulp.watch('src/images/**/*', ['copy']);
  
  // Watch html files
  gulp.watch('src/html/**/*', ['copy']);

  // Create LiveReload server
  livereload.listen();

  // Watch any files in dist/, reload on change
  gulp.watch(['dist/**']).on('change', livereload.changed);

});