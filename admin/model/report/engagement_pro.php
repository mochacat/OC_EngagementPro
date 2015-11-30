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
    
    /* Get searches made by customers in the store front
     * 
     * @param $data array
     * @return object
     */
    public function getSearches($data)
    {
        $sql = '
            SELECT *
            FROM '. DB_PREFIX . 'engagement_pro as ep
            WHERE ep.key = "search"';
        
        if (!empty($data['filter_customer'])) {
			$sql .= " AND ep.customer_id = '" . $this->db->escape($data['filter_customer']) . "'";
		}

		if (!empty($data['filter_ip'])) {
			$sql .= " AND ep.ip LIKE '" . $this->db->escape($data['filter_ip']) . "'";
		}

		if (!empty($data['filter_date_start'])) {
			$start = $data['filter_date_start'];
			$sql .= " AND DATE(ep.date_added) >= '" . $this->db->escape($start) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			//make sure end date is after start date
			if (isset($start)){
				if ($data['filter_date_end'] >= $start){
					$sql .= " AND DATE(ep.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
				}
			}
		}
        
		if ($data['limit']){
			$sql .= '
				ORDER BY ep.date_added DESC
			    LIMIT ' . (int)$data['limit'];
		}
		
        if ($data['start']){
            $sql .= ' 
                OFFSET ' . (int)$data['start'];
        }
		
        $query = $this->db->query($sql);
        return $query->rows;
    }
    
    /* Count the number of total searches
     *
     * @param data array
     * @return int
     */
    public function countSearches($data){

        $sql = '
            SELECT COUNT(*) as search_count
            FROM '. DB_PREFIX . 'engagement_pro as ep
            WHERE ep.`key` = "search"';
        
        if (!empty($data['filter_customer'])) {
			$sql .= " AND ep.`customer_id` = '" . $this->db->escape($data['filter_customer']) . "'";
		}

		if (!empty($data['filter_ip'])) {
			$sql .= " AND ep.ip LIKE '" . $this->db->escape($data['filter_ip']) . "'";
		}

		if (!empty($data['filter_date_start'])) {
			$start = $data['filter_date_start'];
			$sql .= " AND DATE(ep.date_added) >= '" . $this->db->escape($start) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			if (isset($start)){
				if ($data['filter_date_end'] >= $start){
					$sql .= " AND DATE(ep.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
				}
			}
		}
        
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
     * @param customer_id int
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
     * @param customer_id int
     * @return int
     */
    public function getTotalOrders($customer_id) 
    {
        $query = $this->db->query('SELECT COUNT(*) AS total 
                FROM ' . DB_PREFIX . 'order as o
                WHERE o.customer_id = "' . (int)$customer_id . '"');
        return $query->row['total'];
    }
}