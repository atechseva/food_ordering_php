<?php require("includes/top.php"); ?>

<?php
$i = 1;


$query = "select dish.*,category.category from dish,category where dish.category_id=category.category_id order by dish.dish_id desc";
$res = mysqli_query($conn, $query);

if (isset($_GET['action']) && $_GET['action'] == 'active' && isset($_GET['dish_id']) && !empty($_GET['dish_id'])) {
    $query = "UPDATE dish SET status=0 WHERE dish_id=" . $_GET['dish_id'] . "";
    $result = mysqli_query($conn, $query);
    header("location:dish.php");
}
if (isset($_GET['action']) && $_GET['action'] == 'deactive' && isset($_GET['dish_id']) && !empty($_GET['dish_id'])) {
    $query = "UPDATE dish SET status=1 WHERE dish_id=" . $_GET['dish_id'] . "";
    $result = mysqli_query($conn, $query);
    header("location:dish.php");
}


?>
<title>Dish | <?php echo SITE_NAME ?> </title>
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
                            <li class="breadcrumb-item active" aria-current="page">Dish</li>
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

        <a href="manage-dish.php"><button type="button" class="btn btn-lg btn-outline-info mb-3" id="ts-info">Add New</button></a>
        <!-- -------------Content Here------------- -->
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table" id="zero_config">
                    <thead>
                        <tr>
                            <th> <strong>S.No</strong></th>
                            <th> <strong>Dish ID</strong></th>
                            <th> <strong>Category</strong></th>
                            <th> <strong>Dish</strong></th>
                            <th> <strong>Dish Details</strong></th>
                            <th> <strong>Image</strong></th>
                            <th> <strong>Added On</strong></th>
                            <th> <strong>Status</strong></th>
                            <th> <strong>Action</strong></th>
                        </tr>
                    </thead>
                    <?php
                    while ($row = mysqli_fetch_array($res)) {

                        $dish_id = $row['dish_id'];
                        $category = $row['category'];
                        $dish = $row['dish'];
                        $dish_detail = $row['dish_detail'];
                        $image = $row['image'];
                        $added_on = $row['added_on'];
                        $status = $row['status'];

                    ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $dish_id; ?></td>
                            <td><?php echo $category; ?></td>
                            <td><?php echo $dish; ?></td>
                            <td><?php echo $dish_detail; ?></td>
                            <td class="el-item"> <a href="<?php echo SITE_DISH_IMAGE . $image; ?>" class="image-popup-vertical-fit el-link"><img src="<?php echo SITE_DISH_IMAGE . $image; ?>" alt="<?php echo $dish; ?>" width="80px"> </a></td>
                            <td><?php echo $added_on; ?></td>

                            <td>
                                <?php if ($status == 0) { ?>
                                    <a href="?action=deactive&dish_id=<?php echo $dish_id; ?>" class="btn btn-dark btn-sm" title="Click to active" data-toggle="tooltip">
                                        Deactive</a>
                                    </a>

                                <?php } else { ?>
                                    <a href="?action=active&dish_id=<?php echo $dish_id; ?>" class="btn btn-success btn-sm" title="Click to Deactive" data-toggle="tooltip">
                                        Active</a>
                                    </a>
                                <?php } ?>
                            </td>


                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                    <div class="dropdown-menu">
                                        <a class="link border-top dropdown-item" href="manage-dish.php?id=<?php echo $row['dish_id'] ?>">Edit</a>
                                        <input type="hidden" class="delete_dish_id" id="deletedish" value="<?php echo $row['dish_id'] ?>">
                                        <a class="link border-top dropdown-item deletedish" href="javascript:void(0)" type="button">Delete</a>
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
            $('.deletedish').click(function(e) {
                e.preventDefault();
                var deleted = $(this).closest("tr").find('.delete_dish_id').val();
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
                                "delete_dish": 1,
                                "dish_id": deleted,
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    'Dish Deleted Succesfully',
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