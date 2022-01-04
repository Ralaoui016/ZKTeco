<?php
    include 'F_Connection.php';

    //debut de la session
    session_name( 'ZKTeco' );
    session_start();

    $conn = OpenCon();
   
   //recuperation des login et passe
    $IdSer=$_POST['IdSer'];

    $sql = "DELETE FROM Service WHERE IDService=".$IdSer."";

    // Prepare statement
    $stmt = $conn->prepare($sql);

    // execute the query
    $stmt->execute();

    if($stmt->rowCount()!=0)
    {
        $_SESSION["ErreurSer"]=null;
        header('Location: ../service.php');
        exit();
    }
    else if($stmt->rowCount()==0)
    {
        $_SESSION["ErreurSer"]='<div class="card border-left-danger shadow h-50 py-2">
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
        header('Location: ../service.php');
        exit();
    }
    // echo a message to say the UPDATE succeeded
    CloseCon($conn);