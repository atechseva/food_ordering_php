<?php
session_start();
require("db.inc.php");

if (isset($_POST['login'])) {
    $msg = "";
    $admin_email = mysqli_real_escape_string($conn, $_POST['admin_email']);
    $admin_password = mysqli_real_escape_string($conn, $_POST['admin_password']);

    if (!empty($admin_email) || !empty($admin_password)) {
        $query  = "SELECT * FROM admin WHERE admin_email = '$admin_email'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) == 1) {
            while ($row = mysqli_fetch_assoc($result)) {
                if (password_verify($admin_password, $row['admin_password'])) {
                    $_SESSION['admin_password'] = $row['admin_password'];
                    $_SESSION['admin_email'] = $row['admin_email'];
                    $_SESSION['admin_username'] = $row['admin_username'];
                    $_SESSION['msg'] = "<div class='alert alert-success d-flex align-items-center' role='alert'>
                    <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Success:'><use xlink:href='#check-circle-fill'/></svg>
                    <div>
                    Welcome " . strtoupper($row['admin_username']) . "
                    ! </div>
                  </div>";
                    header("location:admin-dashboard.php?login successful");
                } else {
                    $msg = "<div class='alert alert-warning d-flex align-items-center' role='alert'>
                    <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Warning:'><use xlink:href='#exclamation-triangle-fill'/></svg>
                    <div>
                    Email or Password is invalid
                    </div>
                  </div>";
                }
            }
        } else {
            $msg = "<div class='alert alert-warning d-flex align-items-center' role='alert'>
            <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Warning:'><use xlink:href='#exclamation-triangle-fill'/></svg>
            <div>
            No user found on this email
            </div>
          </div>";
        }
    } else {
        $msg = "<div class='alert alert-warning d-flex align-items-center' role='alert'>
        <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Warning:'><use xlink:href='#exclamation-triangle-fill'/></svg>
        <div>
        Email and Password is required
        </div>
      </div>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="./lib/themify-icon/themify-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.9.55/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="./css/style.css">
</head>

<body class="bg-dark">

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
    </svg>

    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center ">
        <div class="auth-box bg-dark">
            <div id="loginform" style="margin-top: 100px;
    border: 1px white solid;
    padding: 50px;
    box-shadow: 1px 1px 10px white;">
                <div class="text-center pt-3 pb-3">
                    <span class="db" style="font-size: 1.5rem;
    color: #fdfdfd;
    font-weight: 800;">Admin Login</span>
                </div>
                <!-- Form -->
                <form class="form-horizontal mt-3" id="loginform" method="POST">
                    <div class="row pb-4">
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-success text-white h-100" id="basic-addon1"><i class="ti-email"></i></span>
                                </div>
                                <input type="text" name="admin_email" class="form-control form-control-lg" placeholder="Email">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-warning text-white h-100" id="basic-addon2"><i class="ti-pencil"></i></span>
                                </div>
                                <input type="password" name="admin_password" class="form-control form-control-lg" placeholder="Password">
                            </div>
                            <?php
                            if (isset($msg)) {
                                echo $msg;
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row border-top border-secondary">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="pt-3 d-grid gap-2">
                                    <!-- <button class="btn btn-info" id="to-recover" type="button"><i class="fa fa-lock me-1"></i> Lost password?</button> -->
                                    <button class="btn btn-success float-end text-white" type="submit" name="login">Login</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="./js/custom.js"></script>
</body>

</html>