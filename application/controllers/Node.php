<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Node extends CI_Controller
{
    public function index()
    {
        if ($this->user_model->checkIp($_SERVER['REMOTE_ADDR']))
        {
            $data = array();
            $data['headdata'] = array();
            $data['view'] = "node/node";
            $data['viewdata'] = array();
            $data['footdata'] = array();

            $id_node = $this->input->get("i");
            $id_node = $id_node != null ? $id_node : 1;

            if ($id_node < 1)
            {
                $id_node = 1;
            }

            $data['viewdata']['node'] = $this->node_model->getNode($id_node);
            $id_node = $data['viewdata']['node']['id_node'];
            $data['viewdata']['id_node'] = $id_node;
            $data['viewdata']['options'] = $this->node_model->getOptions($id_node);
            $this->load->view("template", $data);
        }
    }

    public function log()
    {
        if ($this->user_model->checkIp($_SERVER['REMOTE_ADDR']))
        {
            $data = array();
            $data['headdata'] = array();
            $data['view'] = "node/log";
            $data['viewdata'] = array();
            $data['footdata'] = array();

            $id_node = $this->input->get("i");
            $id_node = $id_node != null ? $id_node : 1;

            if ($id_node < 1)
            {
                $id_node = 1;
            }

            $data['viewdata']['nodes'] = $this->node_model->getLog($id_node);
            $this->load->view("template", $data);
        }
    }

    // AJAX Pages

    public function trimTree()
    {
        if ($this->user_model->checkIp($_SERVER['REMOTE_ADDR']))
        {
            echo "Deleted ".$this->node_model->removeFreeNodes()." nodes.";
        }
    }
}
