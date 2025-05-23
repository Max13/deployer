<!-- DO NOT EDIT THIS FILE! -->
<!-- Instead edit recipe/codeigniter4.php -->
<!-- Then run bin/docgen -->

# How to Deploy a Codeigniter 4 Project

```php
require 'recipe/codeigniter4.php';
```

[Source](/recipe/codeigniter4.php)

Deployer is a free and open source deployment tool written in PHP. 
It helps you to deploy your Codeigniter 4 application to a server. 
It is very easy to use and has a lot of features. 

Three main features of Deployer are:
- **Provisioning** - provision your server for you.
- **Zero downtime deployment** - deploy your application without a downtime.
- **Rollbacks** - rollback your application to a previous version, if something goes wrong.

Additionally, Deployer has a lot of other features, like:
- **Easy to use** - Deployer is very easy to use. It has a simple and intuitive syntax.
- **Fast** - Deployer is very fast. It uses parallel connections to deploy your application.
- **Secure** - Deployer uses SSH to connect to your server.
- **Supports all major PHP frameworks** - Deployer supports all major PHP frameworks.

You can read more about Deployer in [Getting Started](/docs/getting-started.md).

The [deploy](#deploy) task of **Codeigniter 4** consists of:
* [deploy:prepare](/docs/recipe/common.md#deploy-prepare) – Prepares a new release
  * [deploy:info](/docs/recipe/deploy/info.md#deploy-info) – Displays info about deployment
  * [deploy:setup](/docs/recipe/deploy/setup.md#deploy-setup) – Prepares host for deploy
  * [deploy:lock](/docs/recipe/deploy/lock.md#deploy-lock) – Locks deploy
  * [deploy:release](/docs/recipe/deploy/release.md#deploy-release) – Prepares release
  * [deploy:update_code](/docs/recipe/deploy/update_code.md#deploy-update_code) – Updates code
  * [deploy:env](/docs/recipe/deploy/env.md#deploy-env) – Configure .env file
  * [deploy:shared](/docs/recipe/deploy/shared.md#deploy-shared) – Creates symlinks for shared files and dirs
  * [deploy:writable](/docs/recipe/deploy/writable.md#deploy-writable) – Makes writable dirs
* [deploy:vendors](/docs/recipe/deploy/vendors.md#deploy-vendors) – Installs vendors
* [spark:optimize](/docs/recipe/codeigniter4.md#spark-optimize) – Optimize for production.
* [spark:migrate](/docs/recipe/codeigniter4.md#spark-migrate) – Locates and runs all new migrations against the database.
* [deploy:publish](/docs/recipe/common.md#deploy-publish) – Publishes the release
  * [deploy:symlink](/docs/recipe/deploy/symlink.md#deploy-symlink) – Creates symlink to release
  * [deploy:unlock](/docs/recipe/deploy/lock.md#deploy-unlock) – Unlocks deploy
  * [deploy:cleanup](/docs/recipe/deploy/cleanup.md#deploy-cleanup) – Cleanup old releases
  * [deploy:success](/docs/recipe/common.md#deploy-success) – Deploys your project


The codeigniter4 recipe is based on the [common](/docs/recipe/common.md) recipe.

## Configuration
### public_path
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L10)

Overrides [public_path](/docs/recipe/provision/website.md#public_path) from `recipe/provision/website.php`.

Default Configurations

```php title="Default value"
'public'
```


### shared_dirs
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L12)

Overrides [shared_dirs](/docs/recipe/deploy/shared.md#shared_dirs) from `recipe/deploy/shared.php`.



```php title="Default value"
['writable']
```


### shared_files
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L14)

Overrides [shared_files](/docs/recipe/deploy/shared.md#shared_files) from `recipe/deploy/shared.php`.



```php title="Default value"
['.env']
```


### writable_dirs
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L16)

Overrides [writable_dirs](/docs/recipe/deploy/writable.md#writable_dirs) from `recipe/deploy/writable.php`.



```php title="Default value"
[
    'writable/cache',
    'writable/debugbar',
    'writable/logs',
    'writable/session',
    'writable/uploads',
]
```


### log_files
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L24)



```php title="Default value"
'writable/logs/*.log'
```


### codeigniter4_version
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L26)



```php title="Default value"
$result = run('{{bin/php}} {{release_or_current_path}}/spark');
preg_match_all('/(\d+\.?)+/', $result, $matches);
return $matches[0][0] ?? 5.5;
```



## Tasks

### spark\:cache\:info {#spark-cache-info}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L94)

Shows file cache information in the current system.

Discover & Checks


### spark\:config\:check {#spark-config-check}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L97)

Check your Config values.




### spark\:env {#spark-env}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L100)

Retrieves the current environment, or set a new one.




### spark\:filter\:check {#spark-filter-check}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L103)

Check filters for a route.




### spark\:lang\:find {#spark-lang-find}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L106)

Find and save available phrases to translate.




### spark\:namespaces {#spark-namespaces}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L109)

Verifies your namespaces are setup correctly.




### spark\:phpini\:check {#spark-phpini-check}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L112)

Check your php.ini values.




### spark\:routes {#spark-routes}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L115)

Displays all routes.




### spark\:key\:generate {#spark-key-generate}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L123)

Generates a new encryption key and writes it in an `.env` file.

Actions


### spark\:optimize {#spark-optimize}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L126)

Optimize for production.




### spark\:publish {#spark-publish}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L129)

Discovers and executes all predefined Publisher classes.




### spark\:db\:create {#spark-db-create}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L137)

Create a new database schema.

Database and migrations.


### spark\:db\:seed {#spark-db-seed}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L140)

Runs the specified seeder to populate known data into the database.




### spark\:db\:table {#spark-db-table}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L143)

Retrieves information on the selected table.




### spark\:migrate {#spark-migrate}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L146)

Locates and runs all new migrations against the database.




### spark\:migrate\:refresh {#spark-migrate-refresh}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L149)

Does a rollback followed by a latest to refresh the current state of the database.




### spark\:migrate\:rollback {#spark-migrate-rollback}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L152)

Runs the "down" method for all migrations in the last batch.




### spark\:migrate\:status {#spark-migrate-status}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L155)

Displays a list of all migrations and whether they\'ve been run or not.




### spark\:cache\:clear {#spark-cache-clear}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L163)

Clears the current system caches.

Housekeeping


### spark\:debugbar\:clear {#spark-debugbar-clear}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L166)

Clears all debugbar JSON files.




### spark\:logs\:clear {#spark-logs-clear}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L169)

Clears all log files.




### spark\:custom {#spark-custom}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L176)

Run a custom spark command.

Custom Spark Command for shield or setting packages


### deploy {#deploy}
[Source](https://github.com/deployphp/deployer/blob/master/recipe/codeigniter4.php#L184)

Deploys your project.

Main deploy task.


This task is group task which contains next tasks:
* [deploy:prepare](/docs/recipe/common.md#deploy-prepare)
* [deploy:vendors](/docs/recipe/deploy/vendors.md#deploy-vendors)
* [spark:optimize](/docs/recipe/codeigniter4.md#spark-optimize)
* [spark:migrate](/docs/recipe/codeigniter4.md#spark-migrate)
* [deploy:publish](/docs/recipe/common.md#deploy-publish)


