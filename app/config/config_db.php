<?php
########################
# Database config
#######################
use M5\MVC\Config;

/* >> Offline*/
if(current( explode(":",$_SERVER['HTTP_HOST'])) == "localhost"){

	Config::set("host", 'localhost');
	Config::set("db_name", 'blog');
	Config::set("user", 'root');
	Config::set("pass", '');
	Config::set("port", null);
}else{
	/* >> Online*/
	Config::set("host", 'localhost');
	Config::set("db_name", 'mic87_m_blog');
	Config::set("user", 'mic87_root');
	Config::set("pass", '15102431');

	Config::set("port", null);
}
