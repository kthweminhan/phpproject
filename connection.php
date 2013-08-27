<?php
function dbconnection(){
$con=mysql_connect("localhost","root","");
	
	if(!$con){
		die ('Could not connect:'.mysql_error());
	}
	
		//db select
		mysql_select_db("ojt12_db",$con);
	

	return $con;
}	
?>	