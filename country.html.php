<?php
class HTML{
	function displaycountry($tbl_country){
		
	?>
<html>
<head>
</head>
<body>
<select>
<form name="adminForm" action="country.php" method="POST"></form>
<option value="AF">Afginistan</option>
<?php
for($i=0;$i<count($tbl_country);$i++){
	?>
	<option value="<?php echo $tbl_country[$i]['country_code']?>"><?php echo $tbl_country[$i]['country_name']?></option>
<?php	
}
?>
</select>
</body>
</html>
<?php
	}
}
?>	