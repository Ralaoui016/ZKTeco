<?php

    include './control/F_Connection.php';
    include('./zklib/ZKLib.php');
    $myIniFile = parse_ini_file ("./ini/Config.ini",TRUE);
    $host = $myIniFile["pointeurse"]["adr"];
    $zk = new ZKLib($host);

    //debut de la session
    session_name( 'ZKTeco' );
    session_start();

    if(!isset($_SESSION["LoginZKTeco"]))
    {
        header('Location: ./login.php');
        exit();
    }

    $conn = OpenConFile();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ZKTeco Administration - Utilisateurs</title>
    <link rel="shortcut icon" href="img/authentication.png">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon rotate-n-15">
        <img src="img/authentication.png" alt="lG" width="35">
    </div>
    <div class="sidebar-brand-text mx-3">ZKTeco Administration</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item">
    <a class="nav-link" href="index.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Configuration
</div>

<li class="nav-item">
    <a class="nav-link" href="pointeuses.php">
        <i class="fas fa-fw fas fa-list"></i>
        <span>Pointeuse</span></a>
</li>

<li class="nav-item">
    <a class="nav-link" href="setting.php">
        <i class="fas fa-fw fa-cogs"></i>
        <span>Setting</span></a>
</li>

<li class="nav-item">
    <a class="nav-link" href="departement.php">
        <i class="fab fa-digital-ocean"></i>
        <span>D??partement</span></a>
</li>

<li class="nav-item">
    <a class="nav-link" href="service.php">
        <i class="fab fa-hive"></i>
        <span>Service</span></a>
</li>

<li class="nav-item">
    <a class="nav-link" href="affectation.php">
        <i class="fas fa-project-diagram"></i>
        <span>Affectation</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Addons
</div>

<!-- Nav Item - Charts -->
<li class="nav-item">
    <a class="nav-link" href="users.php">
        <i class="fas fa-fw fa-users"></i>
        <span>Utilisateurs</span></a>
</li>

<!-- Nav Item - Tables -->
<li class="nav-item">
    <a class="nav-link" href="pointages.php">
        <i class="fas fa-fw fa-table"></i>
        <span>Pointages</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>



</ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle"  id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php
                                    $ret = $zk->connect();
                                    if($ret)
                                    {
                                        $zk->disableDevice();
                                        echo '<span style="color: green;">
                                        <i class="fas fa-plug "></i>
                                        </span> '.$zk->deviceName();                   
                                        $zk->enableDevice();
                                        $zk->disconnect();
                                    }
                                    else
                                    {
                                        echo '<span style="color: red;">
                                        <i class="fas fa-plug "></i>
                                        </span>';
                                    }

                                ?>
                            </a>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?=$_SESSION["NomCmpZKTeco"]?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="setting.php">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="pointeuses.php">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Pointeuses
                                </a>
                                <a class="dropdown-item" href="historyemp.php">
                                    <i class="fas fa-history fa-sm fa-fw mr-2 text-gray-400"></i>
                                    History Employ??es
                                </a>
                                <a class="dropdown-item" href="pointagesp.php">
                                    <i class="fas fa-fw fa-table fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Poitages Pointeuses
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Utilisateur</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-9 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Listes des Employ??es D??sactiv??</h6>
                                    <div class="row">
                                    <div class="col-lg-6 mb-4">Total Employ??es D??sactiv??: 
                                    <?php
                                        $CountEmp=0;
                                         $sql = "SELECT COUNT(*) as NbEmpDes FROM Employes WHERE ActiveEmp=0";
                                         $statement = $conn->query($sql);
                                         $publishers = $statement->fetchAll(PDO::FETCH_ASSOC);
 
                                         if ($publishers) 
                                         {
                                             foreach ($publishers as $publisher) 
                                             {
                                                $CountEmp=$publisher['NbEmpDes'];
                                             }
                                        }
                                        echo $CountEmp;
                                    ?><br/>
                                    </div>
                                    </div>
                                    <?php 
                                        $AddEmp = $_SESSION["AddEmp"] ?? "";
                                        echo $AddEmp;
                                    ?>
                                </div>
                                <div class="card-body">
                                <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>UID </th>
                                            <th>ID</th>
                                            <th>Nom</th>
                                            <th>N?? Carte</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       $sqlU = "SELECT * FROM Employes WHERE ActiveEmp=0";
                                       $statementU = $conn->query($sqlU);
                                       $publishersU = $statementU->fetchAll(PDO::FETCH_ASSOC);

                                       if ($publishersU) 
                                       {
                                           foreach ($publishersU as $publisherU) 
                                           {
                                                echo "<tr>";
                                                echo "<td>".$publisherU['UIDEmployes']."</td>";
                                                echo "<td>".$publisherU['IDEmployes']."</td>";
                                                echo "<td>".$publisherU['NomCompletEmployes']."</td>";
                                                echo "<td>".$publisherU['CarteEmployes']."</td>";
                                                echo "<td>".$publisherU['RoleEmployes']."</td>";
                                                echo "<td>";
                                                echo '<a href="#" class="btn btn-success btn-circle btn-sm" data-toggle="modal" data-target="#ActiveUserModal'.$publisherU['UIDEmployes'].'">
                                                            <span class="icon text-gray-100">
                                                            <i class="fas fa-check"></i>
                                                            </span>
                                                        </a>
                                                        <!-- Delete User Modal-->
                                                        <div class="modal fade" id="ActiveUserModal'.$publisherU['UIDEmployes'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <form method="POST" action="control/F_ActiveEmpDes.php">
                                                                <input type="hidden" id="IdEmpDes" name="IdEmpDes" value="'.$publisherU['UIDEmployes'].'">
                                                                <input type="hidden" id="NomCompletEmployes" name="NomCompletEmployes" value="'.$publisherU['NomCompletEmployes'].'">
                                                                <input type="hidden" id="CarteEmployes" name="CarteEmployes" value="'.$publisherU['CarteEmployes'].'">
                                                                <input type="hidden" id="RoleEmployes" name="RoleEmployes" value="'.$publisherU['RoleEmployes'].'">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-trash"></i> Attention !! Activation d\'un Employ??e</h5>
                                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">??</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">Vous etes sur le point de R??-active l\'utilisateur <b>'.$publisherU['NomCompletEmployes'].'</b><br/>.
                                                                    Voulez-vous vraiment continuez?</div>
                                                                    <div class="modal-footer">
                                                                            <button type="submit" class="btn btn-success btn-icon-split">
                                                                                <span class="icon text-white-50"><i class="fas fa-check"></i></span>
                                                                                <span class="text">Activer</span>
                                                                            </button>
                                                                            <button type="button"  class="btn btn-secondary  btn-icon-split" data-dismiss="modal">
                                                                                <span class="icon text-white-50"><i class="fas fa-times"></i></span>
                                                                                <span class="text">Annuler</span>
                                                                            </button>
                                                                        </div>
                                                                        </div>
                                                                    </div>   
                                                                </form>
                                                            </div>
                                                        </div>';
                                                echo "</td>";
                                           }
                                      }
                                       else
                                       {
                                        echo '<tr><td colspan="6"></td></tr>';
                                       }

                                       ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>UID </th>
                                            <th>ID</th>
                                            <th>Nom</th>
                                            <th>N?? Carte</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-3 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Graphes des Employ??es</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-pie pt-4">
                                        <canvas id="UserPieChart"></canvas>
                                    </div>
                                    <hr>
                                    <?php
                                        $CountAdmin=0;
                                        $CountUser=0;
                                        $sqlG = "SELECT * FROM Employes WHERE ActiveEmp=0";
                                        $statementG = $conn->query($sqlG);
                                        $publishersG = $statementG->fetchAll(PDO::FETCH_ASSOC);

                                        if ($publishersG) 
                                        {
                                           foreach ($publishersG as $publisherG) 
                                           {
                                                if($publisherG['RoleEmployes']=='User')
                                                {
                                                    $CountUser=$CountUser+1;
                                                }
                                                else
                                                {
                                                    $CountAdmin=$CountAdmin+1;
                                                }  
                                           }
                                        }
                                    ?>
                                    Admin : <?php echo $CountAdmin;?> | User : <?php echo $CountUser;?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    

    <!-- Add User Modal-->
    <div class="modal fade" id="AddUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form method="POST" action="control/F_AddEmp.php">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-user-plus"></i> Ajouter Nouvelle Employ??e</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">??</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <?php
                                $ret = $zk->connect();
                                if($ret)
                                {
                                    $zk->disableDevice();
                                    try 
                                    {
                                        $users = $zk->getUser();
                                        $CountUID=0;
                                        foreach ($users as $uItem)
                                        {
                                            $CountUID=$CountUID+1;
                                        }
                                    } 
                                    catch  (Exception $e)  
                                    {
                                        echo 'Erreur';
                                    }
                                    $zk->enableDevice();
                                    $zk->disconnect();
                                }
                                else
                                {
                                echo 'Connexion Impossible';
                                }
                                $CountUID=$CountUID+1;
                            ?>
                            <div class="col-lg-6  mb-3 mb-sm-0">
                                UID <br/>
                                <input type="text" class="form-control form-control-user" name="UIDEmp" id="NomUsers" value="<?php echo $CountUID;?>" readonly>
                            </div>        
                            <div class="col-lg-6  mb-3 mb-sm-0">
                                ID<br/>
                                <input type="text" class="form-control form-control-user" name="IDEmp" id="PrenomEmp" value="<?php echo $CountUID;?>" readonly>
                            </div>           
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-lg-10  mb-3 mb-sm-0">
                                Nom Complet<br/>
                                <input type="text" class="form-control form-control-user" name="NomEmp" id="NomUsers" required>
                            </div>           
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-lg-10  mb-3 mb-sm-0">
                                N?? Carte Pointage<br/>
                                <input type="text" class="form-control form-control-user" name="CarteEmp" id="CarteEmp" >
                            </div>           
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-lg-10  mb-3 mb-sm-0">
                                R??le Employ??e<br/>
                            </div>           
                        </div>
                        <div class="row">
                            <div class="col-lg-4 mb-4">  
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="RoleEmp" id="RoleEmp" value="U" checked>
                                    <label class="form-check-label" for="RoleEmp">
                                        Utilisateur
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-4"> 
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="RoleEmp" id="RoleEmp1" value="A" >
                                    <label class="form-check-label" for="RoleEmp1">
                                        Administrateur
                                    </label>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-icon-split">
                            <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                            <span class="text">Ajouter</span>
                        </button>
                        <button type="button"  class="btn btn-secondary  btn-icon-split" data-dismiss="modal">
                            <span class="icon text-white-50"><i class="fas fa-times"></i></span>
                            <span class="text">Annuler</span>
                        </button>
                    </div>
                    </div>
                </div>   
            </form>
        </div>
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pr??ts a nous quiter?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">??</span>
                    </button>
                </div>
                <div class="modal-body">Cliquer sur "Logout" ci-dessous si vous ??tes pr??t ?? terminer votre session en cours.</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-icon-split" data-dismiss="modal">
                        <span class="icon text-white-50"><i class="fas fa-undo"></i></span>
                        <span class="text">Cancel</span>
                    </button>
                    <button type="button" onclick="document.location='control/F_logout.php'" class="btn btn-info btn-icon-split">
                        <span class="icon text-white-50"><i class="fas fa-sign-out-alt"></i></span>
                        <span class="text">Logout</span>
                    </button>
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

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
     <!-- Page level plugins -->
     <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
    <script>
        // Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
        var ctx = document.getElementById("UserPieChart");
        var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["User", "Admin"],
            datasets: [{
            data: [<?php echo $CountUser;?>,<?php echo $CountAdmin;?>],
            backgroundColor: ['#4e73df', '#1cc88a'],
            hoverBackgroundColor: ['#2e59d9', '#17a673'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
            },
            legend: {
            display: false
            },
            cutoutPercentage: 80,
        },
        });

    </script>

</body>

</html>