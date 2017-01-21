<?php
class Database extends CI_Model
{
    public function getNode($id)
    {
        $result = $this->db->where('id_node', $id)->get('node')->result_array();

        if (count($result))
        {
            return $result[0];
        }

        // If the right ID does not exist:

        $result = $this->db->get('node')->result_array();

        if (count($result))
        {
            return $result[0];
        }
    }

    public function addNode($parent, $action, $description)
    {
        $this->db->insert('node', array(
            'source_node' => $parent,
            'action' => $action,
            'description' => $description
        ));

        return $this->db->insert_id();
    }
}
?>
