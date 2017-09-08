# M5
PHP MVC application used modern approaches of reused of code and DRY.

## Installation

#### Server Requirements
- PHP >= 5.5
- Mbstring PHP Extension

#### Installing M5
#### Files:
1. unzip files.

#### Configuration

##### Database:
2. create your database and set collation as utf_general_ci.
3. open app/config/config_db.php and edit :
__ Online__
- Config::set("host", 'localhost');
- Config::set("db_name", 'DB_NAME');
- Config::set("user", 'USER');
- Config::set("pass", 'PASS');
- Config::set("port", null);

##### SMTP
4. open app/config/config_mail.php and edit
__Online environment__
- define('mail_host','mail.mailserver.com');
- define('mail_user','mailserveruser');
- define('mail_pass','password');
- define('mail_from','info@mail.com');
- define('mail_port',25);

##### run once:
5. open url: http:\\your_url\set  [To migrate database schema tables.]
6. Next after delete file : app/_c/set.php
7. admin area : http:\\your_url\admin
- default user: admin
- default pass: 1234

## Features:
- MVC design pattern.
- Multi-languages.
- supported Automatic routing and routes rules.
- supported Composer PHP dependencies management.
- GUI to create controllers, models and views.

- Model singleton style.
- M5\MVC\Model::getInst("tbl","show_error",__METHOD__) : to seek target of an error in App;

- M5\MVC\App::play(["url" => $_GET['url'],"status" => true]);
- Set status as true to show bottom-application-status.


### Getstart:
#### File structure:

- app/_c   : Controllers files.
- app/_m   : Models files.
- app/_v   : Views files.
- app/core : core M5 framework files.
- libs     : classes and functions.php
- assets   : images,js,css and fonts.
- string   : languages string. you can change from  app/config/Config.php
- upload   : upload path; you can call path with define UPLOAD_DIR
- vendor   : main composer folder to all PHP dependencies and packages.

#### share data between controllers and views
- add all shared data in M5\MVC\Shared::boot();
- as $data[$key].

#### Set access rule to sub-directories (Middleware)
- add  in app/config/config.php;



