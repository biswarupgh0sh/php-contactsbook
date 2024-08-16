<?php
include_once("common/header.php");
require_once("includes/db.php");

if (empty($_SESSION['user'])) {
    header("location:" . SITE . "login.php");
    die;
}
$errors = "";
$userId = (!empty($_SESSION['user']) && !empty($_SESSION['user']['id'])) ? $_SESSION['user']['id'] : 0;
$contact_id = $_GET['id'];
if (!empty($contact_id) && is_numeric($contact_id)) {
    $conn = db_connect();
    $id = mysqli_real_escape_string($conn, $contact_id);
    $sql = "SELECT * FROM `contacts` WHERE `id` = $id AND `owner_id` = $userId";
    $sqlRes = mysqli_query($conn, $sql);
    db_close($conn);
    $rows = mysqli_num_rows($sqlRes);
    if ($rows > 0) {
        $contactRes = mysqli_fetch_assoc($sqlRes);
    } else {
        $errors = "Record doesn't exist!";
    }
} else {
    $errors = "Invalid contact id.";
}

if (!empty($errors)) {
    echo '<div class="alert alert-danger text-center">' . $errors . '</div>';
} else {
?>
    <main role="main" class="container">
        <div class="row justify-content-center wrapper">
            <div class="col-md-6">
                <div class="card">
                    <header class="card-header">
                        <h4 class="card-title mt-2">Contact</h4>
                    </header>
                    <article class="card-body">
                        <div class="container" id="profile">
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <img src=<?= !empty($contactRes['photo']) ? SITE . "uploads/photos/" . $contactRes['photo'] : "https://via.placeholder.com/50.png/09f/666"; ?> width="150" class="img-thumbnail" />
                                </div>
                                <div class="col-sm-6 col-md-8">
                                    <h4 class="text-primary"><?= $contactRes['first_name'] . " " . $contactRes['last_name']; ?></h4>
                                    <p class="text-secondary">
                                        <i class="fa fa-envelope-o" aria-hidden="true"></i> <?= $contactRes['email']; ?><br />
                                        <i class="fa fa-phone" aria-hidden="true"></i> <?= $contactRes['phone']; ?><br />
                                        <i class="fa fa-map-marker" aria-hidden="true"></i> <?= $contactRes['address']; ?>
                                    </p>
                                    <!-- Split button -->
                                </div>
                            </div>

                        </div>
                    </article>

                </div>
            </div>

        </div>

    </main>
<?php
        }
include_once("common/footer.php");
?>