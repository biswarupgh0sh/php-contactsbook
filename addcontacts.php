<?php
require_once("common/header.php");
require_once("includes/db.php");
if(empty($_SESSION['user'])){
    header("location:" .SITE. "login.php");
    die;
}

$errors = "";
$userId = (!empty($_SESSION['user']) && !empty($_SESSION['user']['id'])) ? $_SESSION['user']['id'] : 0;
$contact_id = !empty($_GET['id']) ? $_GET['id'] : "";
if (!empty($contact_id) && is_numeric($contact_id)) {
    $conn = db_connect();
    $id = mysqli_real_escape_string($conn, $contact_id);
    $sql = "SELECT * FROM `contacts` WHERE `id` = $id AND `owner_id` = $userId";
    $sqlRes = mysqli_query($conn, $sql);
    db_close($conn);
    $rows = mysqli_num_rows($sqlRes);
    if ($rows > 0) {
        $contact = mysqli_fetch_assoc($sqlRes);
    } else {
        $errors = "Record doesn't exist!";
    }
} else {
    $errors = "Invalid contact id.";
}

$first_name = (!empty($contact) && !empty($contact['$first_name'])) ? $contact['$first_name'] : "";
$last_name = (!empty($contact) && !empty($contact['$last_name'])) ? $contact['$last_name'] : "";
$email = (!empty($contact) && !empty($contact['$email'])) ? $contact['$email'] : "";
$phone = (!empty($contact) && !empty($contact['$phone'])) ? $contact['$phone'] : "";
$address = (!empty($contact) && !empty($contact['$address'])) ? $contact['$address'] : "";
$first_name = (!empty($contact) && !empty($contact['$first_name'])) ? $contact['$first_name'] : "";

?>
<main role="main" class="container"><div class="row justify-content-center wrapper">
<div class="col-md-6">
	<?php
		if(!empty($_SESSION['success'])){
	?>
	<div class="alert alert-success text-center">
		<ul>
			<?= $_SESSION['success']; ?>
		</ul>
	</div>
	<?php
	unset($_SESSION['success']);
		}
	if(!empty($_SESSION['errors'])){	?>
		<div class="alert alert-danger">
			<p>Following error(s):</p>
			<ul>
				<?php
					foreach($_SESSION['errors'] as $error){
						echo "<li>".$error."</li>";
					}
				?>
			</ul>
		</div>
		<?php
		unset($_SESSION['errors']);
			}	
		?>
<div class="card">
<header class="card-header">
	<h4 class="card-title mt-2">Add/Edit Contact</h4>
</header>
<article class="card-body">
<form method="POST" action=<?= SITE."actions/addcontacts_action.php";?> enctype="multipart/form-data">
	<div class="form-row">
		<div class="col form-group">
			<label>First Name </label>   
		  	<input type="text" name="fname" value=<?= $first_name; ?> class="form-control" placeholder="First Name">
		</div>
		<div class="col form-group">
			<label>Last Name</label>
		  	<input type="text" name="lname" value=<?= $last_name; ?> class="form-control" placeholder="Last Name">
		</div>
	</div>
	<div class="form-group">
		<label>Email Address</label>
		<input type="email" name="email" value=<?= $email; ?> class="form-control" placeholder="Email">
	</div>
	<div class="form-group">
		<label>Phone No.</label>
		<input type="text" name="phone" value=<?= $phone; ?>  class="form-control" placeholder="Contact">
	</div>
	<div class="form-group">
		<label>Address</label>
		<input type="text" name="address" value=<?= $address; ?> class="form-control" placeholder="Address">
	</div>
	<div class="form-group input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="photo">Photo</span>
        </div>
    <div class="custom-file">
        <input type="file" name="photo" class="custom-file-input" id="contact_photo">
        <label class="custom-file-label" for="contact_photo">Choose file</label>
    </div>
	</div>
    <div class="form-group">
        <input type="hidden" name="contactid" value=<?= $contact_id; ?> />
        <button type="submit" class="btn btn-primary btn-block" name="submitAddcon">Submit</button>
    </div>    
</form>
</article>
</div> 
</div>

</div>

</main>
<?php
    require_once("common/footer.php");
?>