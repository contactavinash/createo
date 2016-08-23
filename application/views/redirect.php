<html>
<head>
<META HTTP-EQUIV="refresh" CONTENT="0;URL=<?php echo site_url($redirect."?1=1"); 
if(isset($alert))
echo "&alert=$alert";
if(isset($alertwarning))
echo "&alertwarning=$alertwarning";
if(isset($alertsuccess))
echo "&alertsuccess=$alertsuccess";
if(isset($other))
echo "&$other";

?>">
</head>
</html>