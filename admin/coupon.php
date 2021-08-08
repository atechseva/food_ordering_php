<?php require("includes/top.php"); ?>
<?php
$i = 1;
$query = "SELECT * FROM coupon ";
$con = mysqli_query($conn, $query);
if (isset($_GET['action']) && $_GET['action'] == 'active' && isset($_GET['coupon_id']) && !empty($_GET['coupon_id'])) {
    $query = "UPDATE coupon SET status=0 WHERE coupon_id=" . $_GET['coupon_id'] . "";
    $result = mysqli_query($conn, $query);
    header("location:coupon.php");
}
if (isset($_GET['action']) && $_GET['action'] == 'deactive' && isset($_GET['coupon_id']) && !empty($_GET['coupon_id'])) {
    $query = "UPDATE coupon SET status=1 WHERE coupon_id=" . $_GET['coupon_id'] . "";
    $result = mysqli_query($conn, $query);
    header("location:coupon.php");
}


?>

<?php include('includes/header.php'); ?>
<?php include('includes/sidebar.php'); ?>
<div class="page-wrapper">

    <!-- Bread crumb and right sidebar toggle -->

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Dashboard</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">coupon</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bread crumb and right sidebar toggle -->
    <div class="container-fluid">

        <?php
        if (isset($_SESSION['msg']) && $_SESSION['msg'] != '') {
        ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '<?php echo $_SESSION['msg']; ?>',
                    timer: 8000,
                })
            </script>
        <?php
            unset($_SESSION['msg']);
        }
        ?>

        <a href="manage-coupon.php"><button type="button" class="btn btn-lg btn-outline-info mb-3" id="ts-info">Add New</button></a>
        <!-- -------------Content Here------------- -->
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table" id="zero_config">
                    <thead>
                        <tr>
                            <th> <strong>S.No</strong></th>

                            <th> <strong>Coupon ID</strong></th>

                            <th> <strong>Coupon Code</strong></th>

                            <th> <strong>Coupon Type</strong></th>
                            <th> <strong>Coupon Value</strong></th>

                            <th> <strong>Cart Min Value</strong></th>

                            <th> <strong>Added On</strong></th>
                            <th> <strong>Expired On</strong></th>
                            <th> <strong>Status</strong></th>
                            <th> <strong>Action</strong></th>
                        </tr>
                    </thead>
                    <?php
                    while ($row = mysqli_fetch_array($con)) {

                        $coupon_id = $row['coupon_id'];
                        $coupon_code = $row['coupon_code'];
                        $coupon_type = $row['coupon_type'];
                        $coupon_value = $row['coupon_value'];
                        $cart_min_value = $row['cart_min_value'];
                        $date = $row['added_on'];
                        $expired_on = $row['expired_on'];
                        $status = $row['status'];

                    ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $coupon_id; ?></td>
                            <td><?php echo $coupon_code; ?></td>
                            <td><?php echo $coupon_type; ?></td>
                            <td><?php echo $coupon_value; ?></td>
                            <td><?php echo $cart_min_value; ?></td>
                            <td>
                                <?php
                                echo $date;
                                ?></td>
                            <td>
                                <?php
                                echo $expired_on;
                                ?></td>
                            <td>
                                <?php if ($status == 0) { ?>
                                    <a href="?action=deactive&coupon_id=<?php echo $coupon_id; ?>" class="btn btn-dark btn-sm" title="Click to active" data-toggle="tooltip">
                                        Deactive</a>
                                    </a>

                                <?php } else { ?>
                                    <a href="?action=active&coupon_id=<?php echo $coupon_id; ?>" class="btn btn-success btn-sm" title="Click to Deactive" data-toggle="tooltip">
                                        Active</a>
                                    </a>
                                <?php } ?>
                            </td>


                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                    <div class="dropdown-menu">
                                        <a class="link border-top dropdown-item" href="manage-coupon.php?id=<?php echo $row['coupon_id'] ?>">Edit</a>
                                        <input type="hidden" class="delete_coupon_id" id="deletecoupon" value="<?php echo $row['coupon_id'] ?>">
                                        <a class="link border-top dropdown-item deletecoupon" href="javascript:void(0)" type="button">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    <?php } ?>
                </table>


            </div>
        </div>


        <!-- ------------------------------------------------>
    </div>

    <?php include('includes/footer.php'); ?>

    <script>
        $(document).ready(function() {
            $('.deletecoupon').click(function(e) {
                e.preventDefault();
                var deleted = $(this).closest("tr").find('.delete_coupon_id').val();
                console.log(deleted);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "delete.php",
                            data: {
                                "delete_coupon": 1,
                                "coupon_id": deleted,
                            },
                            success: function(response) {

                                Swal.fire(
                                    'Deleted!',
                                    'Coupon Deleted Succesfully',
                                    'success'
                                )
                                setTimeout(function() {
                                    location.reload(true);
                                }, 2000);
                            }
                        });
                    }

                })

            });



        });
    </script>