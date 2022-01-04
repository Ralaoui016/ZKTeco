<?php
    
    //phpinfo();

    include 'F_Connection.php';

    //debut de la session
    session_name( 'ZKTeco' );
    session_start();

    $conn = OpenCon();
   
   //recuperation des login et passe
    $login=$_POST['InputLogin'];
    $passe=$_POST['InputPassword'];

    $sql = "SELECT * FROM Users WHERE LoginUsers='".$login."'";
    echo '<br/>'.$sql.'<br/>';

    $statement = $conn->query($sql);
    $publishers = $statement->fetchAll(PDO::FETCH_ASSOC);
    if ($publishers) 
    {
        foreach ($publishers as $publisher) 
        {
            if($publisher['PassUsers']==$passe)
            {
                if($publisher['ActiveUsers']==1)
                {
                    $_SESSION["ErreurLogin"]=null;
                    $_SESSION["LoginZKTeco"]=$login;
                    $_SESSION["NomCmpZKTeco"]=$publisher['NomUsers'].' '.$publisher['PrenomUsers'];
                    header('Location: ../index.php');
                    exit();
                }
                else
                {
                    $_SESSION["ErreurLogin"]='<div class="card border-left-warning border-bottom-warning shadow h-50 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">ERREUR
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                Attention Votre Compte est désactive!<br/> Veuillez contacter votre administrateur
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-exclamation-triangle fa-2x text-red-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    header('Location: ../index.php');
                    exit();
                }
            }
            else
            {
                $_SESSION["ErreurLogin"]='<div class="card border-left-warning border-bottom-warning shadow h-50 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Attention
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                Attention Pass Incorrecte!<br/> Veuillez verifier votre mot de passe
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-exclamation-triangle fa-2x text-red-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                header('Location: ../index.php');
                exit();
            } 
        }
    }
    else
    {   
        $_SESSION["ErreurLogin"]='<div class="card border-left-danger border-bottom-danger shadow h-50 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">ERREUR
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                Utilisateur Introuvable! Veuillez contacter votre administrateur
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-exclamation-triangle fa-2x text-red-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>';
        header('Location: ../index.php');
        exit();
    }
    
    CloseCon($conn);