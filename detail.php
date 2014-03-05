<?php
  require_once('vendor/autoload.php');
  require_once('inc/db.php');
  require_once('inc/util.php');

  $db = new Database();

  $uid = intval($_GET['uid']);

  $detail = $db->getDetailByUid($uid);

  include('views/header.php');


  include('views/detail.php');

  include('views/footer.php');