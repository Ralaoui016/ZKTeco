<?php
    //debut de la session
    session_name( 'ZKTeco' );
    session_start();
    include('../zklib/ZKLib.php');
    include '../control/F_Connection.php';
    
    $conn = OpenCon();

    $_SESSION["AddEmp"]=null;
    $sql=null;

    $IdEmp=$_POST['IdEmp'];

    $myIniFile = parse_ini_file ("../ini/Config.ini",TRUE);
    $host = $myIniFile["pointeurse"]["adr"];
    $zk = new ZKLib($host);

    $ret = $zk->connect();


    if($ret)
    {
        $zk->disableDevice();
        try 
        {
            $zk->setUser($IdEmp, $IdEmp, '0', '0', ZK\Util::LEVEL_USER,'0');
            $zk->enableDevice();
            $zk->disconnect();

            $sql = "UPDATE  Employes SET ActiveEmp=0 WHERE UIDEmployes=".$IdEmp." AND IDEmployes=".$IdEmp."";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount()!=0)
            {
                $zk->enableDevice();
                $zk->disconnect();
                $_SESSION["ErreurEmp"]=null;
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
                                Impossible de supprimer l\'utilisateur </b>
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