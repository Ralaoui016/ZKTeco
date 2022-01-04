<?php
    include 'F_Connection.php';

    //debut de la session
    session_name( 'ZKTeco' );
    session_start();

    $conn = OpenCon();
   
   //recuperation des login et passe
    $IdUsers=$_POST['IdUsers'];
    $NomUsers=$_POST['NomUsers'];
    $PrenomUsers=$_POST['PrenomUsers'];
    $EmailUsers=$_POST['EmailUsers'];
    $TelUsers=$_POST['TelUsers'];

    $sql = "UPDATE Users SET NomUsers='".$NomUsers."', PrenomUsers='".$PrenomUsers."', EmailUsers='".$EmailUsers."', TelUsers='".$TelUsers."' WHERE IdUsers=".$IdUsers."";

    //echo $sql;

    // Prepare statement
    $stmt = $conn->prepare($sql);

    // execute the query
    $stmt->execute();
    
    if($stmt->rowCount()!=0)
    {
        $_SESSION["ErreurUsers"]=null;
        header('Location: ../profile.php');
        exit();
    }
    else if($stmt->rowCount()==0)
    {
        $_SESSION["ErreurUsers"]='<div class="card border-left-danger shadow h-50 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">ERREUR
                                            </div>
                                            <div class="row no-gutters align-items-center">'.
                                                $sql . "<br>" . $e->getMessage()
                                            .'</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-exclamation-triangle fa-2x text-red-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>';
        header('Location: ../profile.php');
        exit();
    }
    // echo a message to say the UPDATE succeeded
    CloseCon($conn);