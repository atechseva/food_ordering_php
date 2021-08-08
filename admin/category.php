<?php require("includes/top.php"); ?>
<?php
$i = 1;
$query = "SELECT * FROM category ORDER BY category_id DESC";
$con = mysqli_query($conn, $query);
if (isset($_GET['action']) && $_GET['action'] == 'active' && isset($_GET['category_id']) && !empty($_GET['category_id'])) {
    $query = "UPDATE category SET status=0 WHERE category_id=" . $_GET['category_id'] . "";
    $result = mysqli_query($conn, $query);
    header("location:category.php");
}
if (isset($_GET['action']) && $_GET['action'] == 'deactive' && isset($_GET['category_id']) && !empty($_GET['category_id'])) {
    $query = "UPDATE category SET status=1 WHERE category_id=" . $_GET['category_id'] . "";
    $result = mysqli_query($conn, $query);
    header("location:category.php");
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
                            <li class="breadcrumb-item active" aria-current="page">category</li>
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
        <a href="manage-category.php"><button type="button" class="btn btn-lg btn-outline-info mb-3" id="ts-info">Add New</button></a>
        <!-- -------------Content Here------------- -->
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table" id="zero_config">
                    <thead>
                        <tr>
                            <th> <strong>S.No</strong></th>
                            <th> <strong>Category ID</strong></th>
                            <th> <strong>Category</strong></th>
                            <th> <strong>Order No.</strong></th>
                            <th> <strong>Date</strong></th>
                            <th> <strong>Status</strong></th>
                            <th> <strong>Action</strong></th>
                        </tr>
                    </thead>
                    <?php
                    while ($row = mysqli_fetch_array($con)) {
                        $category_id = $row['category_id'];
                        $category = $row['category'];
                        $order_number = $row['order_number'];
                        $date = $row['added_on'];
                        $status = $row['status'];
                    ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $category_id; ?></td>
                            <td><?php echo $category; ?></td>
                            <td><?php echo $order_number; ?></td>
                            <td>
                                <?php echo $date; ?></td>
                            <td>
                                <?php if ($status == 0) { ?>
                                    <a href="?action=deactive&category_id=<?php echo $category_id; ?>" class="btn btn-dark btn-sm" title="Click to active" data-toggle="tooltip">
                                        Deactive</a>
                                    </a>
                                <?php } else { ?>
                                    <a href="?action=active&category_id=<?php echo $category_id; ?>" class="btn btn-success btn-sm" title="Click to Deactive" data-toggle="tooltip">
                                        Active</a>
                                    </a>
                                <?php } ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                    <div class="dropdown-menu">
                                        <a class="link border-top dropdown-item" href="manage-category.php?category_id=<?php echo $row['category_id'] ?>">Edit</a>
                                        <input type="hidden" class="delete_id_value" id="deletecat" value="<?php echo $row['category_id'] ?>">
                                        <a class="link border-top dropdown-item deletecategory" href="javascript:void(0)" type="button">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('.deletecategory').click(function(e) {
                    e.preventDefault();
                    var deleted = $(this).closest("tr").find('.delete_id_value').val();
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
                                    "delete_btn_set": 1,
                                    "delete_id": deleted,
                                },
                                success: function(response) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Category Deleted Succesfully',
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

        <!-- ------------------------------------------------>
    </div>

    <?php include('includes/footer.php'); ?>