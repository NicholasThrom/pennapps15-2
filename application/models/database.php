<?php
class Database extends CI_Model
{
    public function doesChatExist($name)
    {
        $this->db->where('url', $name);
        $query = $this->db->get('chat');
        if (empty($query->result()))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function getChatId($name)
    {
        if ($this->doesChatExist($name))
        {
            $this->db->where('url', $name);
            $query = $this->db->get('chat');
            return $query->row()->id_chat;
        }
        else
        {
            return -1;
        }
    }

    public function createChat($name)
    {
        if (!$this->doesChatExist($name))
        {
            $this->db->insert('chat', array('url' => $name));
        }
    }

    public function getChat($name, $id)
    {
        if ($this->doesChatExist($name))
        {
            $this->db->where('chat_id', $this->getChatId($name));
            $this->db->order_by('id_message', 'ASC');
            $this->db->where('id_message >', $id);
            $query = $this->db->get('message');
            return $query->result_array();
        }
    }

    public function addChat($name, $content, $user)
    {
        if ($this->doesChatExist($name))
        {
            $this->db->insert('message', array('chat_id' => $this->getChatId($name), 'content' => $content, 'user' => $user));
        }
    }
}
