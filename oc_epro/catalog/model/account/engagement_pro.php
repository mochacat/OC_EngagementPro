<?php
class ModelAccountEngagementPro extends Model 
{
    public function add($key, $data) 
    {
        if (!$this->tableExists())
        {
            $this->createDatabase();
        }
        
        $sql = "
            INSERT INTO `" . DB_PREFIX . "engagement_pro` 
            SET 
                `customer_id` = '" . (int)$data['customer_id'] . "', 
                `key` = '" . $this->db->escape($key) . "', 
                `data` = '" . $this->db->escape(serialize($data['data'])) . "', 
                `ip` = '" . $this->db->escape($data['ip']) . "'";
       $this->db->query($sql);
    }
    
    private function tableExists()
    {
        $table_exists = $this->db->query('
            SELECT * 
            FROM information_schema.tables
            WHERE table_schema = \'' . DB_DATABASE . '\'
                AND table_name = \''.DB_PREFIX.'engagement_pro\'
            LIMIT 1
            ');
        return $table_exists->num_rows;
    }
}