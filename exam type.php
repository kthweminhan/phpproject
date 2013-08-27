<?php 
	include('exam type.html.php');
	include('include/pageNavigation.php');
	$task=$_POST['task'];
	$id1=$_POST['exam_type_id'];
	switch ($task){
		case 'new':
			new_fun();break;
		case 'edit':
			edit_fun($id1);break;
		case 'delete':
			delete_fun($id1);break;
		case 'save':
			save_fun($id1);break;
		case 'cancel':
			cancel_fun();break;
		default:
			listing_fun();break;
		}
		function listing_fun(){
			$con=mysql_connect("216.1.1.242","ojt12","ojt12");
			if(!$con){
				die('Could not connect:'.mysql_error());
			}
			mysql_select_db("ojt12_db",$con);
			
			$limit=$_POST['limit'];
			$limitstart=$_POST['limitstart'];
			if (!$_POST['limitstart']){
				$limitstart=0;
			}
			if (!$limit){
				$limit=50;
			}
			
			//total query;
			$sql=mysql_query("select * from exam_type_amm");
			$total=mysql_num_rows($sql);
			//echo var_dump($total);
			
			//listing query;
			$result=mysql_query("SELECT * FROM exam_type_amm Limit $limitstart,$limit");
			while ($row = mysql_fetch_array($result)) {
				$rows[]=$row;
			}
			
			$pagnav=new mosPageNav($total,$limitstart,$limit);
			//echo var_dump($pagnav).'nav';
			
			HTML::_listing($rows,$pagnav);
		}
		function new_fun(){
			$con=mysql_connect("216.1.1.242","ojt12","ojt12");
			if (!$con){
				die('Could not connect:'.mysql_error());
			}
			mysql_select_db("ojt12_db",$con);
			$sql="Select * from subject_amm";
			$result=mysql_query($sql,$con);
			while ($subject=mysql_fetch_array($result)){
				$subjects[]=$subject;
			}
			
			HTML::_entry(0,0,$subjects);
		}
		function edit_fun($id1){
			$con=mysql_connect("216.1.1.242","ojt12","ojt12");
			if (!$con){
				die('Could not connect:'.mysql_error());
			}
			mysql_select_db("ojt12_db",$con);
			
			//subject combo
			$sql="Select * from subject_amm";
			$result=mysql_query($sql,$con);
			while ($subject=mysql_fetch_array($result)){
				$subjects[]=$subject;
			}
			//echo var_dump($subjects).'subject entry';
			
			//select data from exam type and exam type subject
			
			$sql ="SELECT * FROM exam_type_amm WHERE exam_type_id='$id1'";
			$res1 = mysql_query($sql);
			$res1 = mysql_fetch_array($res1);
			
			$result=mysql_query("select *
								from exam_type_subject_amm
								where exam_type_id='$id1'");
			
			while ($row = mysql_fetch_array($result)){
				$rows[]=$row;
			}
			
			//echo var_dump($rows)."row line";
			HTML::_entry($res1,$rows,$subjects);
		}
		function delete_fun($id1){
			$con=mysql_connect("216.1.1.242","ojt12","ojt12");
			if (!$con){
				die('Could not connect:'.mysql_error());
			}
			mysql_select_db("ojt12_db",$con);
			
			mysql_query("
							delete 
							FROM exam_type_subject_amm
							where exam_type_subject_amm.exam_type_id='$id1'");
			mysql_query("
							delete
							from exam_type_amm
							where exam_type_id='$id1'");
			listing_fun();
		}		
		function save_fun($id1){
			
			$etcode=$_POST['etcode'];
			$etname=$_POST['etname'];
			$fees=$_POST['etfees'];
			$txtcode=$_POST['txtcode'];
			$type_subjectid = $_POST['exam_type_subject_id'];
			
			
			$con=mysql_connect("216.1.1.242","ojt12","ojt12");
			if (!$con){
					die('Could not connect:'.mysql_error());
			}
			mysql_select_db("ojt12_db",$con);
			
			if (!$id1){
				
				//insert into exam type
				$sql="insert into exam_type_amm(exam_type_code,exam_type_name,exam_fees)
					values('$etcode','$etname','$fees')";
				$result=mysql_query($sql,$con);
				
				//select exam type id
				$sql=mysql_query("select exam_type_id from exam_type_amm where exam_type_code='$etcode'");
				//echo "select exam_type_id from exam_type_amm where exam_type_code='$etcode'".'new';
				$etid=mysql_fetch_object($sql);
				$exam_type_id = $etid->exam_type_id;
								
				//insert exam type subject with loop count
				for ($i=0;$i<count($txtcode);$i++){
					$sql="	insert into exam_type_subject_amm(exam_type_id,subject_id)
							values('$exam_type_id','$txtcode[$i]')";
					$result=mysql_query($sql,$con);
				}
			}
			else{
				
				//update statement
				mysql_query("update exam_type_amm 
							set exam_type_code='$etcode',
							exam_type_name='$etname',
							exam_fees='$fees'
							where exam_type_id='$id1'
							");
				
				
				for ($i=0;$i<count($txtcode);$i++){
					
					$sql="	update exam_type_subject_amm
							set exam_type_id='$id1',
							subject_id='$txtcode[$i]'
							where exam_type_id ='$id1' And exam_type_subject_id='$type_subjectid[$i]'
							";
					$result=mysql_query($sql,$con);
				}
				
			}
			listing_fun();	
		}
		function cancel_fun(){
			listing_fun();
		}
?>