<?php 

include 'Database.php';
include 'session.php';
session::init();


$db    = new Database();
$table = "tbl_student";

if(isset($_REQUEST['action']) && !empty($_REQUEST['action']) ) {
	if($_REQUEST['action'] == 'add' ){
		$studentdata =  array( 

		   'name'   => $_POST['name'], 
           'email'  => $_POST['email'], 
           'phone'  => $_POST['phone'] 

			);

			$insert = $db->insert($table,$studentdata);
			if($insert){
				$msg = "<div class='alert alert-success'><strong>Success ! </strong> Data Inserted Successfully .</div>";

			}else{
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong> Data not Inserted .</div>";
			}

			session::set('msg',$msg);
			$home_url = '../index.php';
			header('Location:'.$home_url );


	}

 elseif($_REQUEST['action'] == 'edit'){
 	$id = $_POST['id'];
 	if(!empty($id) ){
 		 $studentdata =  array( 

		   'name'   => $_POST['name'], 
           'email'  => $_POST['email'], 
           'phone'  => $_POST['phone'] 

			);
	 		 $table = "tbl_student";
	 		 $condition = array('id' => $id);
	 		 $update  = $db->update($table,$studentdata,$condition);
	 		 if($update){
				$msg = "<div class='alert alert-success'> <strong>Success ! </strong> Data Updated Successfully .</div>";

			}else{
				$msg = "<div class='alert alert-danger'> Data not Updated ! </div>";
			}

			session::set('msg',$msg);
			$home_url = '../index.php';
			header('Location:'.$home_url );
 	}

 }

 elseif($_REQUEST['action'] == 'delete'){
 	$id = $_GET['id'];
 	 if(!empty($id) ){
 	 	 $table = "tbl_student";
	 		 $condition = array('id' => $id);
	 		 $delete  = $db->delete($table,$condition);
	 		 if($delete){
				$msg = "<div class='alert alert-success'> <strong>Success ! </strong> Data Deleted Successfully .</div>";

			}else{
				$msg = "<div class='alert alert-danger'> <strong>Error ! </strong> Data not Deleted ! </div>";
			}

			session::set('msg',$msg);
			$home_url = '../index.php';
			header('Location:'.$home_url );
 	 }
 }





}





?>

