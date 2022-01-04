<?php

include './control/F_Connection.php';
include('./zklib/ZKLib.php');
$myIniFile = parse_ini_file("./ini/Config.ini", TRUE);
$host = $myIniFile["pointeurse"]["adr"];
$zk = new ZKLib($host);

//debut de la session
session_name('ZKTeco');
session_start();

if (!isset($_SESSION["LoginZKTeco"])) {
    header('Location: ./login.php');
    exit();
}

$conn = OpenConFile();

$SqlRecherche = Null

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ZKTeco Administration - Pointages</title>
    <link rel="shortcut icon" href="img/authentication.png">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        .wrapper {
            position: relative;
            height: 100%;
            margin: 5px;
        }

        .line {
            position: absolute;
            left: 49%;
            top: 0;
            bottom: 0;
            width: 1px;
            background: #ccc;
            z-index: 1;
        }

        .wordwrapper {
            text-align: center;
            height: 12px;
            position: absolute;
            left: 0;
            right: 0;
            top: 50%;
            margin-top: -12px;
            z-index: 2;
        }

        .word {
            color: #ccc;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 3px;
            font: bold 12px arial, sans-serif;
            background: #f8f9fc;
        }
    </style>
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
                    <span>Département</span></a>
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
            <li class="nav-item active">
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
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
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
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
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
                            <a class="nav-link dropdown-toggle" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php
                                $ret = $zk->connect();
                                if ($ret) {
                                    $zk->disableDevice();
                                    echo '<span style="color: green;">
                                        <i class="fas fa-plug "></i>
                                        </span> ' . $zk->deviceName();
                                    $zk->enableDevice();
                                    $zk->disconnect();
                                } else {
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
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION["NomCmpZKTeco"] ?></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
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
                                    History Employées
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
                        <h1 class="h3 mb-0 text-gray-800">Pointages</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-12 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Listes Pointages</h6>
                                    <div class="row">
                                        <div class="col-lg-2 mb-4">
                                            Département<br />
                                            <select name="IDDep" id="IDDep" class="form-control form-control-user" onchange="giveSelection(this.value)">
                                                <option value="0">--Please choose an option--</option>
                                                <?php
                                                $sqlD = "SELECT * FROM Departement";
                                                $statementD = $conn->query($sqlD);
                                                $publishersD = $statementD->fetchAll(PDO::FETCH_ASSOC);
                                                if ($publishersD) {
                                                    // show the publishers
                                                    foreach ($publishersD as $publisherD) {
                                                        echo '<option value="' . $publisherD['IDDepartement'] . '">' . $publisherD['LibelleDepartement'] . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 mb-4">
                                            Service<br />
                                            <select name="IDSer" id="IDSer" class="form-control form-control-user" onclick="giveSelection2(this.value)" onchange="giveSelection2(this.value)">
                                                <option value="0">--Please choose an option--</option>
                                                <?php
                                                $sqlS = "SELECT * FROM Service,Departement WHERE Service.IDDepartement=Departement.IDDepartement";
                                                $statementS = $conn->query($sqlS);
                                                $publishersS = $statementS->fetchAll(PDO::FETCH_ASSOC);
                                                if ($publishersS) {
                                                    // show the publishers
                                                    foreach ($publishersS as $publisherS) {
                                                        echo '<option data-option="' . $publisherS['IDDepartement'] . '" value="' . $publisherS['IDService'] . '">' . $publisherS['LibelleService'] . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <script>
                                            var IDDep = document.querySelector('#IDDep');
                                            var IDSer = document.querySelector('#IDSer');
                                            var options2 = IDSer.querySelectorAll('option');

                                            function giveSelection(selValue) {
                                                IDSer.innerHTML = '';
                                                for (var i = 0; i < options2.length; i++) {
                                                    if (options2[i].dataset.option === selValue) {
                                                        IDSer.appendChild(options2[i]);
                                                    }
                                                }
                                            }

                                            giveSelection(IDDep.value);
                                        </script>
                                        <div class="col-lg-2 mb-4">
                                            Employée<br />
                                            <select name="IDEmp" id="IDEmp" class="form-control form-control-user">
                                                <option value="0">--Please choose an option--</option>

                                                <?php
                                                $sqlE = "SELECT * FROM Employes,Affectation,Service WHERE Employes.IDEmployes=Affectation.IDEmployes AND Affectation.IDService=Service.IDService";
                                                $statementE = $conn->query($sqlE);
                                                $publishersE = $statementE->fetchAll(PDO::FETCH_ASSOC);
                                                if ($publishersE) {
                                                    // show the publishers
                                                    foreach ($publishersE as $publisherE) {
                                                        echo '<option data-option="' . $publisherE['IDService'] . '" value="' . $publisherE['UIDEmployes'] . '">' . $publisherE['NomCompletEmployes'] . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <script>
                                            var IDSer = document.querySelector('#IDSer');
                                            var IDEmp = document.querySelector('#IDEmp');
                                            var options3 = IDEmp.querySelectorAll('option');

                                            function giveSelection2(selValue) {
                                                IDEmp.innerHTML = '';
                                                IDEmp.innerHTML = '<option value="T">Tous</option>';
                                                for (var i = 0; i < options3.length; i++) {
                                                    if (options3[i].dataset.option === selValue) {
                                                        IDEmp.appendChild(options3[i]);
                                                    }
                                                }
                                            }

                                            giveSelection2(IDSer.value);
                                        </script>
                                        <div class="col-lg-1 mb-4">
                                            <div class="wrapper">
                                                <div class="line"></div>
                                                <div class="wordwrapper">
                                                    <div class="word">OU</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 mb-4">
                                            De<br />
                                            <input type="date" class="form-control form-control-user" name="DateFrom" id="DateFrom">
                                        </div>
                                        <div class="col-lg-2 mb-4">
                                            A<br />
                                            <input type="date" class="form-control form-control-user" name="DateTo" id="DateTo">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-10 mb-4">
                                            <div id="ResultatAff">
                                                <?php
                                                $ErreurPontage = $_SESSION["ErreurPontage"] ?? "";
                                                echo $ErreurPontage;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 mb-4" align="right">
                                            <button onclick="showResult()" class="btn btn-success btn-icon-split">
                                                <span class="icon text-white-50"><i class="fas fa-search"></i></span>
                                                <span class="text">Chercher</span>
                                            </button>

                                            <script>
                                                function isValid(value) {
                                                    if (!value)
                                                        return false;
                                                    else
                                                        return true;
                                                }

                                                function showResult() {
                                                    $(document).ready(function() {
                                                        $("#ModalLoad").modal('show');
                                                    });
                                                    ResultatAff.innerHTML = '';
                                                    var IDDep = document.getElementById("IDDep");
                                                    var NbIDDep = IDDep[IDDep.selectedIndex].value;
                                                    var TxtIDDep = IDDep[IDDep.selectedIndex].text;
                                                    var IDSer = document.getElementById("IDSer");
                                                    var NbIDSer = IDSer[IDSer.selectedIndex].value;
                                                    var TxtIDSer = IDSer[IDSer.selectedIndex].text;
                                                    var IDEmp = document.getElementById("IDEmp");
                                                    var NbIDEmp = IDEmp[IDEmp.selectedIndex].value;
                                                    var TxtIDEmp = IDEmp[IDEmp.selectedIndex].text;
                                                    var DateFrom = document.getElementById("DateFrom");
                                                    var NbDateFrom = DateFrom.value;
                                                    var DateTo = document.getElementById("DateTo");
                                                    var NbDateTo = DateTo.value;

                                                    var xmlhttp = new XMLHttpRequest();
                                                    xmlhttp.onreadystatechange = function() {
                                                        if (this.readyState == 4 && this.status == 200) {
                                                            document.getElementById("ResultatAff").innerHTML = this.responseText;
                                                        }
                                                    };

                                                    if (!NbDateFrom && !NbDateTo) {
                                                        xmlhttp.open("GET", "control/F_ShowPointage.php?DepTxt=" + TxtIDDep + "&SerTxt=" + TxtIDSer + "&EmpTxt=" + TxtIDEmp + "&Dep=" + NbIDDep + "&Ser=" + NbIDSer + "&Emp=" + NbIDEmp, true);
                                                    } else if (!NbDateFrom && NbDateTo) {
                                                        ResultatAff.innerHTML += '<div class="card border-left-danger shadow h-50 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-danger text-uppercase mb-1">ERREUR</div><div class="row no-gutters align-items-center">Date From Indéfinie</div></div><div class="col-auto"><i class="fas fa-exclamation-triangle fa-2x text-red-300"></i></div></div></div></div>';
                                                        document.getElementById('ModalClose').click();
                                                    } else if (NbDateFrom && !NbDateTo) {
                                                        ResultatAff.innerHTML += '<div class="card border-left-danger shadow h-50 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-danger text-uppercase mb-1">ERREUR</div><div class="row no-gutters align-items-center">Date To Indéfinie</div></div><div class="col-auto"><i class="fas fa-exclamation-triangle fa-2x text-red-300"></i></div></div></div></div>';
                                                        document.getElementById('ModalClose').click();
                                                    } else {
                                                        var d1 = new Date(NbDateFrom);
                                                        var d2 = new Date(NbDateTo);
                                                        var diff = d2.getTime() - d1.getTime();
                                                        var daydiff = diff / (1000 * 60 * 60 * 24);
                                                        if (daydiff < 0) {
                                                            ResultatAff.innerHTML += '<div class="card border-left-danger shadow h-50 py-2"><div class="card-body"><div class="row no-gutters align-items-center"><div class="col mr-2"><div class="text-xs font-weight-bold text-danger text-uppercase mb-1">ERREUR</div><div class="row no-gutters align-items-center">Incoérence entre les deux date</div></div><div class="col-auto"><i class="fas fa-exclamation-triangle fa-2x text-red-300"></i></div></div></div></div>';
                                                        } else {
                                                            xmlhttp.open("GET", "control/F_ShowPointage.php?DepTxt=" + TxtIDDep + "&SerTxt=" + TxtIDSer + "&EmpTxt=" + TxtIDEmp + "&Dep=" + NbIDDep + "&Ser=" + NbIDSer + "&Emp=" + NbIDEmp + "&DateFrom=" + NbDateFrom + "&DateTo=" + NbDateTo + "&DayDiff=" + daydiff, true);
                                                        }
                                                    }

                                                    xmlhttp.send();

                                                    setTimeout(function() {
                                                        document.getElementById("ResPo").innerHTML = document.getElementById("ResInput").value;
                                                        document.getElementById('ModalClose').click();
                                                    }, 5000);

                                                }
                                            </script>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive" id="ResPo">
                                        
                                    </div>
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

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Prêts a nous quiter?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Cliquer sur "Logout" ci-dessous si vous êtes prêt à terminer votre session en cours.</div>
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

    <div class="modal fade" id="ModalLoad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Veuillez Patienter S'il Vous Plait</h5>
                    <button id="ModalClose" class="close" type="button" data-dismiss="modal" aria-label="Close" hidden>
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" >
                    <center>
                        Le Trie est en cours d'actualisation. Merci de patienter<br/>
                        <div style="width: 20%;">
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="spinner" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-spinner fa-w-16 fa-spin fa-lg"><path fill="currentColor" d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z" class=""></path></svg>
                        </div>
                    </center>
                </div>
                <div class="modal-footer">

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

</body>

</html>