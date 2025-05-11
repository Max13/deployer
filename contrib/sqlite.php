<?php

/*
## Configuration

- `sqlite_path`: path to the sqlite file, used to fix permissions and make it shared.

 */

namespace Deployer;

desc('Prepare Sqlite database for deployment');
task('deploy:prepare-sqlite', function () {
    $sqlite_path = get('sqlite_path');

    run("touch {{deploy_path}}/$sqlite_path");

    add('shared_files', [$sqlite_path]);
});

desc('Adds Sqlite database to the shared files, and set its permissions');
task('deploy:sqlite-permissions', function () {
    $originalRemote = get('remote_user');
    $sqlite_path = get('sqlite_path');
    set('remote_user', get('provision_user'));

    run("chown -R www-data:www-data {{deploy_path}}/shared/$(dirname $sqlite_path)");
    run("chmod 775 {{deploy_path}}/shared/$(dirname $sqlite_path)");
    run("chmod 664 {{deploy_path}}/shared/$sqlite_path");

    set('remote_user', $originalRemote);
});

before('deploy:shared', 'deploy:prepare-sqlite');
after('deploy:shared', 'deploy:sqlite-permissions');
