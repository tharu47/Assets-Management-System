<?php
session_start();
include('../includes/config.php');
include('../includes/functions.php');
redirectIfNotLoggedIn();
require('../phpqrcode/qrlib.php');

if(isset($_GET['id'])) {
    $asset_id = $_GET['id'];
    $url = "http://localhost/it_asset/pages/view_asset.php?id=" . $asset_id;
    QRcode::png($url);
}
?>
