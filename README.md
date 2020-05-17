# Install

## Requirement
1. PHP >= 5.6
2. Apache, MySQL
3. Composer


## Install

1. Run `$ composer update` to update dependency package

2. Edit `config/database.php` for environment as database config

3. Edit `config/config.php` for `disable/enable` debug mode

4. Edit `public/index.php` for switch development and production. Note, with production environment, `config/production/config.php` is used

## Migrate and Seed Database

1. Support `php cli` command like : `migrate`, `generate`, `seed`

2. Edit `config/migration.php`
   In the config variable : `$config['migration_version']`, set version to 20151229161829 (the number of lastest migrate file)

3. Run `$ php cli migrate` to migrate database. Surely that you have already create database in MySQL and config in `config/database.php`

4. Option: 
 - If you want fake data for testing, run `$ php cli seed`
 - If you want to reset the database: set `$config['migration_version']` to 0 and run `$ php cli migrate`