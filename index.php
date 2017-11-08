<?php
	require_once('dbConfig.php');
	$upload_dir = 'uploads/';
	if(isset($_GET['delete'])){
		$id = $_GET['delete'];

		$sql = "select photo from tbl_users where id = ".$id;
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
			$photo = $row['photo'];
			unlink($upload_dir.$photo);
			$sql = "delete from tbl_users where id=".$id;
			if(mysqli_query($conn, $sql)){
				header('location:index.php');
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Uploadimage</title>
	<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap-theme.min.css">
</head>
<body>

<div class="navbar navbar-default">
	<div class="container">
		<div class="navbar-header">
			<h3 class="navbar-brand">PHP upload image</h3>
		</div>
	</div>
</div>
<div class="container">
	<div class="page-header">
		<h3>User List
			<a class="btn btn-default" href="add.php">
				<span class="glyphicon glyphicon-plus"></span> &nbsp;Add New
			</a>
		</h3>
	</div>
	<table class="table table-bordered table-responsive">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Position</th>
					<th>Photo</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$sql = "select * from tbl_users";
				$result = mysqli_query($conn, $sql);
				if(mysqli_num_rows($result)){
					while($row = mysqli_fetch_assoc($result)){
			?>
				<tr>
					<td><?php echo $row['id'] ?></td>
					<td><?php echo $row['name'] ?></td>
					<td><?php echo $row['position'] ?></td>
					<td><img src="<?php echo $upload_dir.$row['photo'] ?>" height="40"></td>
					<td>
						<a class="btn btn-info" href="edit.php?id=<?php echo $row['id'] ?>">
							<span class="glyphicon glyphicon-edit"></span>Edit
						</a>
						<a class="btn btn-danger" href="index.php?delete=<?php echo $row['id'] ?>" onclick="return confirm('Are you sure to delete this record?')">
							<span class="glyphicon glyphicon-remove-circle"></span>Delete
						</a>
					</td>
				</tr>
			<?php
					}
				}
			?>
			</tbody>
	</table>
</div>

</body>
</html>