<?php
##############################
# SMTP config
#############################

/*local environment*/
if($_SERVER['HTTP_HOST'] == "localhost"){
	define('mail_host','smtp.gmail.com');
	define('mail_user',' togainbux@gmail.com');
	define('mail_pass','sudany2ptc');
	define('mail_from',' togainbux@gmail.com');
	define('mail_port',25);

}else{

	/*Online environment*/
	define('mail_host','mail.ikhrbshat.com');
	define('mail_user','info@ikhrbshat.com');
	define('mail_pass',')b_gNI),]bco');
	define('mail_from','info@ikhrbshat.com');
	define('mail_port',25);
}