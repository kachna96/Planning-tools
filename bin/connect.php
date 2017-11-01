<?php
	define('HOST', 'webhosting.sspu-opava.cz');
	define('USERNAME', 'c78it1113kacmar');
	define('PASSWORD', 'darkorbit');
	define('DBNAME', 'c78it1113kacmar');
		
	if(@mysql_connect(HOST,USERNAME,PASSWORD)){
		if(!mysql_select_db(DBNAME))
			die();
		mysql_query('SET NAMES utf8');
	}
	else
		die();
 ?>