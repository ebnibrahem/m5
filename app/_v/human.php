<?php
ob_start();
session_start();

$_SESSION['captcha'] =  rand(999,9999);

$my_img = imagecreate( 80, 32 );
$background = imagecolorallocate( $my_img, 243, 99, 133 );
$text_colour = imagecolorallocate( $my_img, 251, 255, 255 );

imagestring( $my_img,20,20,8, $_SESSION['captcha'], $text_colour );
imagesetthickness ( $my_img, 20 );

header( "Content-type: image/png" );
imagepng( $my_img );
imagecolordeallocate( $text_color );
imagecolordeallocate( $background );
?>
