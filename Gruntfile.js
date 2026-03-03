/**
 * Gruntfile for tool_tinycustomizer.
 *
 * Provides AMD build tasks that match Moodle's standard tooling.
 * Run `npm install` then `npx grunt amd` to compile AMD modules.
 *
 * @package tool_tinycustomizer
 */

'use strict';

module.exports = function(grunt) {

    // Load Grunt plugins.
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-eslint');

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        eslint: {
            amd: {
                src: ['amd/src/**/*.js'],
                options: {
                    configFile: '.eslintrc',
                },
            },
        },

        uglify: {
            amd: {
                options: {
                    sourceMap: true,
                    sourceMapName: function(filepath) {
                        return filepath + '.map';
                    },
                    compress: {
                        drop_console: false,
                    },
                    mangle: true,
                    banner: '// This file is part of Moodle - http://moodle.org/\n',
                },
                files: [{
                    expand: true,
                    cwd: 'amd/src',
                    src: ['*.js', '!*.min.js'],
                    dest: 'amd/build',
                    ext: '.min.js',
                }],
            },
        },
    });

    // Register tasks.
    grunt.registerTask('amd', ['eslint:amd', 'uglify:amd']);
    grunt.registerTask('default', ['amd']);
};
