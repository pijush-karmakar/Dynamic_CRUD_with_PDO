<?php 
include 'inc/header.php' ;
include 'lib/Database.php';
?>



<div class="panel panel-default">
<div class="panel-heading">
	<h3> Update Student <a class="pull-right btn btn-primary" href="index.php"> Back </a></h3>
</div>

<?php 
	  $id = $_GET['id'];
	  $db    = new Database();
	  $table = "tbl_student";

	  $wherecond  = array(
		    	 'where'     => array('id' => $id ),
		         'return_type'  => 'single'
		    	);
	 
	 $result = $db->select($table,$wherecond);
     if(!empty($result) ) { 
?>

<div class="panel-body">
	<form action="lib/process_student.php" method="post">
			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" class="form-control" id="name" name="name" required="1" value="<?php echo $result['name'] ?>">
			</div>

			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" class="form-control" id="email" name="email" required="1" value="<?php echo $result['email'] ?>">
			</div>

			<div class="form-group">
				<label for="phone">Phone No</label>
				<input type="text" class="form-control" id="phone" name="phone" required="1" value="<?php echo $result['phone'] ?>">
			</div>

			<div class="form-group">
			    <input type="hidden"  name="id" value="<?php echo $result['id'] ?>" >
				<input type="hidden"  name="action" value="edit" >
				<input type="submit" class="btn btn-success"  name="submit" value="Update Student" >
			</div>


	</form>
</div>

<?php } ?>

</div>
<?php include 'inc/footer.php' ?> 