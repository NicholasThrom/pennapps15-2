<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
    public function index()
    {
        if ($this->user_model->checkIp($_SERVER['REMOTE_ADDR']))
        {
            $data = array();
            $data['headdata'] = array();
            $data['viewdata'] = array();
            $data['view'] = 'user/login';
            $data['footdata'] = array();

            $user = $this->user_model->user();

            $this->load->view("template", $data);
        }
    }

    public function info()
    {
        if ($this->user_model->checkIp($_SERVER['REMOTE_ADDR']))
        {
            $user = $this->user_model->user();

            if ($user == null)
            {
                $this->login();
            }

            $data = array();
            $data['headdata'] = array();
            $data['viewdata'] = array();
            $data['view'] = 'user/info';
            $data['footdata'] = array();

            $data['viewdata']['user'] = $user;

            $this->load->view("template", $data);
        }
    }

    public function logout()
    {
        if ($this->user_model->checkIp($_SERVER['REMOTE_ADDR']))
        {
            $user = $this->user_model->user();

            if ($user == null)
            {
                $this->login();
            }

            $data = array();
            $data['headdata'] = array();
            $data['viewdata'] = array();
            $data['view'] = 'user/logout';
            $data['footdata'] = array();

            $user = $this->user_model->user();

            $this->load->view("template", $data);
        }
    }

    public function login()
    {
        if ($this->user_model->checkIp($_SERVER['REMOTE_ADDR']))
        {
            $user = $this->user_model->user();

            if ($user != null)
            {
                $this->info();
            }

            $data = array();
            $data['headdata'] = array();
            $data['viewdata'] = array();
            $data['view'] = 'user/login';
            $data['footdata'] = array();

            $user = $this->user_model->user();

            $this->load->view("template", $data);
        }
    }

    public function create()
    {
        if ($this->user_model->checkIp($_SERVER['REMOTE_ADDR']))
        {
            $data = array();
            $data['headdata'] = array();
            $data['viewdata'] = array();
            $data['view'] = 'user/create';
            $data['footdata'] = array();

            $user = $this->user_model->user();

            $this->load->view("template", $data);
        }
    }
}
