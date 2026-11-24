<?php 
require_once ('db_connect.php');
include_once('req/read.php');
if (isset($_GET['users_id'])) {
      $users_id = $_GET['users_id'];
      $user = readById($conn, $users_id);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>UPDATE</title>
      <link rel="stylesheet" type="text/css" href="./template/update.css">
</head>
<body>
      <div class="form-holder">
      	<a href="inserte-records.php" class="link">View | Read</a>
      	<form action="req/update.php"
      	      method="POST">
            <?php if (isset($_GET['error'])) { ?>
            	<p class="error">
            		<?=htmlspecialchars($_GET['error'])?>
            	</p>
            <?php } ?>

            <?php if (isset($_GET['success'])) { ?>
            	<p class="success">
            		<?=htmlspecialchars($_GET['success'])?>
            	</p>
            <?php } ?>

            <label>First Name</label>
<input type="text"
       name="first_name"
       value="<?=htmlspecialchars($user['first_name'])?>"><br>

<label>Last Name</label>
<input type="text"
       name="last_name"
       value="<?=htmlspecialchars($user['last_name'])?>"> <br>

<label>Email</label>
<input type="text"
       name="email"
       value="<?=htmlspecialchars($user['email'])?>"> <br>

<label>Role_id</label>
<input type="text"
       name="role_id"
       value="<?=htmlspecialchars($user['role_id'])?>"> <br>

<label>Users_id</label>
<input type="text"
       name="users_id"
       value="<?=htmlspecialchars($user['users_id'])?>"> <br>

<button type="submit" class="btn-create">Update</button>
                            
                        

           
      	</form>
      </div>
</body>
</html>
<?php }else {
      header("Location: inserte-records.php");
} ?>