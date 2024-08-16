<?php
ob_start(); // starting the object buffer
session_start(); // starting the session to store error or success messages
require_once "includes/config.php";
$user = !empty($_SESSION['user']) ? $_SESSION['user'] : [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Book</title>
  <!-- CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link rel="stylesheet" href="<?=SITE;?>public/css/style.css">
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary" style="margin-bottom:30px">
    <div class="container">
      <a class="navbar-brand" href=<?= SITE ?>><i class="fa fa-address-book"></i> ContactsBook</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item ">
            <a class="nav-link" href=<?= SITE; ?>>Home <span class="sr-only">(current)</span></a>
          </li>
          <?php
          if (empty($user)) {
          ?>
            <li class="nav-item" active>
              <a class="nav-link" href=<?= SITE . "signup.php"; ?>>Signup</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href=<?= SITE . "login.php"; ?>>Login</a>
            </li>
          <?php
          }
          if (!empty($user)) { ?>
            <li class="nav-item">
              <a class="nav-link" href=<?= SITE . "addcontacts.php"; ?>>Add Contacts</a>
            </li>
            <li class="nav-item dropdown ">
              <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= !empty($user['first_name']) ? $user['first_name'] : "" ?>
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href=<?= SITE . "profile.php"; ?>>Profile</a>
                <a class="dropdown-item" href=<?= SITE . "logout.php"; ?>>Logout</a>
              </div>
            </li>
          <?php
          }
          ?>
        </ul>
      </div>
    </div>
  </nav>