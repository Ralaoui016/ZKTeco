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
$CountSynchro = 0;


$ret = $zk->connect();
if ($ret) {
    $zk->disableDevice();
    $users = $zk->getUser();
    $attendance = $zk->getAttendance();
    if (count($attendance) > 0) {
        $attendance = array_reverse($attendance, true);
        sleep(1);
        foreach ($attendance as $attItem) {
            if(ZK\Util::getAttState($attItem['state'])=='Unknown')
            {
                if (isset($users[$attItem['id']])) 
                {
                    $sql="SET FOREIGN_KEY_CHECKS = 0;
                    INSERT INTO Pointages(UIDEmployePointages, IDEmployePointages, Nom, Pointages, DatePointages, HeurPointages, TypePointages)
                    SELECT ".$attItem['uid'].",".$attItem['id'].",'".$users[$attItem['id']]['name']."','Card','".date("Y-m-d", strtotime($attItem['timestamp']))."','".date("H:i:s", strtotime($attItem['timestamp']))."','".ZK\Util::getAttType($attItem['type'])."'
                    FROM DUAL
                    WHERE NOT EXISTS(
                        SELECT 1
                        FROM Pointages
                        WHERE IDEmployePointages =".$attItem['id']."  AND DatePointages='".date("Y-m-d", strtotime($attItem['timestamp']))."' AND HeurPointages='".date("H:i:s", strtotime($attItem['timestamp']))."'
                    )
                    LIMIT 1;
                    SET FOREIGN_KEY_CHECKS = 1;";
                } 
                else 
                {
                    $sql="SET FOREIGN_KEY_CHECKS = 0;
                    INSERT INTO Pointages(UIDEmployePointages, IDEmployePointages, Nom, Pointages, DatePointages, HeurPointages, TypePointages)
                    SELECT ".$attItem['uid'].",".$attItem['id'].",'".$attItem['id']."','Card','".date("Y-m-d", strtotime($attItem['timestamp']))."','".date("H:i:s", strtotime($attItem['timestamp']))."','".ZK\Util::getAttType($attItem['type'])."'
                    FROM DUAL
                    WHERE NOT EXISTS(
                        SELECT 1
                        FROM Pointages
                        WHERE IDEmployePointages =".$attItem['id']."  AND DatePointages='".date("Y-m-d", strtotime($attItem['timestamp']))."' AND HeurPointages='".date("H:i:s", strtotime($attItem['timestamp']))."'
                    )
                    LIMIT 1;
                    SET FOREIGN_KEY_CHECKS = 1;";
                }
            }
            else
            {
                if (isset($users[$attItem['id']])) 
                {
                    $sql="SET FOREIGN_KEY_CHECKS = 0;
                    INSERT INTO Pointages(UIDEmployePointages, IDEmployePointages, Nom, Pointages, DatePointages, HeurPointages, TypePointages)
                    SELECT ".$attItem['uid'].",".$attItem['id'].",'".$users[$attItem['id']]['name']."','".ZK\Util::getAttState($attItem['state'])."','".date("Y-m-d", strtotime($attItem['timestamp']))."','".date("H:i:s", strtotime($attItem['timestamp']))."','".ZK\Util::getAttType($attItem['type'])."'
                    FROM DUAL
                    WHERE NOT EXISTS(
                        SELECT 1
                        FROM Pointages
                        WHERE IDEmployePointages =".$attItem['id']."  AND DatePointages='".date("Y-m-d", strtotime($attItem['timestamp']))."' AND HeurPointages='".date("H:i:s", strtotime($attItem['timestamp']))."'
                    )
                    LIMIT 1;
                    SET FOREIGN_KEY_CHECKS = 1;";
                } 
                else 
                {
                    $sql="SET FOREIGN_KEY_CHECKS = 0;
                    INSERT INTO Pointages(UIDEmployePointages, IDEmployePointages, Nom, Pointages, DatePointages, HeurPointages, TypePointages)
                    SELECT ".$attItem['uid'].",".$attItem['id'].",'".$attItem['id']."','".ZK\Util::getAttState($attItem['state'])."','".date("Y-m-d", strtotime($attItem['timestamp']))."','".date("H:i:s", strtotime($attItem['timestamp']))."','".ZK\Util::getAttType($attItem['type'])."'
                    FROM DUAL
                    WHERE NOT EXISTS(
                        SELECT 1
                        FROM Pointages
                        WHERE IDEmployePointages =".$attItem['id']."  AND DatePointages='".date("Y-m-d", strtotime($attItem['timestamp']))."' AND HeurPointages='".date("H:i:s", strtotime($attItem['timestamp']))."'
                    )
                    LIMIT 1;
                    SET FOREIGN_KEY_CHECKS = 1;";
                }
            }
            //echo $sql.'<br/>';
            if(isset($attItem['id']))
            {
                $stmt = $conn->prepare($sql);
                $CountSynchro =$CountSynchro +1;
            }
            // execute the query
            $stmt->execute();
            
        }
    }
    $zk->enableDevice();
    $zk->disconnect();
    echo '<div class="card border-left-success shadow h-50 py-2">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Done !
                </div>
                <div class="row no-gutters align-items-center">Synchronization términer avec succée<br/> Totale pointages synchronisé : '.$CountSynchro.'</div>
            </div>
            <div class="col-auto">
            <i class="fas fa-check fa-2x text-red-300"></i>
            </div>
        </div>
    </div>
</div>';
}
else{
    echo '<div class="card border-left-danger shadow h-50 py-2">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">ERREUR
                </div>
                <div class="row no-gutters align-items-center">Accée Impossible a la pointeuses</div>
            </div>
            <div class="col-auto">
                <i class="fas fa-exclamation-triangle fa-2x text-red-300"></i>
            </div>
        </div>
    </div>
</div>';
}
