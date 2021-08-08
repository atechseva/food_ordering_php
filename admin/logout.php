<?php
session_start();
require("../database/db.php");
require("../database/function.php");

if(isset($_POST['admin_logout']))
{
    unset($_SESSION['admin_email']);
redirect('index.php');
}
?>