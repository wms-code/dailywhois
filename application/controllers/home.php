<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends MY_Controller {

	function __construct()
	{
	parent::__construct();
		
		$this->load->helper('url');
	}


    public function index() 
	{
		if($this->input->post('query'))
		{
			$url=$this->input->post('query');
			$domain=$this->domain_spilt($url);
			$domainname=$this->validatedomain($domain);	
			if ($domainname === false)
			{
				echo "THIS IS NOT A VAILD DOMAIN check if Ip";											
			}
			else
			{
				$target=site_url()."domain/".$domainname;				
				header("Location: " . $target);				
			}	
		}	
		
        $this->template->set('title', 'Whois lookup');
        $this->template->load('layouts/main', 'home');
    }
	
	public function getserver($ext)
	{
		$servers = array(
		  "biz" => "whois.neulevel.biz",
		  "com" => "whois.internic.net",
		  "us" => "whois.nic.us",
		  "coop" => "whois.nic.coop",
		  "info" => "whois.nic.info",
		  "name" => "whois.nic.name",
		  "net" => "whois.internic.net",
		  "gov" => "whois.nic.gov",
		  "edu" => "whois.internic.net",
		  "mil" => "rs.internic.net",
		  "int" => "whois.iana.org",
		  "ac" => "whois.nic.ac",
		  "ae" => "whois.uaenic.ae",
		  "at" => "whois.ripe.net",
		  "au" => "whois.aunic.net",
		  "be" => "whois.dns.be",
		  "bg" => "whois.ripe.net",
		  "br" => "whois.registro.br",
		  "bz" => "whois.belizenic.bz",
		  "ca" => "whois.cira.ca",
		  "cc" => "whois.nic.cc",
		  "ch" => "whois.nic.ch",
		  "cl" => "whois.nic.cl",
		  "cn" => "whois.cnnic.net.cn",
		  "cz" => "whois.nic.cz",
		  "de" => "whois.nic.de",
		  "fr" => "whois.nic.fr",
		  "hu" => "whois.nic.hu",
		  "ie" => "whois.domainregistry.ie",
		  "il" => "whois.isoc.org.il",
		  "in" => "whois.ncst.ernet.in",
		  "ir" => "whois.nic.ir",
		  "mc" => "whois.ripe.net",
		  "to" => "whois.tonic.to",
		  "tv" => "whois.tv",
		  "ru" => "whois.ripn.net",
		  "org" => "whois.pir.org",
		  "aero" => "whois.information.aero",
		  "nl" => "whois.domain-registry.nl",
		  "uk" => "whois.nic.uk",
		  "us" => "whois.nic.us",
		  "travel" => "whois.nic.travel",
		  "gov" => "whois.dotgov.gov",
		  "it" => "whois.nic.it",
		  "co.in" => "co.in.whois-servers.net"
		 );

		if (!isset($servers[$ext])) {
		  die('Error: No matching whois server found!');
		 }
		 //TODO: Need to fix with default server when required, apart from the above list
		 return $servers[$ext];
	}
	
	public function domain()
	{
		
		$nic_server=$this->uri->segment(2);
		$domain = trim($nic_server);
 
		// split the TLD from domain name
		$_domain = explode('.', $domain);

		if(count($_domain)>2)
		{
			$ext = $_domain[1] . "." . $_domain[2];
		}
		else
		{
			$ext = $_domain[1];
		}

		$nic_server = $this->getserver($ext);
		 
		$output = array();
		if($ext == 'com' || $ext == 'net')
		 {
			$dom = "domain =".$domain;
		 }
		 else
		 {
			$dom = $domain;
		 }

		 // connect to whois server:
		 if ($conn = fsockopen($nic_server, 43)) 
		 {
		  fwrite($conn, $dom."\r\n");
		  while (!feof($conn)) 
		  {
		   $output[] = fgets($conn, 128);
		  }
		  fclose($conn);
		 } 
		 else 
		 {
		  die('Error: Could not connect to ' . $nic_server . '!');
		 }

		//Parse based on COLON :
		foreach ($output as $value) 
		 {
		 	if (strpos($value,':') !== false) 
		 	{
			 	$myval= explode(':', $value, 2);
			 	$myvalnew[trim($myval[0])] = trim($myval[1]);
			}
		 }

		//print_r($myvalnew);
		foreach ($myvalnew as $key => $value) {
			//echo " ".$key.": ".$value."<br>";
		}


			//More...
				$raw = "";
			$whois_server = $myvalnew['Whois Server'];
			echo "whois:" . $whois_server;
			echo $dom;
			 if ($conn = fsockopen($whois_server, 43)) 
			 {
			  fwrite($conn, $domain."\r\n");
			  while (!feof($conn)) 
			  {
			   $raw .= fgets($conn, 128);
			  }
			  fclose($conn);
			 } 
			 else 
			 {
			  die('Error: Could not connect to ' . $whois_server . '!');
			 }
			 echo "<pre>$raw";
			 //Parse based on COLON :
			 $morevalues = explode("\n",$raw);
			foreach ($morevalues as $value) 
			 {
			 	if (strpos($value,':') !== false) 
			 	{
				 	$myval= explode(':', $value, 2);
				 	$moreval[trim($myval[0])] = trim($myval[1]);
				}
			 }
			 print_r($moreval);


	}

	
	public function domain_spilt($url)
	{
		$bits = explode('/', $url);
		if ($bits[0]=='http:' || $bits[0]=='https:')	
		{
			$pieces = parse_url($url);
			$domain = isset($pieces['host']) ? $pieces['host'] : '';
			if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) 
			{
				return $regs['domain'];
			}
			return $bits[0];
		} 
		else
		{
			if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $bits[0], $regs)) 
			{
				return $regs['domain'];
			}				
		return $url;					
		}
	}


	public function validatedomain($domain)
	{
		if(!preg_match("/^([a-z0-9]{2,100})\.([a-z\.]{2,8})$/i", $domain)) 
		{
			return false;
		}
		return $domain;
	}

			
}

/* End of file home.php */
/* Location: ./application/controllers/admin/home.php */
