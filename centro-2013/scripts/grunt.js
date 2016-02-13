module.exports = function(grunt) {

	// Project configuration.
	grunt.initConfig({
		// Lists of files to be concatenated, used by the "concat" task.
		concat: {
			dist: {
				src: [
					'../js/centro/utils.js',
					'../js/centro/modal.js',
					'../js/centro/modules.js',
					'../js/centro/jquery.plugins.js'
				],
				dest: '../js/bin/centro.all.js'
			}
		},
		shell: {
			copyjs: {
				command: 'cp ../js/bin/centro.all.js ../js/bin/centro.all.jscopy'
			}
		},
		jsdoc: {
			dev: {
				src: ['../js/centro/*.js'],
				dest: 'doc'
			}
		},
		// Lists of files to be linted with JSHint, used by the "lint" task.
		lint: {
			all: ['grunt.js', '../js/centro/**/*.js']
		},
		min: {
			dist: {
				src: ['../js/bin/centro.all.js'],
				dest: '../js/bin/centro.min.js'
			}
		},
		jshint: {
			options: {
				browser: true
			}
		}
	});

	grunt.loadNpmTasks('grunt-shell');
	//grunt.loadNpmTasks('grunt-jsdoc-plugin');
	// Default task.
	grunt.registerTask('default', 'lint concat min');
	//grunt.registerTask('default', 'concat min jsdoc:dev');
};