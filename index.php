<?php
require_once "common/header.php";
require_once "includes/db.php";
$userId = (!empty($_SESSION['user']) && !empty($_SESSION['user']['id'])) ? $_SESSION['user']['id'] : 0;
$numRows = "";
$current_page = "";
if (isset($_SESSION['success'])) { ?>
  <div class="alert alert-success text-center">
    <?= $_SESSION['success']; ?>
  </div>
  <?php
  unset($_SESSION['success']);
}
if (!empty($userId)) {
  $current_page = !empty($_GET['page']) ? $_GET['page'] : 1;
  $limit = 5;
  $offset = ($current_page - 1) * $limit;

  $conn = db_connect();
  $sql = "SELECT * FROM `contacts` WHERE `owner_id` = $userId ORDER BY first_name ASC LIMIT $offset, $limit";
  $sqlRes = mysqli_query($conn, $sql);
  $mysqlinumrows = mysqli_num_rows($sqlRes);

  $countSql = "SELECT id FROM `contacts` WHERE `owner_id` = $userId";
  $countRes = mysqli_query($conn, $countSql);
  $numRows = mysqli_num_rows($countRes);

  db_close($conn);
  if ($mysqlinumrows > 0) {
  ?>
    <table class="table text-center">
      <thead>
        <tr>
          <th scope="col"></th>
          <th scope="col">Name</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($sqlRes)) {
          $userImage = (!empty($row['photo'])) ? SITE . 'uploads/photos/' . $row['photo'] : "https://via.placeholder.com/50.png/09f/666";
        ?>
          <tr>
            <td class="align-middle"><img src=<?= $userImage ?> class="img-thumbnail img-list" style="width:80px" /></td>
            <td class="align-middle"><?= $row['first_name'] . " " . $row['last_name']; ?></td>
            <td class="align-middle">
              <a href=<?= SITE . "view.php?id=" . $row['id'] ?> class=" btn btn-success">View</a>
              <a href=<?= SITE . "addcontact.php?id=" . $row['id']; ?> class="btn btn-primary">Edit</a>
              <a href=<?= SITE . "delete.php?id=" . $row['id']; ?> class="btn btn-danger" onclick="return confirm(`Are you sure want to delete this contact?`)">Delete</a>
            </td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
<?php }
}

getPagination($numRows, $current_page);

require_once "common/footer.php";
?>