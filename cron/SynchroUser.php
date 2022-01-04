<?php

    include '../control/F_Connection.php';
    include('../zklib/ZKLib.php');

    session_name( 'ZKTeco' );
    session_start();

    $myIniFile = parse_ini_file ("../ini/Config.ini",TRUE);
    $host = $myIniFile["pointeurse"]["adr"];
    $zk = new ZKLib($host);
    echo $host.'<br/>';
    $conn = OpenCon();
    $SynchrUser=0;

    $ret = $zk->connect();
    if($ret)
    {
        $zk->disableDevice();
        try 
        {
            $users = $zk->getUser();
            foreach ($users as $uItem)
            {   
                $sql = "INSERT INTO Employes(UIDEmployes, IDEmployes, NomCompletEmployes, CarteEmployes, RoleEmployes, PasswordEmployes, DateActionEmp, TimeActionEmp, ActionEmp, NotifActionEmp, ActiveEmp )
                VALUES (".$uItem['uid'].",".$uItem['userid'].",'".$uItem['name']."',".$uItem['cardno'].",'".ZK\Util::getUserRole($uItem['role'])."','".$uItem['password']."','".date("Y-m-d")."','".date("H:i:s")."','INSERT','Inserted By ".$_SESSION["NomCmpZKTeco"]."', 1)
                ON DUPLICATE KEY UPDATE NomCompletEmployes='".$uItem['name']."', CarteEmployes=".$uItem['cardno'].", RoleEmployes='".ZK\Util::getUserRole($uItem['role'])."', PasswordEmployes='".$uItem['password']."',DateActionEmp='".date("Y-m-d")."', TimeActionEmp='".date("H:i:s")."', ActionEmp='UPDATE', NotifActionEmp='Updated By ".$_SESSION["NomCmpZKTeco"]."'";
                echo  $sql.'<br/>';
                // Prepare statement
                $stmt = $conn->prepare($sql);
                // execute the query
                $stmt->execute();
                if($stmt->rowCount()!=0)
                {
                    $SynchrUser=$SynchrUser+1;
                }
            }
        } 
        catch  (Exception $e)  
        {
            echo 'Erreur '.$e->getMessage().'<br/>';
        }
        $zk->enableDevice();
        $zk->disconnect();
        echo 'Totale Synchronisation : '. $SynchrUser;
        header('Location: ../users.php');
        exit();
    }
    else
    {
        echo 'Connexion Impossible';
    }