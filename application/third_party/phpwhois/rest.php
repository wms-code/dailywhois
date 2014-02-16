<?php


	include_once('whois.main.php');
	include_once('whois.utils.php');
$query='domainindia.com';
$whois = new Whois();
$result = $whois->Lookup($query);
$utils = new utils;
				$winfo = $utils->showObject($result);

print_r($result);

if(empty($result["regyinfo"])) {
        // available
		echo "available";
} else {
        // taken
		echo "taken";
}

								

?>