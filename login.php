<?php
    //debut de la session
    session_name( 'ZKTeco' );
    session_start();
    
    if(isset($_SESSION["LoginZKTeco"]) and isset($_SESSION["MailZKTeco"]) and isset($_SESSION["NomCmpZKTeco"]))
    {
        header('Location: ./dashbord.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ZKTeco Administration - Login</title>
    <link rel="shortcut icon" href="img/authentication.png">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-info">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Bienvenue à ZKTeco Gestion</h1>
                                    </div>
                                    <form id="LoginForm" class="user" method="POST" action="control/F_login.php">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="InputLogin" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Login..." required="true">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="InputPassword" id="exampleInputPassword" placeholder="Password" required="true">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember Me</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <p style="align:center;">
                                             <?php
                                             $ErreurLogin = $_SESSION["ErreurLogin"] ?? "";
                                             echo $ErreurLogin;
                                            ?>
                                            </p>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <button type="submit" class="btn btn-info btn-icon-split" style="width: 100%"><span class="icon text-white-50">
                                                    <i class="fas fa-sign-in-alt"></i>
                                                </span>
                                                <span class="text">Login</span></button>
                                            </div>
                                            <div class="col-lg-6">
                                                <button type="reset" class="btn btn-warning btn-icon-split" style="width: 100%"><span class="icon text-white-50">
                                                    <i class="fas fa-sync-alt"></i>
                                                </span>
                                                <span class="text">Reset</span></button>
                                            </div>
                                        </div>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>