<?php

declare(strict_types=1);

namespace Deployer;

use function Deployer\Support\escape_shell_argument;

set('use_global_ssl', false);

set('domain', function () {
    return ask(' Domain: ', get('hostname'));
});

set('public_path', function () {
    return ask(' Public path: ', 'public');
});

desc('Configures a server');
task('provision:server', function () {
    set('remote_user', get('provision_user'));
    run('usermod -a -G www-data ssl-certs caddy');
    run("mkdir -p /var/deployer");
    $html = file_get_contents(__DIR__ . '/404.html');
    run("echo $'$html' > /var/deployer/404.html");
})->oncePerNode();

desc('Provision website');
task('provision:website', function () {
    $useGlobalSsl = get('use_global_ssl');
    $restoreBecome = become('deployer');

    run("[ -d {{deploy_path}} ] || mkdir -p {{deploy_path}}");
    run("chown -R deployer:deployer {{deploy_path}}");

    set('deploy_path', run("realpath {{deploy_path}}"));
    cd('{{deploy_path}}');

    run("[ -d log ] || mkdir log");
    run("chgrp caddy log");

    $caddyfile = parse(file_get_contents(__DIR__ . '/Caddyfile'));

    if (test('[ -f Caddyfile ]')) {
        run("echo $'$caddyfile' > Caddyfile.new");
        $diff = run('diff -U5 --color=always Caddyfile Caddyfile.new', ['no_throw' => true]);
        if (empty($diff)) {
            run('rm Caddyfile.new');
        } else {
            info('Found Caddyfile changes');
            writeln("\n" . $diff);
            $answer = askChoice(' Which Caddyfile to save? ', ['old', 'new'], 0);
            if ($answer === 'old') {
                run('rm Caddyfile.new');
            } else {
                run('mv Caddyfile.new Caddyfile');
            }
        }
    } else {
        run("echo $'$caddyfile' > Caddyfile");
    }

    if ($useGlobalSsl) {
        run('head -n1 Caddyfile > Caddyfile.new');
        run('echo "  tls /etc/ssl/private/caddy.pem /etc/ssl/private/caddy.key" >> Caddyfile.new');
        run('tail -n+2 Caddyfile >> Caddyfile.new');
        run('mv Caddyfile.new Caddyfile');
    }

    $restoreBecome();

    if (!test("grep -q 'import {{deploy_path}}/Caddyfile' /etc/caddy/Caddyfile")) {
        run("echo 'import {{deploy_path}}/Caddyfile' >> /etc/caddy/Caddyfile");
    }
    run('service caddy reload');

    info("Website {{domain}} configured!");
})->limit(1);

desc('Shows access logs');
task('logs:access', function () {
    run('tail -f {{deploy_path}}/log/access.log');
})->verbose();

desc('Shows caddy syslog');
task('logs:caddy', function () {
    run('sudo journalctl -u caddy -f');
})->verbose();
