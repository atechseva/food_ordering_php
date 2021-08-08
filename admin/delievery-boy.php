<?php require("includes/top.php"); ?>
<?php
$i = 1;
$query = "SELECT * FROM delievery_boy ";
$con = mysqli_query($conn, $query);
if (isset($_GET['action']) && $_GET['action'] == 'active' && isset($_GET['delievery_boy_id']) && !empty($_GET['delievery_boy_id'])) {
    $query = "UPDATE delievery_boy SET status=0 WHERE delievery_boy_id=" . $_GET['delievery_boy_id'] . "";
    $result = mysqli_query($conn, $query);
    header("location:delievery-boy.php");
}
if (isset($_GET['action']) && $_GET['action'] == 'deactive' && isset($_GET['delievery_boy_id']) && !empty($_GET['delievery_boy_id'])) {
    $query = "UPDATE delievery_boy SET status=1 WHERE delievery_boy_id=" . $_GET['delievery_boy_id'] . "";
    $result = mysqli_query($conn, $query);
    header("location:delievery-boy.php");
}


?>
<title>delievery_boy</title>
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
                            <li class="breadcrumb-item active" aria-current="page">delievery_boy</li>
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

        <a href="manage-delievery-boy.php"><button type="button" class="btn btn-lg btn-outline-info mb-3" id="ts-info">Add New</button></a>
        <!-- -------------Content Here------------- -->
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table" id="zero_config">
                    <thead>
                        <tr>
                            <th> <strong>S.No</strong></th>

                            <th> <strong>Delievery Boy ID</strong></th>

                            <th> <strong>Name</strong></th>

                            <th> <strong>Mobile</strong></th>
                            <th> <strong>Added On</strong></th>
                            <th> <strong>Status</strong></th>
                            <th> <strong>Action</strong></th>
                        </tr>
                    </thead>
                    <?php
                    while ($row = mysqli_fetch_array($con)) {

                        $delievery_boy_id = $row['delievery_boy_id'];
                        $name = $row['name'];
                        $mobile = $row['mobile'];
                        $date = $row['added_on'];
                        $status = $row['status'];

                    ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $delievery_boy_id; ?></td>
                            <td><?php echo $name; ?></td>

                            <td><?php echo $mobile; ?></td>
                            <td>
                                <?php
                                echo $date;
                                ?></td>
                            <td>
                                <?php if ($status == 0) { ?>
                                    <a href="?action=deactive&delievery_boy_id=<?php echo $delievery_boy_id; ?>" class="btn btn-dark btn-sm" title="Click to active" data-toggle="tooltip">
                                        Deactive</a>
                                    </a>

                                <?php } else { ?>
                                    <a href="?action=active&delievery_boy_id=<?php echo $delievery_boy_id; ?>" class="btn btn-success btn-sm" title="Click to Deactive" data-toggle="tooltip">
                                        Active</a>
                                    </a>
                                <?php } ?>
                            </td>


                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                    <div class="dropdown-menu">
                                        <a class="link border-top dropdown-item" href="manage-delievery-boy.php?id=<?php echo $row['delievery_boy_id'] ?>">Edit</a>
                                        <input type="hidden" class="delete_delievery_boy_id" id="deletedelievery_boy" value="<?php echo $row['delievery_boy_id'] ?>">
                                        <a class="link border-top dropdown-item deletedelievery_boy" href="javascript:void(0)" type="button">Delete</a>
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
            $('.deletedelievery_boy').click(function(e) {
                e.preventDefault();
                var deleted = $(this).closest("tr").find('.delete_delievery_boy_id').val();
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
                                "delete_delievery_boy": 1,
                                "delievery_boy_id": deleted,
                            },
                            success: function(response) {

                                Swal.fire(
                                    'Deleted!',
                                    'Delievery Boy Deleted Succesfully',
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