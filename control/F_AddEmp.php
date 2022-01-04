<?php

    //debut de la session
    session_name( 'ZKTeco' );
    session_start();
    include 'F_Connection.php';
    include('../zklib/ZKLib.php');

    $_SESSION["ErreurEmp"]=null;
    $Sql=null;
    $SqlAffectation=null;
    $conn = OpenCon();

    $UIDEmp=$_POST['UIDEmp'];
    $IDEmp=$_POST['IDEmp'];
    $Name=$_POST['NomEmp'];
    $CarteEmp=$_POST['CarteEmp'];
    $RoleEmp=$_POST['RoleEmp'];

    $myIniFile = parse_ini_file ("../ini/Config.ini",TRUE);
    $host = $myIniFile["pointeurse"]["adr"];
    $zk = new ZKLib($host);

    $ret = $zk->connect();
    if($ret)
    {
        $zk->disableDevice();
        try 
        {
            if($RoleEmp=='A')
            {
                $zk->setUser($UIDEmp, $IDEmp, $Name, '0000', ZK\Util::LEVEL_ADMIN,$CarteEmp);
                $Sql="INSERT INTO Employes(UIDEmployes, IDEmployes, NomCompletEmployes, CarteEmployes, RoleEmployes, PasswordEmployes, DateActionEmp, TimeActionEmp, ActionEmp, NotifActionEmp, ActiveEmp )
                VALUES (".$UIDEmp.",".$IDEmp.",'".$Name."',".$CarteEmp.",'ADMIN','0000','".date("Y-m-d")."','".date("H:i:s")."','NEW INSERT','Inserted By ".$_SESSION["NomCmpZKTeco"]."', 1)";
            }
            else
            {
                $zk->setUser($UIDEmp, $IDEmp, $Name, '0000', ZK\Util::LEVEL_USER,$CarteEmp);
                $Sql="INSERT INTO Employes(UIDEmployes, IDEmployes, NomCompletEmployes, CarteEmployes, RoleEmployes, PasswordEmployes, DateActionEmp, TimeActionEmp, ActionEmp, NotifActionEmp, ActiveEmp )
                VALUES (".$UIDEmp.",".$IDEmp.",'".$Name."',".$CarteEmp.",'USER','0000','".date("Y-m-d")."','".date("H:i:s")."','NEW INSERT','Inserted By ".$_SESSION["NomCmpZKTeco"]."', 1)";
            }
            $stmt = $conn->prepare($Sql);
            $stmt->execute();
            if($stmt->rowCount()!=0)
            {
                $zk->enableDevice();
                $zk->disconnect();
                $SqlAffectation="INSERT INTO Affectation(IDEmployes, IDService) VALUES (".$UIDEmp.",0)";
                $stmtAffectation = $conn->prepare($SqlAffectation);
                $stmtAffectation->execute();
                if($stmtAffectation->rowCount()!=0)
                {
                    $_SESSION["ErreurEmp"]=null;
                    header('Location: ../users.php');
                    exit();
                }
                else
                {
                    $_SESSION["ErreurEmp"]='<div class="card border-left-warning border-bottom-warning shadow h-50 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Attention
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                    Impossible de lier l\'utilisateur suivant <b>'.$Name.'</b> au service
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-exclamation-triangle fa-2x text-red-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>';
                    header('Location: ../users.php');
                    exit();
                }
                $_SESSION["ErreurEmp"]=null;
                header('Location: ../users.php');
                exit();
            }
            else
            {
                $zk->removeUser($UIDEmp);
                $zk->enableDevice();
                $zk->disconnect();
                $_SESSION["ErreurEmp"]='<div class="card border-left-warning border-bottom-warning shadow h-50 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Attention
                                </div>
                                <div class="row no-gutters align-items-center">
                                Impossible d\'ajouter l\'utilisateur suivant <b>'.$Name.'</b>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exclamation-triangle fa-2x text-red-300"></i>
                            </div>
                        </div>
                    </div>
                </div>';
                header('Location: ../users.php');
                exit();
            }
        }
        catch  (Exception $e)  
        {
            $_SESSION["ErreurEmp"]='<div class="card border-left-warning border-bottom-warning shadow h-50 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Attention
                            </div>
                            <div class="row no-gutters align-items-center">
                            '.$e->getMessage().'
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-red-300"></i>
                        </div>
                    </div>
                </div>
            </div>';
            $zk->enableDevice();
            $zk->disconnect();
            header('Location: ../users.php');
            exit();
        }
        $zk->enableDevice();
        $zk->disconnect();
        $_SESSION["ErreurEmp"]=null;
        header('Location: ../users.php');
        exit();
    }
    else
    {
        $_SESSION["ErreurEmp"]='<div class="card border-left-warning border-bottom-warning shadow h-50 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Attention
                            </div>
                            <div class="row no-gutters align-items-center">
                            Attention Connexion Perdu!<br/> Veuillez verifier votre Connexion
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-red-300"></i>
                        </div>
                    </div>
                </div>
            </div>';
            header('Location: ../users.php');
            exit();
    }