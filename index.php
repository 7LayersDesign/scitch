<?php
  require_once('vendor/autoload.php');
  require_once('inc/db.php');

  $db = new Database();

  if( isset($_GET['filter']) ){
    $filter = $_GET['filter'];
  } else {
    $filter = 'all';
  }


  $data = $db->getRecords(50, 200, 'ASC', 'uid', "sponsorship:$filter");
  $sponsorships = $db->getSponsorshipCodes();
  $sites = $db->getSites();

  include('views/header.php');

  // include 'views/controls.php';

  include('views/main.php');

  include('views/footer.php');