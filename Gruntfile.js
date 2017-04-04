module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        uglify: {
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            build: {
                files: {
                    'public_html/js/app.min.js': ['public_html/app/*.module.js', 'public_html/app/**.js'],
                    'public_html/js/elements.min.js': ['public_html/modules/elements/*.module.js', 'public_html/modules/elements/**.js']
                }
            }
        },
        copy: {
            all: {
                files: [
                    // angular
                    {src: ['bower_components/angular/angular.js'], dest: 'public_html/js/angular.js'},
                    {src: ['bower_components/angular/angular.min.js'], dest: 'public_html/js/angular.min.js'},
                    // angular route
                    {src: ['bower_components/angular-route/angular-route.js'], dest: 'public_html/js/angular-route.js'},
                    {src: ['bower_components/angular-route/angular-route.min.js'], dest: 'public_html/js/angular-route.min.js'},
                    // angular material
                    {src: ['bower_components/angular-animate/angular-animate.min.js'], dest: 'public_html/js/angular-animate.min.js'},
                    {src: ['bower_components/angular-aria/angular-aria.min.js'], dest: 'public_html/js/angular-aria.min.js'},
                    {src: ['bower_components/angular-messages/angular-messages.min.js'], dest: 'public_html/js/angular-messages.min.js'},
                    {src: ['bower_components/angular-material/angular-material.min.js'], dest: 'public_html/js/angular-material.min.js'},
                    {src: ['bower_components/angular-material/angular-material.min.css'], dest: 'public_html/css/angular-material.min.css'},
                    {src: ['bower_components/angular-animate/angular-animate.js'], dest: 'public_html/js/angular-animate.js'},
                    {src: ['bower_components/angular-aria/angular-aria.js'], dest: 'public_html/js/angular-aria.js'},
                    {src: ['bower_components/angular-messages/angular-messages.js'], dest: 'public_html/js/angular-messages.js'},
                    {src: ['bower_components/angular-material/angular-material.js'], dest: 'public_html/js/angular-material.js'},
                    {src: ['bower_components/angular-material/angular-material.css'], dest: 'public_html/css/angular-material.css'},
                    // material icons
                    {src: ['bower_components/material-design-icons/www/css/material.css'], dest: 'public_html/css/material.css'},
                    // lodash
                    {src: ['bower_components/lodash/dist/lodash.js'], dest: 'public_html/js/lodash.js'},
                    {src: ['bower_components/lodash/dist/lodash.min.js'], dest: 'public_html/js/lodash.min.js'},
                    // jquery
                    {src: ['bower_components/jquery/dist/jquery.js'], dest: 'public_html/js/jquery.js'},
                    {src: ['bower_components/jquery/dist/jquery.min.js'], dest: 'public_html/js/jquery.min.js'},
                    // bootstrap
                    {src: ['bower_components/bootstrap/dist/js/bootstrap.js'], dest: 'public_html/js/bootstrap.js'},
                    {src: ['bower_components/bootstrap/dist/js/bootstrap.min.js'], dest: 'public_html/js/bootstrap.min.js'},
                    {src: ['bower_components/bootstrap/dist/css/bootstrap.css'], dest: 'public_html/css/bootstrap.css'},
                    {src: ['bower_components/bootstrap/dist/css/bootstrap.min.css'], dest: 'public_html/css/bootstrap.min.css'},
                    // Font awesome
                    {src: ['bower_components/font-awesome/css/font-awesome.min.css'], dest: 'public_html/css/font-awesome.min.css'},
                    {src: ['bower_components/font-awesome/css/font-awesome.css'], dest: 'public_html/css/font-awesome.css'},
                    {src: ['bower_components/font-awesome/fonts/FontAwesome.otf'], dest: 'public_html/fonts/FontAwesome.otf'},
                    {src: ['bower_components/font-awesome/fonts/fontawesome-webfont.eot'], dest: 'public_html/fonts/fontawesome-webfont.eot'},
                    {src: ['bower_components/font-awesome/fonts/fontawesome-webfont.svg'], dest: 'public_html/fonts/fontawesome-webfont.svg'},
                    {src: ['bower_components/font-awesome/fonts/fontawesome-webfont.ttf'], dest: 'public_html/fonts/fontawesome-webfont.ttf'},
                    {src: ['bower_components/font-awesome/fonts/fontawesome-webfont.woff'], dest: 'public_html/fonts/fontawesome-webfont.woff'},
                    {src: ['bower_components/font-awesome/fonts/fontawesome-webfont.woff2'], dest: 'public_html/fonts/fontawesome-webfont.woff2'}
                ]
            }
        },
        processhtml: {
            prod: {
                files: {
                    'app/views/app.php': ['public_html/app/index.html']
                }
            },
            dev: {
                files: {
                    'app/views/app.php': ['public_html/app/index.html']
                }
            }
        },
        less: {
            dev: {
                options: {
                    banner: '/* Autogenerated CSS file. Do not modify. */'
                },
                files: {
                    'public_html/css/app.css': 'public_html/app/less/*.less',
                    'public_html/css/elements.css': 'public_html/modules/elements/*.less',
                    'public_html/css/notification.css': 'public_html/modules/notification/*.less'
                }
            },
            prod: {
                options: {
                    compress: true,
                },
                files: {
                    'public_html/css/app.css': 'public_html/app/less/*.less',
                    'public_html/css/elements.css': 'public_html/modules/elements/*.less',
                    'public_html/css/notification.css': 'public_html/modules/notification/*.less'
                }
            }
        }
    });

    // Load the plugin that provides the "uglify" task.
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-processhtml');
    grunt.loadNpmTasks('grunt-contrib-less');

    // Default task(s).
    grunt.registerTask('default', ['processhtml:dev', 'less:dev']);
    grunt.registerTask('production', ['processhtml:prod', 'less:prod', 'uglify']);
    grunt.registerTask('bower', ['copy:all']);

};