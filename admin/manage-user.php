<?php require("includes/top.php"); ?>
<?php

$user_id = "";
$name = "";
$email = "";
$mobile = "";
$password = "";
$msg = "";

if (isset($_GET['user_id']) > 0) {
    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
    $row = mysqli_fetch_assoc(mysqli_query($conn, "select * from user where user_id='$user_id'"));
    $name = $row['name'];
    $email = $row['email'];
    $mobile = $row['mobile'];
    $password = $row['password'];
}

if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $added_on = date('Y-m-d h:i:s');
    
    if ($user_id == '') {
        $sql = "select * from user where email='$email'";
    } else {
        $sql = "select * from user where email='$email' and user_id!='$user_id'";
    }
    if (mysqli_num_rows(mysqli_query($conn, $sql)) > 0) {
        $msg = "<div class='alert alert-warning d-flex align-items-center' role='alert'>
    
             &nbsp; User $email Already Exist
              </div>";
    } else {
        if ($user_id == '') {
            mysqli_query($conn, "insert into user(name,email,mobile,password,status,added_on) values('$name,'$email,'$mobile,'$password',1,'$added_on')");
            $_SESSION['msg'] = "New user Added";
            header('location:user.php');
        } else {
            mysqli_query($conn, "update user set name='$name', email='$email',mobile='$mobile',password='$password' where user_id=$user_id");
            $_SESSION['msg'] = "User " . ucwords($user) . " Updated";
            header('location:user.php');
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user</title>
    <?php $title = "Your title for better SEO" ?>
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>
    <div class="page-wrapper">

        <!-- Bread crumb and right sidebar toggle -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">Manage user</h4>
                    <div class="ms-auto text-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage user</li>
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
                            <label for="Email" class="col-sm-3 text-end control-label col-form-label">
                                Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
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