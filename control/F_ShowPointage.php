<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- Page level custom scripts -->
<script src="js/demo/datatables-demo.js"></script>

<?php

include 'F_Connection.php';
include('../zklib/ZKLib.php');

//debut de la session
session_name('ZKTeco');
session_start();

$conn = OpenCon();

$myIniFile = parse_ini_file("../ini/Config.ini", TRUE);
$host = $myIniFile["pointeurse"]["adr"];
$zk = new ZKLib($host);
$DateFrom = null;
$DateTo = null;

//recuperation des valeurs
$IDDep = $_GET['Dep'] ?? "";
$IDSer = $_GET['Ser'] ?? "";
$IDEmp = $_GET['Emp'] ?? "";
$TxtIDDep = $_GET['DepTxt'] ?? "";
$TxtIDSer = $_GET['SerTxt'] ?? "";
$TxtIDEmp = $_GET['EmpTxt'] ?? "";
if ($_GET['DateFrom'] ?? "") {
    $DateFrom = new DateTime($_GET['DateFrom'] ?? "");
}
if ($_GET['DateTo'] ?? "") {
    $DateTo = new DateTime($_GET['DateTo'] ?? "");
}
$DayDiff = $_GET['DayDiff'] ?? "";

$SqlRecherche = null;
$Resultat = "";
$diff = null;


if (!empty($DateFrom) && !empty($DateTo)) {
    if ($IDEmp == 'T') {
        $SqlRecherche = "SELECT * FROM Employes,Service,Departement,Affectation,Pointages WHERE Service.IDService=Affectation.IDService AND Employes.IDEmployes=Pointages.IDEmployePointages AND Service.IDDepartement=Departement.IDDepartement AND Employes.UIDEmployes=Affectation.IDEmployes AND ActiveEmp!=0 AND Service.IDService=".$IDSer." AND Departement.IDDepartement=".$IDDep." AND Pointages.DatePointages BETWEEN '".$DateFrom->format('Y-m-d')."' AND '".$DateTo->format('Y-m-d')."' ";
    } else {
        $SqlRecherche = "SELECT * FROM Employes,Service,Departement,Affectation,Pointages WHERE Service.IDService=Affectation.IDService AND Employes.IDEmployes=Pointages.IDEmployePointages AND Service.IDDepartement=Departement.IDDepartement AND Employes.UIDEmployes=Affectation.IDEmployes AND ActiveEmp!=0 AND Service.IDService=".$IDSer." AND Departement.IDDepartement=".$IDDep." AND Employes.IDEmployes=".$IDEmp." AND Pointages.DatePointages BETWEEN '".$DateFrom->format('Y-m-d')."' AND '".$DateTo->format('Y-m-d')."'";
    }

    //echo $SqlRecherche."<br/>";
    echo '<div class="card border-left-success shadow h-50 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Recherche
                    </div>
                    <div class="row no-gutters align-items-center"> Département : <b>' . $TxtIDDep . '</b> - Sérvice : <b>' . $TxtIDSer . '</b> - Employée : <b>' . $TxtIDEmp . '</b> |  De : <b>' . $DateFrom->format('Y-m-d') . '</b> - A : <b>' . $DateTo->format('Y-m-d') . '</b> - Totale Jours : ' . $DayDiff . '</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-search fa-2x text-red-300"></i>
                </div>
            </div>
        </div>
    </div>';
    $Resultat .= "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
<thead>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>N° Card</th>
        <th>Département</th>
        <th>Service</th>
        <th>Pointage</th>
        <th>Date</th>
        <th>Heure</th>
        <th>Type</th>
    </tr>
</thead>
<tbody >";


    $statement = $conn->query($SqlRecherche);
    $publishers = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($publishers) {
        foreach ($publishers as $publisher) {
                $Resultat .= "<tr><td>" . $publisher['IDPointages'] . "</td><td>" . $publisher['NomCompletEmployes'] . "</td><td>" . $publisher['CarteEmployes'] . "</td><td>" . $publisher['LibelleDepartement'] . "</td><td>" . $publisher['LibelleService'] . "</td><td>" . $publisher['Pointages'] . "</td><td>" . $publisher['DatePointages'] . "</td><td>" . $publisher['HeurPointages'] . "</td><td>" . $publisher['TypePointages'] . "</td></tr>";
            
        }
    }
} else {
    if ($IDEmp == 'T') {
        $SqlRecherche = "SELECT * FROM Employes,Service,Departement,Affectation,Pointages WHERE Service.IDService=Affectation.IDService AND Employes.IDEmployes=Pointages.IDEmployePointages AND Service.IDDepartement=Departement.IDDepartement AND Employes.UIDEmployes=Affectation.IDEmployes AND ActiveEmp!=0 AND Service.IDService=".$IDSer." AND Departement.IDDepartement=".$IDDep."; ";
    } else {
        $SqlRecherche = "SELECT * FROM Employes,Service,Departement,Affectation,Pointages WHERE Service.IDService=Affectation.IDService AND Employes.IDEmployes=Pointages.IDEmployePointages AND Service.IDDepartement=Departement.IDDepartement AND Employes.UIDEmployes=Affectation.IDEmployes AND ActiveEmp!=0 AND Service.IDService=".$IDSer." AND Departement.IDDepartement=".$IDDep." AND Employes.IDEmployes=".$IDEmp."";
    }

    //echo $SqlRecherche."<br/>";
    echo '<div class="card border-left-success shadow h-50 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Recherche
                    </div>
                    <div class="row no-gutters align-items-center"> Département : <b>' . $TxtIDDep . '</b> - Sérvice : <b>' . $TxtIDSer . '</b> - Employée : <b>' . $TxtIDEmp . '</b></div>
                </div>
                <div class="col-auto">
                <i class="fas fa-search fa-2x text-red-300"></i>
                </div>
            </div>
        </div>
    </div>';

    $Resultat .= "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
<thead>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>N° Card</th>
        <th>Département</th>
        <th>Service</th>
        <th>Pointage</th>
        <th>Date</th>
        <th>Heure</th>
        <th>Type</th>
    </tr>
</thead>
<tbody >";
    $statement = $conn->query($SqlRecherche);
    $publishers = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($publishers) {

        foreach ($publishers as $publisher) {
           
            $Resultat .= "<tr><td>" . $publisher['IDPointages'] . "</td><td>" . $publisher['NomCompletEmployes'] . "</td><td>" . $publisher['CarteEmployes'] . "</td><td>" . $publisher['LibelleDepartement'] . "</td><td>" . $publisher['LibelleService'] . "</td><td>" . $publisher['Pointages'] . "</td><td>" . $publisher['DatePointages'] . "</td><td>" . $publisher['HeurPointages'] . "</td><td>" . $publisher['TypePointages'] . "</td></tr>";
        }
    }
}

//echo $SqlRecherche.'<br/>';



$Resultat .= "

</tbody>
</table>";
echo '<input type="text" id="ResInput" value="' . $Resultat . '" hidden/>';
