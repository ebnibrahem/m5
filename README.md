# M5
- PHP MVC Framework used design pattern and modern approaches of reused of code and DRY (dont repeat yourself).

## Installation

### Server Requirements
- PHP >= 5.5
- Mbstring PHP Extension

### Files:
1. unzip files.
https://github.com/ebnibrahem/m5/archive/master.zip

### Configuration

#### Database:
2. Open phpmyadmin and create your database and set collation as utf_general_ci.
3. open app/config/config_db.php and edit lines below :
- __ Online__
- Config::set("host", 'localhost');
- Config::set("db_name", 'DB_NAME');
- Config::set("user", 'USER');
- Config::set("pass", 'PASS');
- Config::set("port", null);

#### SMTP
4. open app/config/config_mail.php and edit
__Online environment__
- define('mail_host','mail.mailserver.com');
- define('mail_user','mailserveruser');
- define('mail_pass','password');
- define('mail_from','info@mail.com');
- define('mail_port',25);

#### Run Once:
- to make empty database.
5. open url: http://your_url/set  [To migrate database schema tables.]

6. Next after delete file : app/_c/set.php
7. admin area : http:\\your_url\admin
- default user: admin
- default pass: 1234

## Features:
- MVC design pattern.
- Multi-languages.
- supported Automatic routing and routes rules.
- supported Composer PHP dependencies management  prs-4 class_map.
- GUI to create controllers, models and views.
- Model singleton style.
- Provide A brief report about all application files status.
- Design By: __Mohammed ibrahem__. ebnibrahem@gmail.com


## Getstart:
### M5 Framework Overview:
- M5 framework consider MVC design pattern aproach  which separate programming logic (PHP files) from user interface (HTML files) and isolate databse layer form others.

### File structure:

- app/_c   : Controllers files.
- app/_m   : Models files.
- libs     : classes and functions.php
- assets   : images,js,css and fonts.
- string   : languages string. you can change from  app/config/Config.php
- upload   : upload path; you can change from app/init by edit UPLOAD_DIR Constant.
- vendor   : main composer folder to all PHP dependencies and packages.

### index.php
- M5\MVC\App::play(["url" => $_GET['url'],"status" => true]);
- status accept ture|false to show application status in bottom.

### Controllers
- all controller class file are stored in __app/_c__ and namespace M5\Controllers. Controller class name must start with Capital Letter.
- must create Class::index($params=[]) method in each controllers class.

#### share data between controllers and views
to Share data between controllers and views e.g dynamic nav pages, application information etc.
- add all shared data in M5\MVC\Shared::boot();
- as $data[$key].

#### Middleware ( Set access rule to contoller in inside (___c__) directory )
- add  in app/config/config.php;

### Models
- M5 Model used concept of singleton pattern, to create instant from Model :
- M5\MVC\Model::getInst($table_name,$show_error='',____METHOD____) ____METHOD____ : to seek target of an error in App;

### Views
- all views located in app/_v.
- no view engine used you can sperate your template in: widgets/header.php, widgets/footer.php

### Helper Libraies
- M5 provide built-in classes to facilitate in achieving some routines operations e.g database schema, send email, sessions, cookies ect..
- all classes located in libs\ directorey with namespace M5\Libray\
#### in libs\functions.php  your found more helpers.

###.. to be contiuned .. ###
