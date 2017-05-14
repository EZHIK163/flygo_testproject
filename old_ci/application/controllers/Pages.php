<?php


class Pages extends CI_Controller {

	public function view($page = 'home')
	{
			if ( ! file_exists(APPPATH.'/views/pages/'.$page.'.php'))
			{
					// Упс, у нас нет такой страницы!
					show_404();
			}
			$this->load->database();
			$data['title'] = ucfirst($page); // Capitalize the first letter

			$this->load->view('header', $data);
			$this->load->view('pages/'.$page, $data);
			$this->load->view('footer', $data);
	}
	public function user($id)
	{
		$sql = "SELECT * FROM users WHERE id = ?";
		$query = $this->db->query($sql, array($id));
		$row = $query->row();

		if (isset($row))
		{
			echo $row->name;
			echo $row->biography;
			echo $row->tel_number;
		}

	}

	public function add_user()
	{
		$data = array('name' => $name, 'email' => $email, 'url' => $url);
		$str = $this->db->insert_string('table_name', $data);
	}

	public function update_user()
	{
	$data = array('name' => $name, 'email' => $email, 'url' => $url);

	$where = "author_id = 1 AND status = 'active'";

	$str = $this->db->update_string('table_name', $data, $where);
	}


}
