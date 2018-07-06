
			    
			    // template a ser gerenciado
			    var template = 'bella-vip';

			    // Template DIR
			    var templateDir = 'templates/' + template;
			    
			    // BASE DIR
			    var baseDir = 'C:/xampp/htdocs/responsivo/'; 

			    // CSS files DIR
			    var cssDir  = baseDir + templateDir + '/css';

			    // SASS files DIR 
			    var sassDir = baseDir + templateDir + '/sass';

			    // Images files DIR
			    var imgDir  = baseDir + templateDir + '/images';


			    //initialize all of our variables
			    var app, base, concat, directory, gulp, gutil, hostname, path, refresh, sass, uglify, imagemin, minifyCSS, del, browserSync, autoprefixer, gulpSequence, shell, sourceMaps, plumber;

			    var autoPrefixBrowserList = ['last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'];

			    var jsConcatList = ['ext/jquery/jquery-1.12.5.min.js'
			        ,'ext/jquery/jquery-migrate-1.4.1.min.js' 
			        ,'ext/jquery/ui/jquery-ui.min.js'
			        ,'ext/jquery/jquery.lazyload.js'
			        ,'ext/jquery/bxGallery/jquery.bxGallery.1.1.min.js'
			        ,'ext/jquery/fancybox/jquery.fancybox.pack.js'
			        ,'ext/js/superfish.js'
			        ,'ext/js/js.js'
			        ,'ext/jquery/jquery.equalheights.js'
			        ,'ext/nivo/jquery.nivo.slider.js'
			        ,'ext/jquery/jqtransformplugin/jquery.jqtransform.js'
			        ,'ext/jquery/jquery.stringball.js'
			        ,'ext/jquery/jquery.mask.min.js'
			        ,'ext/bootstrap/js/bootstrap.min.js'];

			    var cssConcatList = ['ext/jquery/fancybox/jquery.fancybox.css'
			            ,'css/wizard.css'
			            ,'ext/font-awesome/css/font-awesome.css'
			            ,'ext/bootstrap/css/bootstrap_loja.css'
			            ,'ext/css/mobilecss.css'
			            ,'ext/css/generalcss.css'
			            ,'ext/css/layoutcss.css'
			            ,'autocomplete/jquery.autocomplete.css'];
			    //load all of our dependencies
			    //add more here if you want to include more libraries
			    gulp        = require('gulp');
			    sass        = require('gulp-sass');
			    gutil       = require('gulp-util');
			    shell       = require('gulp-shell');
			    concat      = require('gulp-concat');
			    uglify      = require('gulp-uglify');
			    plumber     = require('gulp-plumber');
			    browserSync = require('browser-sync');
			    imagemin    = require('gulp-imagemin');
			    minifyCSS   = require('gulp-minify-css');
			    sourceMaps  = require('gulp-sourcemaps');
			    autoprefixer = require('gulp-autoprefixer');
			    gulpSequence = require('gulp-sequence').use(gulp);

			    gulp.task('browserSync', function() {
			        browserSync({
			            server: {
			                baseDir: baseDir
			            },
			            options: {
			                reloadDelay: 250
			            },
			            notify: true
			        });
			    });


			    //compressing images & handle SVG files
			    gulp.task('images', function(tmp) {
			        gulp.src([imgDir + '/*.jpg', imgDir + '/*.png'])
			            //prevent pipe breaking caused by errors from gulp plugins
			            .pipe(plumber())
			            .pipe(imagemin({ optimizationLevel: 5, progressive: true, interlaced: true }))
			            .pipe(gulp.dest(templateDir + '/images'));
			    });

			    //compressing images & handle SVG files
			    gulp.task('images-deploy', function() {
			        gulp.src([imgDir + '/*'])
			            //prevent pipe breaking caused by errors from gulp plugins
			            .pipe(plumber())
			            .pipe(gulp.dest(templateDir + '/images'));
			    });

			    //compiling our Javascripts
			    gulp.task('scripts', function() {
			        //this is where our dev JS scripts are
			        return gulp.src( jsConcatList )
			                    //prevent pipe breaking caused by errors from gulp plugins
			                    .pipe(plumber())
			                    //this is the filename of the compressed version of our JS
			                    .pipe(concat('app.e-store.js'))
			                    //catch errors
			                    .on('error', gutil.log)
			                    //where we will store our finalized, compressed script
			                    .pipe(gulp.dest('app/scripts'))
			                    //notify browserSync to refresh
			                    .pipe(browserSync.reload({stream: true}));
			    });

			    //compiling our Javascripts for deployment
			    gulp.task('scripts-deploy', function() {
			        //this is where our dev JS scripts are
			        return gulp.src( jsConcatList )
			                    //prevent pipe breaking caused by errors from gulp plugins
			                    .pipe(plumber())
			                    //this is the filename of the compressed version of our JS
			                    .pipe(concat('com.IC.e-store.concatJS.js'))
			                    //compress :D
			                    .pipe(uglify())
			                    //where we will store our finalized, compressed script
			                    .pipe(gulp.dest('dist/scripts'));
			    });

			    //compiling our sass files
			    gulp.task('sass', function() {
			        //the initializer / master sass file, which will just be a file that imports everything
			        console.log('-----------------------------   { CSS } ' + template + ' gerados com sucesso!   -----------------------------');
			        return gulp.src(sassDir + '/*.sass')
			                    //prevent pipe breaking caused by errors from gulp plugins
			                    .pipe(plumber({
			                      errorHandler: function (err) {
			                        console.log(err);
			                        this.emit('end');
			                      }
			                    }))
			                    //get sourceMaps ready
			                    //.pipe(sourceMaps.init())
			                    //include sass and list every 'include' folder
			                    .pipe(sass({
			                          errLogToConsole: true,
			                          includePaths: [
			                              sassDir + '/'
			                          ]
			                    }))
			                    .pipe(autoprefixer({
			                       browsers: autoPrefixBrowserList,
			                       cascade:  true
			                    }))
			                    //catch errors
			                    .on('error', gutil.log)
			                    //the final filename of our combined css file
			                    .pipe(concat('estilo.css'))
			                    // Minifying file
			                    .pipe(minifyCSS())
			                    //get our sources via sourceMaps
			                    //.pipe(sourceMaps.write())
			                    //where to save our final, compressed css file
			                    .pipe(gulp.dest( cssDir + '/' ))
			                    //notify browserSync to refresh
			                    //.pipe(browserSync.reload({stream: true}));
			    });

			    //compiling our sass files for deployment
			    gulp.task('styles-template', function() {
			        //the initializer / master sass file, which will just be a file that imports everything
			        console.log('-----------------------------   { CSS } ' + template + ' gerados com sucesso!   -----------------------------');
			        return gulp.src(sassDir + '/*.sass')
			                    .pipe(plumber())
			                    //include sass includes folder
			                    .pipe(sass({
			                          includePaths: [
			                              sassDir,
			                          ]
			                    }))
			                    .pipe(autoprefixer({
			                      browsers: autoPrefixBrowserList,
			                      cascade:  true
			                    }))
			                    //the final filename of our combined css file
			                    .pipe(concat('estilo.css'))
			                    .pipe(minifyCSS())
			                    //where to save our final, compressed css file
			                    .pipe(gulp.dest( cssDir ));
			    });


			    //  minifier your css files on css dir
			    gulp.task('styles-deploy', function() {
			        //the initializer / master sass file, which will just be a file that imports everything
			        return gulp.src( cssConcatList )
			            //prevent pipe breaking caused by errors from gulp plugins
			            .pipe(concat('concat.css'))
			                    .pipe(minifyCSS())
			            .pipe(plumber())
			            .pipe(gulp.dest('dist/styles' ));
			            console.log('-----------------------------   { CSS } externos concatenados com sucesso!   -----------------------------');
			    });

			    //basically just keeping an eye on all HTML files
			    gulp.task('html', function() {
			        //watch any and all HTML files and refresh when something changes
			        return gulp.src('index.html')
			            .pipe(plumber())
			            .pipe(browserSync.reload({
			                stream: true
			            }))
			            //catch errors
			            .on('error', gutil.log);
			    });

			    //migrating over all HTML files for deployment
			    gulp.task('html-deploy', gulp.series('styles-deploy', 'scripts-deploy', function() {

			        //grab everything, which should include htaccess, robots, etc
			        gulp.src('*.html')
			            //prevent pipe breaking caused by errors from gulp plugins
			            .pipe(plumber())
			            .pipe(gulp.dest('dist'));

			        //grab any hidden files too
			        gulp.src('*.html')
			            //prevent pipe breaking caused by errors from gulp plugins
			            .pipe(plumber())
			            .pipe(gulp.dest('dist'));

			        gulp.src(templateDir + '/font/*')
			            //prevent pipe breaking caused by errors from gulp plugins
			            .pipe(plumber())
			            .pipe(gulp.dest('dist/fonts'));
			        gulp.src( cssConcatList )
			            //prevent pipe breaking caused by errors from gulp plugins
			            .pipe(concat('concat.css'))
			                    .pipe(minifyCSS())
			            .pipe(plumber())
			            .pipe(gulp.dest('dist/styles' ));
			        console.log('-----------------------------   { CSS } externos concatenados com sucesso!   -----------------------------');
			    }));

			    //cleans our dist directory in case things got deleted
			    gulp.task('clean', function() {
			        return shell.task([
			          'rm -rf dist'
			        ]);
			    });

			    //create folders using shell
			    gulp.task('scaffold', function() {
			      return shell.task([
			          'mkdir dist',
			          'mkdir dist/fonts',
			          'mkdir dist/images',
			          'mkdir dist/scripts',
			          'mkdir dist/styles'
			        ]
			      );
			    });

			    //this is our master task when you run `gulp` in CLI / Terminal
			    //this is the main watcher to use when in active development
			    //  this will:
			    //  startup the web server,
			    //  start up browserSync
			    //  compress all scripts and sass files
			    gulp.task('default', gulp.series('browserSync', 'scripts', 'styles-template', function(styles) {
			        //a list of watchers, so it will watch all of the following files waiting for changes
			        gulp.watch('ext/**', ['scripts']);
			        gulp.watch(sassDir + '/**', ['styles-template']);
			        // gulp.watch(imgDir + '/**', ['images']);
			        gulp.watch('app/*.html', ['html']);
			    }));



			    //
			    //      Watching SASS FILES
			    //
			    gulp.task('watch', function(sass) {
			        //a list of watchers, so it will watch all of the following files waiting for changes
			        // gulp.watch('ext/**', ['scripts']);
			        console.log('-----------------------------   Watching ' + template + ' files...   -----------------------------');
			        gulp.watch(sassDir + '/**', gulp.series('sass'));
			        //gulp.watch(cssDir + '/**', ['styles-treat']);
			        // gulp.watch(imgDir + '/**', ['images']);
			        //gulp.watch('app/*.html', ['html']);
			    });

			    //this is our deployment task, it will set everything for deployment-ready files
			    gulp.task('deploy', gulpSequence('clean', 'scaffold', 'styles-deploy', 'scripts-deploy', 'html-deploy'));