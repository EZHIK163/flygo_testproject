<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {
	
	
	public function index()
	{
		echo "General";
	}
	
	public function get_users()
	{
	    
		$url = 'http://localhost/index.php/api/server/users/format/json';

		$body = array();
		
		$type = 'GET';
		echo $this->genHTTPrequest($url, $body, $type);
	     

	}
	public function get_user($id)
	{
	    
		$url = 'http://localhost/index.php/api/server/users/id/'.$id.'format/json';

		$body = array();
		
		$type = 'GET';
		echo $this->genHTTPrequest($url, $body, $type);
	     

	}
	public function update_user($id, $new_name, $new_biography, $new_tel_number, $new_locations)
	{
	    
		$url = 'http://localhost/index.php/api/server/users/format/json';

		$body['id'] = $id;
		$body['name'] = $new_name;
		$body['biography'] = $new_biography;
		$body['tel_number'] = $new_tel_number;
		$body['locations'] = $new_locations;
		
		$type = 'PUT';
		echo $this->genHTTPrequest($url, $body, $type);
	     

	}
	public function add_user($new_name, $new_biography, $new_tel_number, $new_locations)
	{
	    
		$url = 'http://localhost/index.php/api/server/users/format/json';

		$body['name'] = $new_name;
		$body['biography'] = $new_biography;
		$body['tel_number'] = $new_tel_number;
		$body['locations'] = $new_locations;
		
		$type = 'POST';
		echo $this->genHTTPrequest($url, $body, $type);
	     

	}
	public function delete_user($id)
	{
	    

		$url = 'http://localhost/index.php/api/server/users/format/json';
		$body['id'] = $id;
		$type = 'DELETE';
		echo $this->genHTTPrequest($url, $body, $type);
		

	}
	public function genHTTPrequest($url, $body, $type)
	{
		$client = new \GuzzleHttp\Client(['http_errors' => false]);
		$res = $client->request($type, $url, ['form_params' => $body ]);
		return $res->getBody();	
	}

}
