<?php require("includes/top.php"); ?>

<?php

$msg = "";
$category_id = "";
$dish = "";
$dish_detail = "";
$image = "";
$id = "";
$image_required = "required";
$image_error = "";
//remove attribute when admin edit data

if (isset($_GET['dish_details_id']) && $_GET['dish_details_id'] > 0) {
    $dish_details_id = get_safe_value($_GET['dish_details_id']);
    $id = get_safe_value($_GET['id']);
    mysqli_query($conn, "delete from dish_details where id='$dish_details_id'");
    redirect('manage-dish.php');
}

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $id = get_safe_value($_GET['id']);
    $row = mysqli_fetch_assoc(mysqli_query($conn, "select * from dish where dish_id='$id'"));
    $category_id = $row['category_id'];
    $dish = $row['dish'];
    $dish_detail = $row['dish_detail'];
    $image_required = "";
}

if (isset($_POST['submit'])) {
    $category_id = get_safe_value($_POST['category_id']);
    $dish = get_safe_value($_POST['dish']);
    $dish_detail = get_safe_value($_POST['dish_detail']);

    $added_on = date('Y-m-d h:i:s');
    if ($id == '') {
        $sql = "select * from dish where dish='$dish'";
    } else {
        $sql = "select * from dish where dish='$dish' and dish_id!='$id'";
    }
    if (mysqli_num_rows(mysqli_query($conn, $sql)) > 0) {

        $msg = "<div class='alert alert-warning d-flex align-items-center' role='alert'>
        
        &nbsp; Dish $dish Already Exist
         </div>";
    } else {

        $type = $_FILES['image']['type']; //for validation

        if ($id == '') {

            if ($type != 'image/jpeg' && $type != 'image/png') {
                $image_error = "Invalid image format please choose jpg & png format only !";
            } else {

                $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], SERVER_DISH_IMAGE . $image);

                mysqli_query($conn, "insert into dish(category_id,dish,dish_detail,image,status,added_on) values('$category_id','$dish','$dish_detail','$image',1,'$added_on')");
                $_SESSION['msg'] = "New Dish ($dish) Added";

                //insert attribute
                $mydish_id = mysqli_insert_id($conn);
                $attributeArr = $_POST['attribute'];
                $priceArr = $_POST['price'];

                foreach ($attributeArr as $key => $val) {
                    $attribute = $val;
                    $price = $priceArr[$key];
                    mysqli_query($conn, "insert into dish_details(dish_id,attribute,price,status,added_on) values('$mydish_id','$attribute','$price',1,'$added_on')");
                }
                redirect('dish.php');
            }
        } else {
            $image_condition = "";
            if ($image = $_FILES['image']['name'] != "") {

                if ($type != 'image/jpeg' && $type != 'image/png') {
                    $image_error = "Invalid image format please choose jpg & png format only !";
                } else {
                    $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
                    move_uploaded_file($_FILES['image']['tmp_name'], SERVER_DISH_IMAGE . $image);
                    $image_condition = " , image='$image'";

                    //remove old image
                    $oldImgRow = mysqli_fetch_assoc(mysqli_query($conn, "select image from dish where dish_id='$id'"));
                    $oldimage = $oldImgRow['image'];
                    unlink(SERVER_DISH_IMAGE . $oldimage);
                    //


                }
            }
            if ($image_error == "") {
                $mysql = "update dish set category_id='$category_id', dish='$dish' , dish_detail='$dish_detail' $image_condition where dish_id='$id'";
                mysqli_query($conn, $mysql);
                $_SESSION['msg'] = "Dish Updated";


                //insert edit attributes
                $attributeArr = $_POST['attribute'];
                $priceArr = $_POST['price'];
                $dishDetailsIdArr = $_POST['dish_details_id'];

                foreach ($attributeArr as $key => $val) {
                    $attribute = $val;
                    $price = $priceArr[$key];


                    if (isset($dishDetailsIdArr[$key])) {
                        $did = $dishDetailsIdArr[$key];
                        mysqli_query($conn, "update dish_details set attribute='$attribute', price='$price' where id='$did'");
                    } else {

                        mysqli_query($conn, "insert into dish_details(dish_id,attribute,price,status,added_on) values('$id','$attribute','$price',1,'$added_on')");
                    }
                }
                //
                redirect('dish.php');
            }
        }
    }
}
$sql_category = mysqli_query($conn, "select * from category where status='1' order by category_id desc");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Dish</title>
    <?php $title = "Your title for better SEO" ?>
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>
    <div class="page-wrapper">

        <!-- Bread crumb and right sidebar toggle -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">Manage dish</h4>
                    <div class="ms-auto text-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manage dish</li>
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
                            <label for="dish" class="col-sm-3 text-end control-label col-form-label">Dish</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="dish" value="<?php echo $dish; ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category" class="col-sm-3 text-end control-label col-form-label">
                                Category</label>
                            <div class="col-sm-9">
                                <select name="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    <?php

                                    while ($row = mysqli_fetch_assoc($sql_category)) {
                                        if ($row['category_id'] == $category_id) {
                                            echo "<option value='" . $row['category_id'] . "' selected> " . $row['category'] . "</option>";
                                        } else {
                                            echo "<option value='" . $row['category_id'] . "'>" . $row['category'] . "</option>";
                                        }
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Dish Detail" class="col-sm-3 text-end control-label col-form-label">Dish Detail</label>
                            <div class="col-sm-9">
                                <textarea name="dish_detail" class="form-control"><?php echo $dish_detail; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image" class="col-sm-3 text-end control-label col-form-label">Dish Image</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="image" <?php echo $image_required; ?>>
                                <p class="text-danger mt-2">* <?php echo $image_error; ?></p>
                            </div>
                        </div>

                        <!-- attribute -->



                        <?php
                        if ($id == 0) {
                        ?>
                            <div class="form-group  bg-light p-5" id="dish_box_1">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="row">
                                            <label for="attribute" class="col-sm-3 text-end control-label col-form-label">Attribute</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="attribute[]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="row">
                                            <label for="price" class="col-sm-3 text-end control-label col-form-label">Price</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="price[]">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } else {
                            $i = 1;
                            $dish_details_sql = mysqli_query($conn, "select * from dish_details where dish_id='$id'");
                            while ($dish_detail_row = mysqli_fetch_assoc($dish_details_sql)) {
                            ?>
                                <div class="form-group  bg-light p-1" id="dish_box_1">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <input type="hidden" name="dish_details_id[]" value="<?php echo $dish_detail_row['id']; ?>">

                                            <div class="row">
                                                <label for="attribute" class="col-sm-3 text-end control-label col-form-label">Attribute</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="attribute[]" required value="<?php echo $dish_detail_row['attribute']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="row">
                                                <label for="price" class="col-sm-3 text-end control-label col-form-label">Price</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="price[]" required value="<?php echo $dish_detail_row['price']; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <?php if ($i != 1) { ?>
                                            <div class="col-sm-2">
                                                <div class="row"><button type="submit" name="button" class="btn btn-primary" onclick="remove_old_attr('<?php echo $dish_detail_row['id'] ?>')">Remove</button></div>
                                            </div>
                                        <?php } ?>

                                    </div>
                                </div>


                        <?php $i++;
                            }
                        }
                        ?>


                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>

                            <button type="button" name="addmore" class="btn btn-outline-primary" onclick="add_more()">Add More</button>
                        </div>
                    </div>
                </form>
            </div>

            <input type="hidden" id="add_more" value="1">
            <script>
                function add_more() {
                    var add_more = jQuery(' #add_more').val();
                    add_more++;
                    jQuery('#add_more').val(add_more);
                    var html = '<div class="row" id="box' + add_more + '"><div class="col-sm-5"><div class="row"><label for="attribute" class="col-sm-3 text-end control-label col-form-label">Attribute</label><div class="col-sm-9"><input type="text" class="form-control" name="attribute[]" required></div></div></div><div class="col-sm-5"><div class="row"><label for="price" class="col-sm-3 text-end control-label col-form-label">Price</label><div class="col-sm-9"><input type="text" class="form-control" name="price[]"></div></div></div><div class="col-sm-2"><div class="row"><button type="submit" name="button" class="btn btn-primary" onclick=remove_btn("' + add_more + '")>Remove</button></div></div></div>';
                    jQuery('#dish_box_1').append(html);
                }

                function remove_btn(id) {
                    jQuery('#box' + id).remove();
                }

                function remove_old_attr(id) {
                    var result = confirm('Are you sure');
                    if (result == true) {
                        var cur_path = window.location.href;
                        window.location.href = cur_path + "&dish_details_id=" + id;
                        alert('Press Ok To continue...');

                    }

                }
            </script>
            <!-- ------------------------------------------------>
        </div>

        <?php include('includes/footer.php'); ?>