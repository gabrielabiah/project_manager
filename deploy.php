<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config
set('ssh_type', 'native');
set('ssh_multiplexing', false);

// Project name
set('application', 'ProjectManager');

set('repository', 'https://github.com/gabrielabiah/project_manager.git');

add('shared_files', []);
add('shared_dirs', []);
//add('writable_dirs', []);

set('allow_anonymous_stats', false);

// Hosts

host('gabe@212.24.100.38')
    ->set('deploy_path', '/var/www/manage.gabeshub.com');

// Hooks
task('build', function () {
    run('cd {{release_path}} && build');
});

after('deploy:failed', 'deploy:unlock');


// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');
