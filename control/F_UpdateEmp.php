<?php

    //debut de la session
    session_name( 'ZKTeco' );
    session_start();
    include 'F_Connection.php';
    include('../zklib/ZKLib.php');

    $_SESSION["ErreurEmp"]=null;
    $Sql=null;
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
                $Sql="UPDATE Employes SET NomCompletEmployes='".$Name."', CarteEmployes=".$CarteEmp.", RoleEmployes='ADMIN', PasswordEmployes='0000', DateActionEmp='".date("Y-m-d")."', TimeActionEmp='".date("H:i:s")."', ActionEmp='UPDATE', NotifActionEmp='Updated By ".$_SESSION["NomCmpZKTeco"]."', ActiveEmp= 1 WHERE UIDEmployes=".$UIDEmp."";
            }
            else
            {
                $zk->setUser($UIDEmp, $IDEmp, $Name, '0000', ZK\Util::LEVEL_USER,$CarteEmp);
                $Sql="UPDATE Employes SET NomCompletEmployes='".$Name."', CarteEmployes=".$CarteEmp.", RoleEmployes='USER', PasswordEmployes='0000', DateActionEmp='".date("Y-m-d")."', TimeActionEmp='".date("H:i:s")."', ActionEmp='UPDATE', NotifActionEmp='Updated By ".$_SESSION["NomCmpZKTeco"]."', ActiveEmp= 1 WHERE UIDEmployes=".$UIDEmp."";
            }
            $stmt = $conn->prepare($Sql);
            $stmt->execute();
            if($stmt->rowCount()!=0)
            {
                $zk->enableDevice();
                $zk->disconnect();
                header('Location: ../users.php');
                exit();
            }
            else
            {
                $zk->enableDevice();
                $zk->disconnect();
                $_SESSION["ErreurEmp"]='<div class="card border-left-warning border-bottom-warning shadow h-50 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Attention
                                </div>
                                <div class="row no-gutters align-items-center">
                                Impossible de modifier l\'utilisateur suivant <b>'.$Name.'</b>
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