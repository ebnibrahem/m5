<?php

/* Routes Rules */

use M5\MVC\Route;

/**-----------------------------------------------
 ** traphic police man
 * -----------------------------------------------
 **/


Route::http('/','index');

Route::http('/blogs','blogs');

Route::http('/records','blogs');

Route::http('/about',function(){echo "<h3>M5 MVC FRAMEWORK RESTful API :)</h3>";});


// واصل على توجيه كل طلب لمتحكمه
Route::http('/blogs/{id}','blogs@one');
Route::http('/blogs/do/update/{id}','blogs@update');
