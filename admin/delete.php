<?php
session_start();
require("db.inc.php");
require("function.inc.php");

if(isset($_POST['delete_btn_set']))
{
    $del=$_POST['delete_id'];
    mysqli_query($conn, "delete from category where category_id='$del'");
    
}
if(isset($_POST['delete_user']))
{
    $del=$_POST['user_id'];
    mysqli_query($conn, "delete from user where user_id='$del'");
    
}
if(isset($_POST['delete_delievery_boy']))
{
    $del=$_POST['delievery_boy_id'];
    mysqli_query($conn, "delete from delievery_boy where delievery_boy_id='$del'");
    
}
if(isset($_POST['delete_coupon']))
{
    $del=$_POST['coupon_id'];
    mysqli_query($conn, "delete from coupon where coupon_id='$del'");
    
}
if(isset($_POST['delete_dish']))
{
    $del=$_POST['dish_id'];
    mysqli_query($conn, "delete from dish where dish_id='$del'");
    
}

?>