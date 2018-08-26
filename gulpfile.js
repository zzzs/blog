var gulp = require('gulp');
var elixir = require('laravel-elixir');
var fs = require('fs');
var path = require('path');
//close *.css.map
elixir.config.sourcemaps = false;

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

gulp.task('less', function () {

	elixir(function(mix) {
		/*css*/
		mix.less('admin/articles.less','public/css/admin');
		mix.less('admin/main.less','public/css/admin');

		mix.less('home/articles.less','public/css/home');
		mix.less('home/main.less','public/css/home');

		mix.less([
			'common/md.less',
			'common/modal.less'
			],
			'public/css/common.css');

	});
});


gulp.task('js', function () {
	elixir(function(mix) {
	// 	// /*js*/
		mix.scriptsIn('resources/assets/js/common', 'public/js/common.js');
	// 	.scriptsIn('resources/assets/js/home/articles', 'public/js/home/articles.js');


	// 	mix.scripts(['admin/main.js'], 'public/js/admin/main.js')
	// 	.scripts(['admin/articles/comments.js'], 'public/js/admin/articles/comments.js')
	// 	.scripts(['admin/articles/edit.js'], 'public/js/admin/articles/edit.js')
	// 	.scripts(['admin/articles/recommends.js'], 'public/js/admin/articles/recommends.js')

	});

});

gulp.task('default',['less', 'js']);
