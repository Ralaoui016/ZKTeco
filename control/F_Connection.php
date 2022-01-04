<?php

    function OpenCon()
    {
        $myIniFile = parse_ini_file ("../ini/Config.ini",TRUE);
        $Serv = $myIniFile["server_name"]["srv"];
        $User = $myIniFile["database_user"]["us"];
        $Pass = $myIniFile["database_pass"]["ps"];
        $DBName = $myIniFile["database_chemain"]["ch"];

        //echo 'mysql:host='.$Serv.';dbname='.$DBName.' '.$User.' '.$Pass.'<br/>';

        try 
        {
            $conn = new PDO('mysql:host='.$Serv.';dbname='.$DBName.'', $User, $Pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully"; 
            return $conn;
  
        }
        catch(PDOException $e) 
        {
            echo "Error: " . $e->getMessage();
        }
    }

    function OpenConFile()
    {
        $myIniFile = parse_ini_file ("./ini/Config.ini",TRUE);
        $Serv = $myIniFile["server_name"]["srv"];
        $User = $myIniFile["database_user"]["us"];
        $Pass = $myIniFile["database_pass"]["ps"];
        $DBName = $myIniFile["database_chemain"]["ch"];

        //echo 'mysql:host='.$Serv.';dbname='.$DBName.' '.$User.' '.$Pass.'<br/>';

        try 
        {
            $conn = new PDO('mysql:host='.$Serv.';dbname='.$DBName.'', $User, $Pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully"; 
            return $conn;
  
        }
        catch(PDOException $e) 
        {
            echo "Error: " . $e->getMessage();
        }
    }
     
    function CloseCon($conn)
    {
        $conn->close();
    }
       
?>