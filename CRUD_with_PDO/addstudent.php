<?php include 'inc/header.php' ?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3> Add Student <a class="pull-right btn btn-primary" href="index.php"> Back </a></h3>
	</div>

 <div class="panel-body">
	<form action="lib/process_student.php" method="post">
			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" class="form-control" id="name" name="name" required="1">
			</div>

			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" class="form-control" id="email" name="email" required="1">
			</div>

			<div class="form-group">
				<label for="phone">Phone No</label>
				<input type="text" class="form-control" id="phone" name="phone" required="1">
			</div>

			<div class="form-group">
				<input type="hidden"  name="action" value="add" >
				<input type="submit" class="btn btn-success"  name="submit" value="Add Student" >
			</div>


	  </form>
   </div>
 </div>
 
<?php include 'inc/footer.php' ?> 