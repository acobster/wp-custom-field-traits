/*global module:false*/
module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    // Task configuration.
    php: {
      test: {
        options: {
          keepalive: true,
          base: 'wordpress'
        }
      }
    },
    exec: {
      mysql: {
        cmd: 'mysql -u root -p < bootstrap.sql'
      },
      wp_config: {
        cwd: 'wordpress',
        cmd: '../vendor/bin/wp core config --dbname=wp_traits --dbuser=wp_traits --dbpass=password'
      },
      wp_install: {
        cwd: 'wordpress',
        cmd: '../vendor/bin/wp core install --url=localhost:8000 --title="WP Custom Traits" --admin_user=traits --admin_password=password --admin_email=me@example.com --skip-email'
      },
      wp_plugin_activate: {
        cwd: 'wordpress',
        cmd: '../vendor/bin/wp plugin activate wp-custom-field-traits'
      }
    },
    symlink: {
      plugin: {
        src: '.',
        dest: 'wordpress/wp-content/plugins/wp-custom-field-traits'
      }
    },
    clean: {
      dev: ['vendor', 'node_modules', 'wordpress']
    },

    /*
     * We *only* want the src libs for the Dust library.
     * Composer custom directories are not fine-grained enough for this,
     * so use grunt-contrib-copy
     */
    copy: {
      dust_php: {
        nonull: true,
        expand: true,
        cwd: 'vendor/dust-php/dust-php/src/',
        src: 'Dust/**',
        dest: 'lib/'
      }
    },
    watch: {
      gruntfile: {
        files: '<%= jshint.gruntfile.src %>',
        tasks: ['jshint:gruntfile']
      },
      lib_test: {
        files: '<%= jshint.lib_test.src %>',
        tasks: ['jshint:lib_test', 'nodeunit']
      }
    }
  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-composer');
  grunt.loadNpmTasks('grunt-exec');
  grunt.loadNpmTasks('grunt-php');
  grunt.loadNpmTasks('grunt-contrib-symlink');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-clean');

  // Install dev dependencies
  grunt.registerTask('install', [
    'composer:install',
    'copy',
    'exec:mysql',
    'exec:wp_config',
    'exec:wp_install',
    'symlink:plugin',
    'exec:wp_plugin_activate',
    'php'
  ]);
};
