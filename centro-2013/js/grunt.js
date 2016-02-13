module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    // Lists of files to be concatenated, used by the "concat" task.
    concat: {
      dist: {
        src: [
          'centro/**/*.js'
        ],
        dest: 'centro.all.js'
      }
    },
    shell: {
      copyjs: {
          command: 'cp centro.all.js centro.all.jscopy'
      }
    },
    jsdoc : {
        dev : {
            src: ['centro/*.js'], 
            dest: 'doc'
        }
    },
    // Lists of files to be linted with JSHint, used by the "lint" task.
    lint: {
      all: ['grunt.js', 'centro/**/*.js']
    },
    min: {
      dist: {
        src: ['centro.all.js'],
        dest: 'centro.min.js'
      }
    },
    jshint: {
      options: {
        browser: true
      }
    }
  });

  grunt.loadNpmTasks('grunt-shell');
  grunt.loadNpmTasks('grunt-jsdoc-plugin');
  
  // Default task.
  //grunt.registerTask('default', 'lint concat min');
  grunt.registerTask('default', 'concat min jsdoc:dev');

};