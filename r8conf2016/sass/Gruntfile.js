module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    watch: {
      sass: {
        files: ['*.{scss,sass}','_partials/**/*.{scss,sass}'],
        tasks: ['sass:dist']
        //tasks: ['takana:dist']
      },
      livereload: {
        files: ['../*.html', '../*.php', 'js/**/*.{js,json}', '../css/*.css','../img/**/*.{png,jpg,jpeg,gif,webp,svg}'],
        options: {
          livereload: true
        }
      }
    },
    autoprefixer: {
        all: {
            options: {
                browsers: ['> 5%', 'last 2 versions']
            },
            src: '../css/screen.css',
            dest: '../css/screen.css'
        }
    },
    sass: {
      options: {
        sourceComments: 'map',
        outputStyle: 'compressed',
        includePaths: ['bower_components/foundation/scss'],
        includePaths: require('node-bourbon').includePaths,
        includePaths: require('node-neat').includePaths,
      },
      dist: {
        files: {
          '../css/screen.css': 'main.sass',
          '../css/foundation.css': 'foundation.scss'
        }
      }
    }
   //takana: {
   //   dist: {
   //     options: {
   //       outputStyle: 'expanded'
   //     },
   //     files: {
   //       '../css/screen.css' : 'main.scss'
   //     }
   //   }
   // }
  });
  grunt.registerTask('default', ['sass:dist', 'watch']);
  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-autoprefixer');
  //grunt.loadNpmTasks('grunt-takana');
};