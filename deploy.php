<?php
namespace Deployer;

require 'recipe/symfony4.php';

// Project name
set('application', 'depense.net');

// Project repository
set('repository', 'git@github.com:depense/depense.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts

host('depense.net')
    ->user('radhi')
    ->set('deploy_path', '/var/www/{{application}}');

// Tasks

task('deploy:env', function () {
    run('cd {{release_path}} && {{bin/composer}} dump-env prod');
});

after('deploy:writable', 'deploy:env');


// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

