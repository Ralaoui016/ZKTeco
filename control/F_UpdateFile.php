<?php
    include 'F_Connection.php';

    //debut de la session
    session_name( 'ZKTeco' );
    session_start();

    $myfile = fopen("../ini/Config.ini", "w");
    //ftruncate($myfile, 0);

    $FileContent=$_POST['FileConfig'];

    //echo $FileContent;

    if(fwrite($myfile, $FileContent)==false)
    {
        $_SESSION["ErreurFileIni"]='<div class="card border-left-warning border-bottom-warning shadow h-50 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Attention
                        </div>
                        <div class="row no-gutters align-items-center">
                        Attention !<br/> Impossible d\'ecrire sur le fichier
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-triangle fa-2x text-red-300"></i>
                    </div>
                </div>
            </div>
        </div>';
    }
    else
    {
        $_SESSION["ErreurFileIni"]=null;
    }

    fclose($myfile);

    header('Location: ../setting.php');
    exit();