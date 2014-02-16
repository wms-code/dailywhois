<?php
/**
 * Codeigniter Bootstrap
 * -------------------------------------------------------------------
 * Developed and maintained by Stijn Geselle <stijn.geselle@gmail.com>
 * -------------------------------------------------------------------
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends MY_Controller {

    public function index() {
		$data['city']= $this->db->get('city');
		$data['edu']= $this->db->get('edu');
        $this->template->set('title', 'Admin dashboard');
        $this->template->load('layouts/admin', 'admin/users',$data);
    }
	
	
	
}

/* End of file home.php */
/* Location: ./application/controllers/admin/home.php */
