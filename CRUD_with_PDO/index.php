
<?php 
include 'lib/session.php';
include 'inc/header.php' ;
include 'lib/Database.php';
 
?>
<?php 

session::init();
$msg = session::get('msg');
if(!empty($msg) ){
   echo $msg;
   session::set('msg',NULL);
   //session::unset();
}

?>

 <div class="panel panel-default">
      <div class="panel-heading">
      	 <h3>Student List <a class="pull-right btn btn-primary" href="addstudent.php">Add Student</a></h3>
      </div>	
 <div class="panel-body">   
     <table class="table table-striped text-center">
     	<tr>
     		<th class="text-center">Serial No</th>
     		<th class="text-center">Name</th>
     		<th class="text-center">Email</th>
     		<th class="text-center">Phone No</th>
     		<th class="text-center">Action</th>
     	</tr>

<?php 
           $db        = new Database();
           $table     = "tbl_student";
           $order_by  = array('order_by' => 'id DESC' );
           
/*      $selectcond = array('select' => 'name' );
	    $wherecond    =  array(
	    	 // 'where'        => array('id' => '2' ), // it's also work without two condition 
	    	 'where'        => array('id' => '2' , 'email' => 'ariful@gmail.com' ),
	         'return_type'  => 'single'
	    	);

	   // $limit = array('limit' => '3');	
	   // $limit = array('start' => '2' , 'limit' => '3');

*/
    
         $studentdata  = $db->select($table,$order_by);
         if(!empty($studentdata) ){
            $i = 0;
           foreach ($studentdata as $data ) {
            	 $i++;
         
?>

     	<tr>
     		<td><?php echo $i; ?></td>
     		<td><?php echo $data['name']; ?></td>
     		<td><?php echo $data['email']; ?></td>
     		<td><?php echo $data['phone']; ?></td>
     		<td>
     			<a class="btn btn-info" href="editstudent.php?id=<?php echo $data['id']; ?>">Edit</a>
     			<a class="btn btn-danger" href="lib/process_student.php?action=delete&id=<?php echo $data['id']; ?>" onclick="return confirm('Are You Sure to Delete !')">Delete</a>
     		</td>
     	</tr>

<?php }  } else{ ?>

<tr><td colspan="5"><h3>No Student Data Found !</h3></td></tr>

<?php  } ?>

     </table>
  </div>     
</div>
 <?php include 'inc/footer.php';
