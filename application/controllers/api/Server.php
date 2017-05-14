<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Server extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
	$this->load->model('MyUser');
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function users_get()
    {

	$users = $this->MyUser->get_users();

        $id = $this->get('id');
	$locations = $this->get('locations');
	$clone_id = $this->get('clone_id');

        // If the id parameter doesn't exist return all the users

        if ($id === NULL && $locations === NULL && $clone_id === NULL)
        {
            if ($users)
            {
                $this->response($users, REST_Controller::HTTP_OK); 
            }
            else
            {
                $this->response([
                    'status' => FALSE,
                    'message' => 'No users were found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
	else if ($locations != NULL) 
	{
		$users = $this->MyUser->get_users_for_locations($locations);
		if (count($users) > 0)
		{ 
			$this->response($users, REST_Controller::HTTP_OK); 
		}
		else
		{
			$this->response([
                	'status' => FALSE,
                	'message' => 'User could not be found'
            		], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) 
		}
	}
	else if ($clone_id != NULL)
	{
		$new_id = $this->MyUser->clone_user($clone_id);
        	if ($new_id > 0) { 
		$this->set_response([
		'id' => $new_id,
                'status' => TRUE,
                'message' => 'Clone user successfully'
            	], REST_Controller::HTTP_CREATED); 
		} else 
		{
			$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400)
		}
	}
	else
	{
		$id = (int) $id;

		if ($id <= 0)
		{
		    $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) 
		}

		$user = $this->MyUser->get_user($id);

		if (!empty($user))
		{
		    $this->response($user, REST_Controller::HTTP_OK); // OK (200)  
		}
		else
		{
		    $this->response([
		        'status' => FALSE,
		        'message' => 'User could not be found'
		    ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) 
		}
	}
    }

    public function users_post()
    {
	$name = $this->post('name');
	$biography = $this->post('biography');
	$locations = $this->post('locations');
	$tel_number = $this->post('tel_number');

	$message = $this->MyUser->add_user($name, $biography, $locations, $tel_number);
        if ($message == "") { 
		$this->set_response([
                'status' => TRUE,
                'message' => 'New user successfully added'
            ], REST_Controller::HTTP_CREATED); } 
	else {
	$result = "Problems on locations: ".$message;
	$this->set_response([
                'status' => FALSE,
                'message' => $result
            ], REST_Controller::HTTP_BAD_REQUEST); 
	}
        
    }

    public function users_delete()
    {
        $id = (int) $this->delete('id');
        if ($id <= 0)
        {
		$message = [
	    'status' => FALSE,
            'message' => 'ID le 0:'.$id
   			];
             $this->response($message, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
	$user = $this->MyUser->get_user($id);	
	if (empty($user))
	{
		$this->response([
                'status' => FALSE,
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) 
	}
	
	$this->MyUser->delete_user($id);
        $message = [
            'id' => $id,
	    'status' => TRUE,
            'message' => 'Deleted'
        ];
        $this->response($message, REST_Controller::HTTP_OK); // NO_CONTENT (204) being the HTTP response code
    }
	
	public function users_put()
    {
	$id = $this->put('id');
	$name = $this->put('name');
	$biography = $this->put('biography');
	$locations = $this->put('locations');
	$tel_number = $this->put('tel_number');

	$message = $this->MyUser->update_user($id, $name, $biography, $locations, $tel_number);
        if ($message == "") { 
		$this->set_response([
                'status' => TRUE,
                'message' => 'Update user successfully'
            ], REST_Controller::HTTP_CREATED); } 
	else {
	$result = "Problems on locations: ".$message;
	$this->set_response([
                'status' => FALSE,
                'message' => $result
            ], REST_Controller::HTTP_BAD_REQUEST); 
	}
	
        
    }

}
