<?php
	class HTML{
		function _listing($rows,$pagnav){
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="pages.css">
	<script>
		function newentry(){
			var form=document.adminForm;
			form.task.value="new";
			form.submit();
		}
		function edit_fun(id){
			var form=document.adminForm;
			form.exam_type_id.value=id;
			form.task.value="edit";
			form.submit();
		}
		function delete_fun(id){
			var form=document.adminForm;
			form.exam_type_id.value=id;
			form.task.value="delete";
			form.submit();
		}
	</script>
</head>
<body>
	<table width=100%><tr><td class="headlines">
		<h2>Exam Registration System</h2>
	</td></tr></table>
	<form name="adminForm" method="POST" action="exam type.php">
	<div>
	<table width=100%>
		<tr>
			<td><h3>Exam Type Listing</h3></td>
		</tr><tr>
			<td align="right">
				<input type="button" name="new" value="New" onClick="newentry();">
				<input type="button" value="Close" name="close">
				<input type='hidden' name='task' value=''>
				<input type="hidden" name="exam_type_id" value="">
			</td>
		<tr>
	</table>
	<table border=1 width=100% cellspacing=0>
		<tr>
			<th>#</th>
			<th>Exam Type Code</th>
			<th>Exam Type Name</th>
			<th>Fees</th>
			<th>Action</th>
		</tr>
	<?php 
		for($i=0;$i<count($rows);$i++)
		{
	?>
		<tr>
			<td><?php echo $pagnav->rowNumber($i);?></td>
			<td><?php echo $rows[$i]['exam_type_code'];?></td>
			<td><?php echo $rows[$i]['exam_type_name'];?></td>
			<td><?php echo $rows[$i]['exam_fees'];?></td>
			<td><a href="#" onclick="edit_fun('<?php echo $rows[$i]['exam_type_id'];?>');">
				Edit</a> |
				<a href="#" onclick="delete_fun('<?php echo $rows[$i]['exam_type_id'];?>');">Delete</a>
				</td>
		</tr>
	<?php
		}
	?>
		<tr>
			<td colspan="4"><?php echo $pagnav->getListFooter(); ?></td>
		</tr>
	</table>
	</div>
	</form>
</body>
</html>
<?php
	 } 
	 function _entry($res1,$rows,$subjects){
?>
<html>
<head>
	<script>
		function validation(){			
			var form=document.examtypeentry;
			if(form.etcode.value==''||form.etcode.value==null)
				{
					alert("Please enter Exam Type Code");
					form.etcode.style.border="1px solid red";
					form.etcode.focus();
					return false;
				}
			if(form.etname.value==''||form.etname.value==null)
				{
					alert("Please type Exam Type Name");
					form.etname.focus();
					form.etname.style.border="1px solid red";
					return false;
				}
			form.task.value="save";
			form.submit();
			return true;
		}
		function cancel_fun(){
			var form=document.examtypeentry;
			form.task.value="cancel";
			form.submit();
		}
		function numberonly(e){
			var key;
			var keychar;
			if(window.event)
				key=window.event.keyCode;		
			else if(e)
				key=e.which;
			else
				return true;
			keychar=String.fromCharCode(key);
			if((key==null)||(key==0)||(key==8)||(key==9)||(key==13)||(key==27))
				return true;
			else if(("0123456789").indexOf(keychar)>-1){
				return true;
			}
			return false;
		}		
		function addrow(){
			
			var tbl=document.getElementById("tbleducation");
			var lastrow=tbl.rows.length;
			var row = tbl.insertRow(lastrow);
			
			
			//for text box1
			
				var cell_1	= row.insertCell(0);
				var cell_1_el	= document.getElementById( 'txtcode' ).cloneNode(true);
				cell_1_el.selectedIndex	= 0;
				cell_1.appendChild( cell_1_el );
			
			//for textbox2
			
				var cell_2	= row.insertCell(1);
				var cell_2_el	= document.createElement( 'input' );
				cell_2_el.type	= 'text';
				cell_2_el.className	= 'inputbox';
				cell_2_el.name	= 'txtname[]';
				cell_2_el.id		= 'txtname';
				cell_2_el.size		= 20;
				cell_2_el.maxLength	= 4;
				cell_2.appendChild( cell_2_el );
				
			//for textbox3
				
				var cell_2	= row.insertCell(2);
				var cell_2_el	= document.createElement( 'input' );
				cell_2_el.type	= 'button';
				cell_2_el.value ='Add';
				cell_2_el.name	= 'btnadd[]';
				cell_2_el.id		= 'btnadd';
				cell_2_el.onclick	= function(){ return addrow() };
				cell_2_el.size		= 10;
				cell_2_el.maxLength	= 4;
				cell_2.appendChild( cell_2_el );
				
				var cell_2	= row.insertCell(3);
				var cell_2_el	= document.createElement( 'input' );
				cell_2_el.type	= 'button';
				cell_2_el.value ='Delete';
				cell_2_el.name	= 'btndelete[]';
				cell_2_el.id		= 'btndelete';
				cell_2_el.onclick	= function(){return delete_row(row)};
				cell_2_el.size		= 10;
				cell_2_el.maxLength	= 4;
				cell_2.appendChild( cell_2_el );
				
		}
		function delete_row(row){
			var tbl = document.getElementById('tbleducation' );
			var lastRow	= tbl.rows.length;
			var isUpdate	= ( tbl.rows.length == row.rowIndex + 1 )? false : true ;
			
			if( lastRow > 1 ){
				tbl.deleteRow( row.rowIndex );
			}
			
		}
		function deleterow( rowid ){
			var row = document.getElementById(rowid);
			delete_row( row );
		}
		</script>	
</head>
<body>
	<form name="examtypeentry" method="POST" action="exam type.php" style="background-color:#fff1ff;">
	<div id="entry">
		<table width=100%>
			<tr>
				<td ><h3>Exam Type Entry</h3></td>
				<td>&nbsp;</td>
				<td align="right">
					<input type="button" name="save" value="Save" onClick="validation()">
					<input type="button" name="cancel" value="Cancel" onclick="cancel_fun()">
					<input type="hidden" name="task" value="">
				</td>
			</tr>
			<tr><td colspan=3>
			<table cellpadding=10 width=100%>
			<tr>
				<td>Exam Type Code</td>
				<td><input name="etcode" type="text" value="<?php echo $res1['exam_type_code']; ?>"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Exam Type Name</td>
				<td><input name="etname" type="text" value="<?php echo $res1['exam_type_name']; ?>"></td>
				<td align="center">Fees</td>
				<td><input name="etfees" type="text" onchange="return numberonly(event)"
					onkeypress="return numberonly(event)" onkeyup="return numberonly(event)"
				value="<?php echo $res1['exam_fees']; ?>"></td>
			</tr>
			<tr>
				<td colspan="4">
					<table id="tbleducation">
						<tr>
							<td>Subject Code</td>	
		
							<td>Subject Name</td>
						</tr>
						
<?php
	if ($rows){
		
			for($j=0;$j<count($rows);$j++){
			
?>
						<tr id="row0">
							<td>
							<select name="txtcode[]" id="txtcode" maxlength="4">
		<?php
			
					foreach ($subjects As $sub){
						if($rows[$j]['subject_id'] == $sub['subject_id'])
						{
							$select ="selected";
						}else{
							$select ="";
						}
						
		?>
					<option value="<?php echo $sub['subject_id']?>" <?php echo $select;?>><?php echo $sub['subject_code']; ?>
				<?php
					}
		?>
							</select>
							</td>
			
							<td><input type="text" name="txtname[]" id="txtname" readonly value=""></td>

							<td><input type="button" name="btnadd[]" id="btnadd" value="Add" onclick="addrow();"></td>
							<td><input type="button" name="btnadd" id="btnadd" value="Delete" onclick="deleterow('row0');"></td>
							<input type="hidden" name="exam_type_subject_id[]" value="<?php echo $rows[$j]['exam_type_subject_id'];?>">
						</tr>
<?php
			}
	}
	else {
?>
						
						<tr id="row0">
							<td>
							<select name="txtcode[]" id="txtcode" maxlength="4">
		<?php
		
			for($j=0;$j<count($subjects);$j++){
				
		?>
							<option value="<?php echo $subjects[$j]['subject_id']?>"><?php echo $subjects[$j]['subject_code']; ?>
		
		<?php	
			}
		?>
							</select>
							</td>
			
							<td><input type="text" name="txtname[]" id="txtname" readonly value="<?php echo $subjects['subject_name']?>"></td>

							<td><input type="button" name="btnadd[]" id="btnadd" value="Add" onclick="addrow();"></td>
							<!--<td><input type="button" name="btnadd" id="btnadd" value="Delete" onclick="deleterow('row0');"></td>-->
						</tr>
						
<?php
	}
?>
	
					</table>
				</td>
			</tr>
		</table>
	</div>
		<input type="hidden" name="exam_type_id" value="<?php echo $res1['exam_type_id'];?>">
	</form>
</body>
</html>
<?php
	 }
	} 
?>