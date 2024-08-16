<?php
require_once "common/header.php";
require_once "includes/db.php";

if(empty($_SESSION['user'])){
    header("location:".SITE."login.php");
    die;
}

$user_id = $_SESSION['user']['id'];
$sql = "SELECT * FROM `users` WHERE id = $user_id";
$conn = db_connect();
$sql_res = mysqli_query($conn, $sql);
if(mysqli_num_rows($sql_res) > 0){
    $user_info = mysqli_fetch_assoc($sql_res);
    db_close($conn);
}else {
    echo "user not found";
    die;
}
?>
<main role="main" class="container">
    <div class="row justify-content-center wrapper">
        <div class="col-md-6">
            <div class="card">
                <header class="card-header">
                    <h4 class="card-title mt-2">Profile</h4>
                </header>
                <article class="card-body">
                    <div class="container" id="profile">
                        <div class="row">
                            <div class="col-sm-6 col-md-4">
                                <img src="http://placehold.it/100x100" alt="" class="rounded-circle" />
                            </div>
                            <div class="col-sm-6 col-md-8">
                                <h4 class="text-primary"><?= $user_info['first_name']." ".$user_info['last_name']; ?></h4>
                                <p class="text-secondary">
                                    <i class="fa fa-envelope-o" aria-hidden="true"></i><?= $user_info['email']; ?><br />
                                </p>
                                <!-- Split button -->
                            </div>
                        </div>

                    </div>
                </article>

            </div>
        </div>

    </div> <!-- row.//-->

</main>

<?php
require_once "common/footer.php";
?>