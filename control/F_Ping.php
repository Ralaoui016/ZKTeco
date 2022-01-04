<?php
	function pingAddress($ip) 
	{
	    $ping = exec("ping -n 1 ". $ip."");
             
      	if(preg_match('#perte 100%#', $ping))
        {
         	//echo '<p>Ping ip  '. $host.' : <span style="color: red">NON</span></p>';
         	$status=0;
       	}
      	else
      	{
         	//echo '<p>Ping ip  '. $host.' : <span style="color: green">ok</span></p>';
         	$status=1;
      	}
	    return $status;
	}