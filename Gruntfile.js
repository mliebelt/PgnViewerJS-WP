module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        clean: ['pgnviewerjs-wp.zip'],
        
        compress: {
            main: {
                options: {
                    archive: 'pgnviewerjs-wp.zip'
                },
                files: [
                    { src: 'css/**' },
                    { src: 'js/**'},
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