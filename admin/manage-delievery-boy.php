<?php require("includes/top.php"); ?>
<?php

$id = "";
$name = "";
$mobile = "";
$password = "";
$msg = "";

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $id = get_safe_value($_GET['id']);
    $row = mysqli_fetch_assoc(mysqli_query($conn, "select * from delievery_boy where delievery_boy_id='$id'"));
    $name = $row['name'];
    $password = $row['password'];
    $mobile = $row['mobile'];
}

if (isset($_POST['submit'])) {
    $name = get_safe_value($_POST['name']);
    $password = get_safe_value($_POST['password']);
    $mobile = get_safe_value($_POST['mobile']);
    $added_on = date('Y-m-d h:i:s');

    if ($id == '') {
        $sql = "select * from delievery_boy where mobile='$mobile'";
    } else {
        $sql = "select * from delievery_boy where mobile='$mobile' and delievery_boy_id!='$id'";
    }
    if (mysqli_num_rows(mysqli_query($conn, $sql)) > 0) {
        $msg = "delievery boy already added";
    } else {
        if ($id == '') {

            mysqli_query($conn, "insert into delievery_boy(name,password,mobile,status,added_on) values('$name','$password','$mobile',1,'$added_on')");
        } else {
            mysqli_query($conn, "update delievery_boy set name='$name', password='$password' , mobile='$mobile' where delievery_boy_id='$id'");
        }

        redirect('delievery-boy.php');
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>delievery_boy</title>
    <?php $title = "Your title for better SEO" ?>
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>
    <div class="page-wrapper">

        <!-- Bread crumb and right sidebar toggle -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">Manage delievery_boy</h4>
                    <div class="ms-auto text-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage delievery_boy</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bread crumb and right sidebar toggle -->
        <div class="container-fluid">
            <!-- -------------Content Here------------- -->
            <?php echo $msg; ?>
            <div class="card">
                <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                    <div class="card-body">

                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Mobile" class="col-sm-3 text-end control-label col-form-label">
                                Mobile</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="mobile" value="<?php echo $mobile; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Password" class="col-sm-3 text-end control-label col-form-label">
                                Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="password" value="<?php echo $password; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- ------------------------------------------------>
        </div>

        <?php include('includes/footer.php'); ?>