<?php

class ModelReportEngagementPro extends Model
{
    /* Create Engagement Pro database if it doesn't exist
     * 
     */
    public function createDatabase()
    {
        $table_exists = $this->db->query('
            SELECT * 
            FROM information_schema.tables
            WHERE table_schema = \'' . DB_DATABASE . '\'
                AND table_name = \''.DB_PREFIX.'engagement_pro\'
            LIMIT 1
            ');
        
        if (!$table_exists->num_rows)
        {
            $sql = 'CREATE TABLE ' . DB_PREFIX . 'engagement_pro 
                    (
                        `engagement_id` INT(11) AUTO_INCREMENT, 
                        `customer_id` INT(11),
                        `ip` VARCHAR(15),
                        `key` VARCHAR(64),
                        `data` BLOB,
                        `date_added` TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
                        PRIMARY KEY (`engagement_id`)
                    )';
            $query = $this->db->query($sql);
        }
    }
    
    /* Get total searches made by customers in the store front
     * 
     * @param $start int
     * @param $limit int
     * 
     * @return object
     */
    public function getSearches($start = 0, $limit = 20)
    {
        $sql = '
            SELECT *
            FROM '. DB_PREFIX . 'engagement_pro
            WHERE `key` = "search"
            ORDER BY date_added DESC
            LIMIT ' . (int)$limit;
            
        if ($start > 0){
            $sql .= ' 
                OFFSET ' . (int)$start;
        }
        
       $query = $this->db->query($sql);
       return $query->rows;
    }
    
    /* Grab all the searches
     * 
     * @return int
     */
    public function countSearches()
    {
        $sql = '
            SELECT COUNT(*) as search_count
            FROM '. DB_PREFIX . 'engagement_pro
            WHERE `key` = "search"';
        
        $query = $this->db->query($sql);
        return $query->rows[0]['search_count'];
    }
    
    /* Grab customers who have made repeat purchases
     * 
     * @return array
     */
    public function getRepeatCustomers()
    {
        $customers = [];
        $repeat_customers = [];
        $sql = '
            SELECT o.customer_id, p.product_id, o.order_id
            FROM '. DB_PREFIX . 'order AS o
                LEFT JOIN '. DB_PREFIX . 'order_product AS p ON  p.order_id= o.order_id
            ORDER BY o.customer_id
            ';        
        $query = $this->db->query($sql);
        
        foreach ($query->rows as $row)
        {
            if (in_array($row['customer_id'], $customers)){
                if (!(in_array($row['customer_id'], $repeat_customers)))
                    $repeat_customers[] = $row['customer_id'];
            }
            else{
                $customers[] = $row['customer_id'];
            }
        }
        return $repeat_customers;
    }
    
    /* Get all products purchased per customer
     * 
     * @return string
     */
    public function getProductsByCustomer($customer_id)
    {
        $sql = '
            SELECT p.product_id
            FROM '. DB_PREFIX . 'order AS o
                LEFT JOIN '. DB_PREFIX . 'order_product AS p ON  p.order_id= o.order_id
            WHERE o.customer_id = "' . (int)$customer_id . '" 
            ';
        $query = $this->db->query($sql);
        return $query->rows;
    }
    
    /* Grab total orders per customer
     * 
     * @return int
     */
    public function getTotalOrders($customer_id) 
    {
        $query = $this->db->query('SELECT COUNT(*) AS total 
                FROM ' . DB_PREFIX . 'order 
                WHERE customer_id = "' . (int)$customer_id . '"');
        return $query->row['total'];
    }
}