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
        if($this->doesExist($parent,$action))
        {
            return -1;
        }

        $this->db->insert('node', array(
            'source_node' => $parent,
            'action' => htmlspecialchars($action),
            'description' => htmlspecialchars($description)
        ));
        return $this->db->insert_id();
    }

    public function getOptions($id)
    {
        $result = $this->db->where('source_node', $id)->get('node')->result_array();
        shuffle($result);
        return array_slice($result,0,min(count($result),3));
    }

    public function doesExist($id, $action)
    {
        $result = $this->db->where('source_node',$id)->where('action',$action)->get('node')->result_array();
        return count($result) > 0;
    }
}
?>
