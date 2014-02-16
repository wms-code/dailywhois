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
	
	
	
	public function domain()
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
		  "it" => "whois.nic.it"
		 );

		
		# code...
		$nic_server=$this->uri->segment(2);


		 $domain = trim($nic_server);
 
		 // split the TLD from domain name
		 $_domain = explode('.', $domain);
		 $lst = count($_domain)-1;
		 $ext = $_domain[$lst];


		 if (!isset($servers[$ext])) {
		  die('Error: No matching whois server found!');
		 }
		 
		 $nic_server = $servers[$ext];
		 
		 $output = '';
		 
		 // connect to whois server:
		 if ($conn = fsockopen($nic_server, 43)) {
		  fwrite($conn, $domain."\r\n");
		  while (!feof($conn)) {
		   $output .= fgets($conn, 128);
		  }
		  fclose($conn);
		 } else {
		  die('Error: Could not connect to ' . $nic_server . '!');
		 }
		 echo "<pre>";
		 if (strpos($output,'Domain ID:') !== false) 
		 {

				 $output=@stristr($output, 'Domain ID:');				 
				 $output=trim($output);
				 $output= explode("\n", $output);

				 foreach ($output as $value) 
				 {
				 	if (strpos($value,':') !== false) 
					{
				 	# code...
				 	$myval= explode(':', $value, 2);
				 	$myvalnew[trim($myval[0])] =trim($myval[1]);
				 	}
				 }
				 	
		}
		else
		{
			$output=trim($output);
			
				 $output= explode("\n", $output);
					foreach ($output as $value) 
					 {
					 	if (strpos($value,':') !== false) 
					 	{
						 	# code...
						 	$myval= explode(':', $value, 2);
						 	
						 	$myvalnew[trim($myval[0])] = trim($myval[1]);
						}
					 }
				
		}


		var_dump($myvalnew);
				
		
		print_r($output);
	}

	
	
	
	public function domain_spilt($url)
	{
	$bits = explode('/', $url);
		if ($bits[0]=='http:' || $bits[0]=='https:')	{
		$pieces = parse_url($url);
		$domain = isset($pieces['host']) ? $pieces['host'] : '';
			if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
			return $regs['domain'];
			}
		return $bits[0];
		} 
		else{
			if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $bits[0], $regs)) 
			{return $regs['domain'];}				
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

				

	//temp functions 
	public function domaina()
	{			
	$querydomain=$this->uri->segment(2);

	include_once('application/third_party/phpwhois/whois.main.php');
	$whois = new Whois();	
	$result = $whois->Lookup($querydomain);
	
		if($result['regrinfo']['registered']=== "no"){
		//check if domain available
		echo "available";
		}
		elseif($result['regrinfo']['registered']=== "yes") 
		{						
		var_dump($result);
		}


		}
	public function domainaa()
	{			
	$querydomain=$this->uri->segment(2);
	//$dbquery = $this->db->query("SELECT domainname FROM list  WHERE currentdt > DATE_SUB(NOW(), INTERVAL 1 DAY) AND domainname = '$querydomain'  LIMIT 1  ");
	$dbquery = $this->db->query("SELECT * FROM list WHERE DATE(currentdt)=CURDATE() AND domainname = '$querydomain'  LIMIT 1");
	if ($dbquery->num_rows() > 0) 
	{
	$row = $dbquery->row();
	$result=json_decode($row->list_data, true);	
	}
	else
	{
	include_once('application/third_party/phpwhois/whois.main.php');
	$whois = new Whois();	
	$result = $whois->Lookup($querydomain);
	
		if($result['regrinfo']['registered']=== "no"){
		//check if domain available
		echo "available";
		}
		elseif($result['regrinfo']['registered']=== "yes") 
		{						
		$dblist_data=json_encode($result);
		
		//inset mysql list_data
		$query = $this->db->query("SELECT * FROM list WHERE  domainname = '$querydomain'");		
		if ($query->num_rows() > 0)  
		{	
			$row = $query->row();
			$db_id=$row->list_id;
			$dbdata=array(
               'list_id' => $db_id,
               'domainname' => $querydomain,
               'list_data' => $dblist_data
            );
		$this->db->where('list_id', $db_id);			
		$query = $this->db->update('list', $dbdata);
		} 	
		else {		
		$dbdata=array(
               'domainname' => $querydomain,
               'list_data' => $dblist_data
            );
		$query = $this->db->insert('list', $dbdata);				
		} 	
				
		}
		else
		{
		echo"create log: need to ";
		}
		
	}	

		$gettime = $this->db->query("SELECT  TIME_TO_SEC(TIMEDIFF(CURRENT_TIMESTAMP, `currentdt`)) AS time_diff FROM list WHERE domainname = '$querydomain'  LIMIT 1");
		if ($gettime->num_rows() > 0) 
		{
		$row = $gettime->row();
		$result['gettime']= gmdate("H",$row->time_diff).":Hours ".gmdate("i",$row->time_diff).":minutes ago   ";	
		}	
		
		$this->template->set('title', 'Web Whois');
		$this->template->load('layouts/main', 'domain',$result);				
		
	}
		
		
		
					
					
	}

/* End of file home.php */
/* Location: ./application/controllers/admin/home.php */
