<?php

namespace Deployer;

use function Deployer\Support\escape_shell_argument;
use function Deployer\Support\starts_with;

set('node_version', '23.x');

desc('Installs npm packages');
task('provision:node', function () {
    $originalUser = get('remote_user');
    set('remote_user', get('provision_user'));
    $nodeVersion = get('node_version');

    if (has('nodejs_version')) {
        throw new \RuntimeException('nodejs_version is deprecated, use node_version_version instead.');
    }

    run("curl -fsSL https://fnm.vercel.app/install | bash -s -- --install-dir /usr/local/bin --skip-shell");
    run("echo " . escape_shell_argument('eval "`fnm env`"') . " >> /etc/profile.d/fnm.sh");

    $restoreBecome = become($originalUser);

    run('fnm install ' . $nodeVersion);

    $restoreBecome();
})
    ->oncePerNode();
