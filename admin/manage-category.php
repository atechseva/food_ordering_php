<?php require("includes/top.php"); ?>
<?php

$category_id = "";
$category = "";
$order_number = "";
$msg = "";

if (isset($_GET['category_id']) > 0) {
    $category_id = mysqli_real_escape_string($conn, $_GET['category_id']);
    $row = mysqli_fetch_assoc(mysqli_query($conn, "select * from category where category_id='$category_id'"));
    $category = $row['category'];
    $order_number = $row['order_number'];
}

if (isset($_POST['submit'])) {

    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $order_number = mysqli_real_escape_string($conn, $_POST['order_number']);
    $added_on=date('Y-m-d h:i:s');
    if ($category_id == '') {
        $sql = "select * from category where category='$category'";
    } else {
        $sql = "select * from category where category='$category' and category_id!='$category_id'";
    }
    if (mysqli_num_rows(mysqli_query($conn, $sql)) > 0) {
        $msg = "<div class='alert alert-warning d-flex align-items-center' role='alert'>
        
             &nbsp; Category $category Already Exist
              </div>";
    } else {
        if ($category_id == '') {
            mysqli_query($conn, "insert into category(category,order_number,status,added_on) values('$category','$order_number',1,'$added_on')");
            $_SESSION['msg'] = "New category Added";
            header('location:category.php');
        } else {
            mysqli_query($conn, "update category set category='$category', order_number='$order_number', added_on='$added_on' where category_id=$category_id");
            $_SESSION['msg'] = "Category " . ucwords($category) . " Updated";
            header('location:category.php');
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
    <title>category</title>
    <?php $title = "Your title for better SEO" ?>
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>
    <div class="page-wrapper">

        <!-- Bread crumb and right sidebar toggle -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">Manage category</h4>
                    <div class="ms-auto text-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage category</li>
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
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">Category</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="category" value="<?php echo $category; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lname" class="col-sm-3 text-end control-label col-form-label">
                                Order Number</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="order_number" value="<?php echo $order_number; ?>">
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