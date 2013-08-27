<?php
include('country.html.php');
$con=mysql_connect("localhost","root","");
		if(!$con){
			die('Could not connect:'.mysql_error());
		}
		mysql_select_db("ojt12_db",$con);

$sql="select * from country";
//echo var_dump($sql);

$res=mysql_query($sql,$con);
//$rows=mysql_fetch_array($res);
while ($row=mysql_fetch_assoc($res)){
	$rows[]=$row;
}
HTML::displaycountry($rows);
?>

