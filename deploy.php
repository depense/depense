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

host('prod')
    ->stage('production')
    ->hostname('depense.net')
    ->user('radhi')
    ->set('deploy_path', '/var/www/{{application}}')
    ->set('branch', 'master');

host('staging')
    ->stage('staging')
    ->hostname('staging.depense.net')
    ->user('radhi')
    ->set('deploy_path', '/var/www/staging.{{application}}')
    ->set('branch', 'dev')
    // Remove --no-dev flag
    ->set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader --no-suggest');

// Tasks

task('deploy:env', function () {
    run('cd {{release_path}} && {{bin/composer}} dump-env prod');
})->onStage('production');

after('deploy:writable', 'deploy:env');

task('deploy:test', function () {
    run('{{release_path}}/bin/phpunit');
})->onStage('staging');

after('deploy:cache:warmup', 'deploy:test');


// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

