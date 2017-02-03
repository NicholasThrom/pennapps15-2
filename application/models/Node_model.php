<?php
class Node_Model extends CI_Model
{// Checks

    public function doesExist($id, $action)
    {
        $result = $this->db->where('source_node',$id)->where('action',$action)->get('node')->result_array();
        return count($result) > 0;
    }

    public function doesIdExist($id)
    {
        $result = $this->db->where('id_node',$id)->get('node')->result_array();
        return count($result) > 0;
    }

    // Gets

    public function getNode($id)
    {
        $result = $this->db->where('id_node', $id)->where('reports <', MAX_REPORTS)->get('node')->result_array();
        if (count($result))
        {
            $this->db->where('id_node', $id)->update('node', array('clicks'=>min($result[0]['clicks'] + 1, $result[0]['views']), 'hits'=>$result[0]['hits'] + 1));
            return $result[0];
        }
        // If the right ID does not exist:
        $result = $this->db->get('node')->result_array();
        if (count($result))
        {
            $this->db->where('id_node', $id)->update('node', array('clicks'=>min($result[0]['clicks'] + 1, $result[0]['views']), 'hits'=>$result[0]['hits'] + 1));
            return $result[0];
        }
    }

    public function getOptions($id)
    {
        $list = $this->db->where('source_node', $id)->where('reports <', MAX_REPORTS)->get('node')->result_array();
        shuffle($list);

        $total = 0;

        for ($i = 0; $i < count($list); $i++)
        {
            $list[$i]['columnlessScore'] = $this->score($list[$i]['clicks'], $list[$i]['views']);
            $total += $list[$i]['columnlessScore'];
        }

        $result = array();

        for ($iteration = 0; $iteration < 3 && $iteration < count($list); $iteration++)
        {
            $randomValue = rand(1, $total);
            $subtotal = 0;

            for ($i = 0; $i < count($list); $i++)
            {
                $subtotal += $list[$i]['columnlessScore'];
                if ($subtotal >= $randomValue)
                {
                    $total -= $list[$i]['columnlessScore'];
                    $list[$i]['columnlessScore'] = 0;
                    $result[] = $list[$i];
                    break;
                }
            }
        }

        foreach($result as $res)
        {
            $this->db->where('id_node',$res['id_node'])->update('node',array('views'=>$res['views'] + 1, 'hits'=>$res['hits'] + 1));
        }

        return $result;
    }

    public function getLog($id)
    {
        $data = array();

        while ($id >= 0)
        {
            $newNode = $this->getNode($id);
            $data[] = $newNode;
            $id = $newNode["source_node"];
        }

        return $data;
    }

    // Sets

    public function addNode($parent, $action, $description)
    {
        if($this->doesExist($parent,$action))
        {
            return -1;
        }

        $this->db->insert('node', array(
            'source_node' => $parent,
            'action' => htmlspecialchars($action),
            'description' => htmlspecialchars($description),
            'ip' => $_SERVER['REMOTE_ADDR'],
            'timestamp' => date('Y-m-d H:i:s')
        ));
        return $this->db->insert_id();
    }

    public function removeFreeNodes()
    {
        $count = 0;

        foreach($this->db->get('node')->result_array() as $node)
        {
            if($node['source_node'] > 0 && !$this->doesIdExist($node['source_node']))
            {
                $this->db->where('id_node', $node['id_node'])->delete('node');
                $count++;
            }
        }

        return $count;
    }

    public function report($id)
    {
        $result = $this->db->where('id_node', $id)->where('reports <', MAX_REPORTS)->get('node')->result_array();
        if (count($result) && $result[0]['reports'] >= 0)
        {
            $this->db->where('id_node',$result[0]['id_node'])->update('node', array('reports'=>$result[0]['reports'] + 1));
        }
    }

    // Calculations

    public function score($clicks, $views)
    {
        return round(100 * (min($clicks, $views) + 7) / ($views + 5) + 0.05);
    }
}
?>
