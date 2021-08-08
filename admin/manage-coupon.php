<?php require("includes/top.php"); ?>
<?php

$msg = "";
$coupon_code = "";
$coupon_type = "";
$coupon_value = "";
$cart_min_value = "";
$expired_on = "";
$id = "";

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $id = get_safe_value($_GET['id']);
    $row = mysqli_fetch_assoc(mysqli_query($conn, "select * from coupon where coupon_id='$id'"));
    $coupon_code = $row['coupon_code'];
    $coupon_type = $row['coupon_type'];
    $coupon_value = $row['coupon_value'];
    $cart_min_value = $row['cart_min_value'];
    $expired_on = $row['expired_on'];
}

if (isset($_POST['submit'])) {

    $coupon_code = get_safe_value($_POST['coupon_code']);
    $coupon_type = get_safe_value($_POST['coupon_type']);
    $coupon_value = get_safe_value($_POST['coupon_value']);
    $cart_min_value = get_safe_value($_POST['cart_min_value']);
    $expired_on = get_safe_value($_POST['expired_on']);
    $added_on = date('Y-m-d h:i:s');


    if ($id == '') {
        $sql = "select * from coupon where coupon_code='$coupon_code'";
    } else {
        $sql = "select * from coupon where coupon_code='$coupon_code' and coupon_id!='$id'";
    }
    if (mysqli_num_rows(mysqli_query($conn, $sql)) > 0) {

        $msg = "<div class='alert alert-warning d-flex align-items-center' role='alert'>
        
        &nbsp; Coupen $coupon_code Already Exist
         </div>";
    } else {
        if ($id == '') {
            mysqli_query($conn, "insert into coupon(coupon_code,coupon_type,coupon_value,cart_min_value,expired_on,status,added_on) values('$coupon_code','$coupon_type','$coupon_value','$cart_min_value','$expired_on',1,'$added_on')");
            $_SESSION['msg'] = "New Coupen Added";
        } else {
            mysqli_query($conn, "update coupon set coupon_code='$coupon_code', coupon_type='$coupon_type' , coupon_value='$coupon_value', cart_min_value='$cart_min_value', expired_on='$expired_on' where coupon_id='$id'");
            $_SESSION['msg'] = "Coupen Updated";
        }

        redirect('coupon.php');
    }
}
?>

<?php include('includes/header.php'); ?>
<?php include('includes/sidebar.php'); ?>
<div class="page-wrapper">

    <!-- Bread crumb and right sidebar toggle -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Manage coupon</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage coupon</li>
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
                        <label for="coupen code" class="col-sm-3 text-end control-label col-form-label">Coupon Code</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="coupon_code" value="<?php echo $coupon_code; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="coupen type" class="col-sm-3 text-end control-label col-form-label">
                            Coupon Type</label>
                        <div class="col-sm-9">
                            <select name="coupon_type" class="form-control">
                                <option value="">Select Type</option>
                                <?php
                                $arr = array('P' => 'Percentage', 'F' => 'Fixed');
                                foreach ($arr as $key => $val) {
                                    if ($key == $coupon_type) {
                                        echo "<option value='" . $key . "' selected>" . $val . "</option>";
                                    } else {
                                        echo "<option value='" . $key . "'>" . $val . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="coupon value" class="col-sm-3 text-end control-label col-form-label">
                            Coupon Value</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="coupon_value" value="<?php echo $coupon_value; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cart min value" class="col-sm-3 text-end control-label col-form-label">
                            Cart Minimum Value</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="cart_min_value" value="<?php echo $cart_min_value; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="expired on" class="col-sm-3 text-end control-label col-form-label">
                            Expired On</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" name="expired_on" class="form-control" id="datepicker-autoclose" placeholder="mm/dd/yyyy" value="<?php echo $expired_on; ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text h-100"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
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