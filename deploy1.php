<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('ssh_type', 'native');
set('ssh_multiplexing', false);

// Project name
set('application', 'Project Manager');

set('repository', 'https://github.com/gabrielabiah/project_manager.git');

// [Optional] Allocate tty for git clone. Default value is false.
//set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
//add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts

host('212.24.100.38')
    ->user('gabe')
    ->set('deploy_path', '/var/www/manage.gabeshub.com');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

set('INFOBIP_SENDER', 'ManifestGH');
set('INFOBIP_AUTHORIZATION', 'App 865fa27b33c56088e36794ca4a0940cb-266ba4c1-1eb8-4968-9e40-6a7feee6e684');
task('notify', function(){

    //SEND SMS
    $destination="233546747672";
    $message="Dear Osei, app deployment completed successfully for 1blockghana.com. Thank you.";
    $sender=get('INFOBIP_SENDER');
    $authorization=get('INFOBIP_AUTHORIZATION');
    $response= SMSnotify($destination, $message, $sender, $authorization);
    $destination="233204179139";
    $message="Deployment was successful for 1blockghana.com";
    $sender=get('INFOBIP_SENDER');
    $authorization=get('INFOBIP_AUTHORIZATION');

    $response= SMSnotify($destination, $message, $sender, $authorization);
    write('Sending SMS Notification');

    print_r($response);
    });
task('phprestart', function(){
    run('sudo service php7.4-fpm reload');

});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

//before('deploy:symlink', 'artisan:migrate');

