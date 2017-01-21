<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


	public function index()
	{
		$id_node = $this->input->get("i");
		$id_node = $id_node != null ? $id_node : 1;

		$data = array();
		$data['node'] = $this->database->getNode($id_node);
		$data['id_node'] = $id_node;
		$this->load->view("home", $data);
	}

	public function addNode()
	{
		echo $this->input->get("a");
		echo $this->input->get("d");
		echo $this->input->get("i");

		if ($this->input->get("a") != null && $this->input->get("d") != null && $this->input->get("i") != null)
		{
			$this->database->addNode($this->input->get("i"), $this->input->get("a"), $this->input->get("d"));
		}
	}
}
