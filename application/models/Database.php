<?php
class Database extends CI_Model
{
    public function getNode($id)
    {
        $result = $this->db->where('id_node', $id)->get('node')->result_array();
        if (count($result))
        {
            $this->db->where('id_node', $id)->update('node', array('clicks'=>$result[0]['clicks'] + 1));
            return $result[0];
        }
        // If the right ID does not exist:
        $result = $this->db->get('node')->result_array();
        if (count($result))
        {
            $this->db->where('id_node', $id)->update('node', array('clicks'=>$result[0]['clicks'] + 1));
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
        $result = array_slice($result, 0, min(count($result), 3));
        foreach($result as $res)
        {
            $this->db->where('id_node',$res['id_node'])->update('node',array('views'=>$res['views'] + 1));
        }
        return $result;
    }

    public function doesExist($id, $action)
    {
        $result = $this->db->where('source_node',$id)->where('action',$action)->get('node')->result_array();
        return count($result) > 0;
    }

    public function doesIdExist($id)
    {
        $result = $this->db->where('source_node',$id)->get('node')->result_array();
        return count($result) > 0;
    }

    public function report($id)
    {
        $result = $this->db->where('id_node', $id)->get('node')->result_array();
        if (count($result) && $result[0]['reports'] >= 0)
        {
            $this->db->where('id_node',$result[0]['id_node'])->update('node',array('reports'=>$result[0]['reports'] + 1));
        }
    }

    public function removeFreeNodes()
    {
        $count = 0;
        foreach($this->db->get('node')->result_array() as $node)
        {
            if(!doesIdExist($node['source_node']))
            {
                $this->db->where('id_node', $node['id_node'])->delete('node');
                $count++;
            }
        }
        return $count;
    }
}
?>
