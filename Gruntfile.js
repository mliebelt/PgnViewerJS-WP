module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        clean: ['PgnViewerJS-WP.zip'],
        
        compress: {
            main: {
                options: {
                    archive: 'PgnViewerJS-WP.zip'
                },
                files: [
                    { src: 'css/**' },
                    { src: 'fonts/**'},
                    { src: 'img/**'},
                    { src: 'js/**'},
                    { src: 'locales/**'},
                    { src: 'pgnviewerjs.php'},
                    { src: 'readme.txt'}
                ]
            }
        }

    });

    // Load the necessary tasks
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-compress');

    // Default task.
    grunt.registerTask('default', ['clean', 'compress:main']);

};