<?php 
	if(!isset($_GET['layouts']) ||  $_GET['layouts'] == ''){
		$erros = 1;

 ?>
<!DOCTYPE html>
<html>
<head>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
  crossorigin="anonymous" type="text/javascript"></script>
	<meta name="charset" content="utf-8">
	<!-- <link rel="stylesheet" href="autocomplete/autocomplete.min.css" type="text/css"> -->
	<link rel="stylesheet" href="css/estilo.css" type="text/css">
	<!-- <script src="autocomplete/autocomplete.min.js"></script> -->
	<title>Gerador SASS</title>
</head>
<body>
	<div class="container">
			<label>Layouts: <input type="text" name="layouts" id="inputLay"></label>
			<button id="addBtn" type="button">Adicionar!</button>
		<br><br><br>
		<div style="border: solid 1px red; padding: 13px 25px;">
			<span>Transpilar: </span>
			<ul id="lstLayouts">
			</ul>
			<img src="img/loading.gif" id="loading" style="display: none;" alt="loading" width="25">
			<button id="transpBtn" type="button">Run!</button>
		</div>
		<br><br>
		<div id="resultado"></div>
	</div>


<script type="text/javascript">
	lstLayouts= $('#lstLayouts');
	btnRun = 	$('#transpBtn');
	btnLayouts= $('#addBtn');
	inputLay = 	$('#inputLay');
	load = 		$('#loading');
	
	// var words = ['cicles_radar', 'fixa-tools', 'corecasa', 'vivano', 'dcm', 'bazarte'];

	// $(document).ready(function(){
	// 	inputLay.autocomplete({
	// 		hints: words,
	// 		placeholder: 'Insira...'

	// 	});
	// });
	function li2Arr(){
		return lstLayouts.children("li");
	}
	function hasLi(){
		var lis = li2Arr();
		if (lis.length > 0 && lis.length !== undefined) {
			return true;
		}
		return false;
	}
	function collectList(){
		if(hasLi()){
			var arr = li2Arr(), lst = Array();
			for (var i = 0; i < arr.length; i++) {
				lst[i] = arr[i].textContent;
			}
			return lst;
		}
		return false;
	}
	function thereIs(nome){
		if(hasLi()){
			r = collectList();	
			for (var i = 0; i <= r.length - 1; i++) {
				if (r[i] == nome){
					return true;
				}
			}
		}
		return false;
	}
	function checkInput(layout){
		if(thereIs(layout)){
			alert("Nome já foi inserido!");
		}
		else if (layout == 0 || layout === undefined) {	
			alert("Insira um layout válido!");
		}
		else{
			return true;
		}
	}
	function addLayout(layout){
		var template = layout.trim().trim();
		var li = document.createElement('li');
		$(li).html(template);
		lstLayouts.append(li);
	}
	function onProcess(itsProcessing){
		if(itsProcessing){
			btnRun.attr('disabled', 'disabled');
			load.css('display', 'inline-block');
		}else{
	        btnRun.attr('disabled', false);
			load.css('display', 'none');		
		}
	}
	function runGulp(layoutList){
		var xmlhttp = new XMLHttpRequest();
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	                document.getElementById("resultado").innerHTML = document.getElementById("resultado").innerHTML + this.responseText;
	                onProcess(false);
	            }
	        };
	        xmlhttp.open("GET", "index.php?layouts=" + layoutList, true);
        	xmlhttp.send();
	}
	//
	//
	//
	function letsGo(){	
		if(checkInput(inputLay.val())){
			addLayout(inputLay.val());
		}
		inputLay.val('');
	}
	//
	//	Events
	//
	inputLay.on('keyup', function(event) {
	    if (event.keyCode == 13 || event.keyCode == 32) {
	    	letsGo();
	    }
	});
	btnLayouts.on('click', function(event){
		letsGo();
	});
	// 
	btnRun.on('click', function(){
		if(hasLi()){
			onProcess(true);
			runGulp(collectList());
		}
		else
			checkInput('0');
	});
</script>
</body>
</html>


<?php 
}else {


  // ini_set('display_errors', 1);
  // ini_set('display_startup_errors', 1);
  // error_reporting(E_ALL);
	
	// $_POST['layouts'];
	// $layouts = Array('cicles-radar', 'bazarte');
	$layouts = explode(',',$_GET['layouts']);

	if(sizeof($layouts) > 0 &&  is_array($layouts)) {
		$erros = 0;

		foreach ($layouts as $layout) {

			$output = "<p>";
			$output .= "<br>---------------------   Início - ".$layout."   ------------------<br><br>";

			$txt = "
			    
			    // template a ser gerenciado
			    var template = '" . $layout . "';

			    // Template DIR
			    var templateDir = 'templates/' + template;
			    
			    // BASE DIR
			    var baseDir = 'C:/xampp/htdocs/responsivo/'; 

			    // CSS files DIR
			    var cssDir  = templateDir + '/css';

			    // SASS files DIR 
			    var sassDir = templateDir + '/sass';

			    // Images files DIR
			    var imgDir  = templateDir + '/images';


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
			    gulp.task('deploy', gulpSequence('clean', 'scaffold', 'styles-deploy', 'scripts-deploy', 'html-deploy'));";


	    		$gulpfile = fopen("gulpfile.js", "w") or die("Impossível abrir o arquivo, verifique gulpfile.js");
				fwrite($gulpfile, $txt);
				fclose($gulpfile);


				$output .= shell_exec('gulp sass');
				$output .= "<br><br>----------------------   FIM - <strong style='color:red;text-transform: uppercase;'>". $layout ."</strong>   ------------------------<br><br><br>";
				$output .= "</p>";
				$output = preg_replace('/\[[0-9][0-9]:[0-9][0-9]:[0-9][0-9]\]/', '', $output);
				$output = str_replace('Using gulpfile C:\xampp\htdocs\responsivo\gulp\gulpfile.js', '&nbsp;&nbsp;&nbsp;', $output);
				
				print_r($output);
		}

		$msg = "----------------------------------------------------------------------";
		$msg .= "<span style='color: green; font-size: 20px; font-weight: 700;'>&nbsp;&nbsp;&nbsp;Finalizado com sucesso!&nbsp;&nbsp;&nbsp;</span>";
		$msg .= "----------------------------------------------------------------------";

		// fwrite(fopen("logGulp.log", "a"), print_r($msg, true));
		// fclose("logGulp.log");
	}
	$errMsg = "<span style='color: red; font-size: 20px; font-weight: 700;'>&nbsp;&nbsp;&nbsp;Ocorreu um erro.<br> Verifique os layouts inseridos.</span>";


	print_r(($erros ? $errMsg : $msg)); 

}
 ?>