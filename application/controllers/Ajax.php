<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller
{
    public function addNode()
    {
        if ($this->user_model->checkIp($_SERVER['REMOTE_ADDR']))
        {
            if ($this->input->post("a") != null && $this->input->post("d") != null && $this->input->post("i") != null)
            {
                echo $this->node_model->addNode($this->input->post("i"), $this->input->post("a"), $this->input->post("d"));
            }
        }
    }


    public function fileReport()
    {
        if ($this->user_model->checkIp($_SERVER['REMOTE_ADDR']))
        {
            if($this->input->post("i"))
            {
                $this->node_model->report($this->input->post("i"));
            }
        }
    }


    public function login()
    {
        if ($this->user_model->checkIp($_SERVER['REMOTE_ADDR']))
        {
            $this->user_model->logout();

            if($this->input->post("u") && $this->input->post("p"))
            {
                echo $this->user_model->login($this->input->post("u"), $this->input->post("p")) ? 1 : 0;
            }
        }
    }


    public function logout()
    {
        if ($this->user_model->checkIp($_SERVER['REMOTE_ADDR']))
        {
            $this->user_model->logout();
        }
    }


    public function createUser()
    {
        if ($this->user_model->checkIp($_SERVER['REMOTE_ADDR']))
        {
            if($this->input->post("u") && $this->input->post("p"))
            {
                $this->user_model->logout();

                $result = $this->user_model->userCreate($this->input->post("u"), $this->input->post("p")) ? 1 : "Username already taken.";

                if ($result = 1)
                {
                    $this->user_model->login($this->input->post("u"), $this->input->post("p"));
                }

                echo $result;
            }
        }
    }
}
