<?php
session_start();
include("./constant.inc.php");
include("./db.inc.php");
include("./function.inc.php");
$CurStr = $_SERVER['REQUEST_URI'];
$curArr = explode('/', $CurStr);
$cur_path = $curArr[count($curArr) - 1];

if ((!isset($_SESSION['admin_email'])) && (!isset($_SESSION['admin_password']))) {
    header('Location: index.php');
}

$page_title = '';
if ($cur_path == '' || $cur_path == 'admin-dashboard.php') {
    $page_title = 'Admin Dashboard';
} elseif ($cur_path == 'category.php') {
    $page_title = 'Category';
} elseif ($cur_path == 'manage-category.php') {
    $page_title = 'Manage Category';
} elseif ($cur_path == 'manage-coupon.php') {
    $page_title = 'Manage Coupon';
} elseif ($cur_path == 'delievery-boy.php') {
    $page_title = 'Delievery Boy';
} elseif ($cur_path == 'manage-delievery-boy.php') {
    $page_title = 'Manage Delievery Boy';
}
elseif ($cur_path == 'dish.php') {
    $page_title = 'Dish';
}
elseif ($cur_path == 'manage-dish.php') {
    $page_title = 'Manage Dish';
}
elseif ($cur_path == 'user.php') {
    $page_title = 'User';
}
elseif ($cur_path == 'manage-user.php') {
    $page_title = ' Manage User';
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>