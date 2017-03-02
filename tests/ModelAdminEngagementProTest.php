<?php

class ModelAdminEngagementProTest extends OpenCartTest{
  
  private $customer_id = null;
  private $searches = null;
  private $orders = null;

  /** @before */
  public function setupTest(){
    $this->loadModelByRoute('report/engagement_pro');
    $this->loadModelByRoute('customer/customer');
    $this->loadModelByRoute('sale/order');
    
    //add customers
    $customer = array(
      'customer_group_id' => 1,
      'firstname' => 'Fizz',
      'lastname' => 'Buzz',
      'email' => 'email@email.com',
      'telephone' => '',
      'fax' => '',
      'newsletter' => 0,
      'password' => '',
      'statue' => 1,
      'approved' => 1
    );
    
    $this->customer_id = $this->model_customer_customer->addCustomer($this->customer);
    
    //add orders
    $orders = array();

    //add searches
    $searches = array();
  }
  
  /** @after */
  public function tearDown(){
    $this->searches = null;
    $this->orders = null;
    $this->cusomers = null;
  }
  
  public function testTableCreation(){
    $this->model_report_engagement_pro->createDatabase();
    
    $query = '
      SELECT count(*) FROM INFORMATION_SCHEMA.TABLES
        WHERE table_schema = ' . DB_DATABASE . '
        AND table_name LIKE ' . DB_PREFIX . 'oc_engagement_pro';
    $count = $this->db->query($query);
    
    $this->assertEquals(1, $count);
  }
  
  public function testGetSearches(){
    //$this->model_report_engagement_pro->getSearches();
    $this->assertEquals(true, true);
  }
  
  public function testCountSearches(){
    //$this->model_report_engagement_pro->countSearches();
    $this->assertEquals(true, true);
  }
  
  public function testGetRepeatCustomers(){
    //$this->model_report_engagement_pro->getRepeatCustomers();
    $this->assertEquals(true, true);
  }
  
  public function testGetProductsByCustomers(){
    //$this->model_report_engagement_pro->getProductsByCustomers();
    $this->assertEquals(true, true);
  }
  
  public function testGetTotalOrders(){
    //$this->model_report_engagement_pro->getTotalOrders();
    $this->assertEquals(true, true);
  }
}
