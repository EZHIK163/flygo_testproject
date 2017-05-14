<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyUser extends CI_Model{


	public function get_users()
	{
		$sql = 'SELECT users.id, users.name, users.biography, users.tel_number, locations.name FROM users 
		JOIN locations ON users.id_location = locations.id';
		$query = $this->db->query($sql);
		//$rows = $query->custom_result_object();
		//$data = array();
	   	foreach ($query->result_array() as $row){
	   		 $data[] = $row;
	   	}
		return $data;
	}
	public function get_users_for_locations($locations)
	{
		$data = array();
		$sql = 'SELECT users.name FROM users 
		JOIN locations ON users.id_location = locations.id WHERE locations.name = ?';
		$query = $this->db->query($sql, $locations);
		//$rows = $query->custom_result_object();
		//$data = array();
	   	foreach ($query->result_array() as $row){
	   		 $data[] = $row;
	   	}
		return $data;
	}
	public function get_user($id)
	{
		$sql = 'SELECT users.id, users.name, users.biography, users.tel_number, locations.name FROM users 
		JOIN locations ON users.id_location = locations.id WHERE users.id = ?';
		$query = $this->db->query($sql, $id);
		$row = $query->row();
		if (isset($row))
		{	//echo $row;
			return $row;
		}
	}
	public function add_user($name, $biography, $location, $tel_number)
	{
		$result = "";
		
			$id_location = $this->getIDlocation($location);
			if ($id_location != 0)
			{		
				$array_arguments[] = array(
					"name" => $name,
					"biography" => $biography,
					"id_location" => $id_location,
					"tel_number" => $tel_number
				);
			}
			else
			{
				$result = $location."; ";
			}
		if(isset($array_arguments)) $this->db->insert_batch('users', $array_arguments);
		return $result;
	}
	public function clone_user($id)
	{
		$sql = 'SELECT * FROM users WHERE users.id = ?';
		$query = $this->db->query($sql, $id);
		$user = $query->row();
		if (isset($user))
		{	
			$sql = "INSERT INTO users (name,biography,tel_number,id_location) VALUES (? , ? , ? , ?)";
			$this->db->query($sql, array($user->name, $user->biography, $user->tel_number, $user->id_location));

			$sql = 'SELECT users.id FROM users WHERE name = ? AND biography = ? AND tel_number = ? and id_location = ? ORDER BY id DESC ';
			$query = $this->db->query($sql, array($user->name, $user->biography, $user->tel_number, $user->id_location));
			$row = $query->row();
			if (isset($row))
			{	//echo $row;
				return $row->id;
		}
		}
		return -1;
	}
	
	public function getIDlocation($name_location)
	{
		$id_location = 0;
		$sql = "SELECT id FROM locations WHERE name = ?";
		$query = $this->db->query($sql, $name_location);
		$row = $query->row();
		if (isset($row))
		{
			$id_location = $row->id;
		}
		return $id_location;
	}
	public function update_user($id, $name, $biography, $location, $tel_number)
	{
		$result = "";
		$id_location = $this->getIDlocation($location);
		if ($id_location != 0)
		{		
			$sql = "UPDATE users SET name = ? , biography = ? , id_location = ?, tel_number = ? WHERE id = ?";
			$this->db->query($sql, array($name, $biography, $id_location, $tel_number, $id));
		}
		else
		{
			$result = $location."; ";
		}
		
		return $result;
	}

	public function delete_user($id)
	{
		$sql = "DELETE FROM users WHERE id = ?";
		return $this->db->query($sql, $id);
	}

	
}
