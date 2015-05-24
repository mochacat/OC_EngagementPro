<?php
class ControllerAccountEngagementPro extends Controller {
    
    public function addSearch()
    {
        $this->load->model('account/engagement_pro');
        
        $json = array();
        if (isset($this->request->post['search']))
        {
            //grab customer info
            $search_data = $this->getCustomerData();
            $search_data['data'] = $this->request->post['search'];
            $key = 'search';
            $this->model_account_engagement_pro->add($key, $search_data);
        }
    }
    
    public function getCustomerData()
    {
        $customer = array();
        $customer['customer_id'] = ($this->customer->isLogged()) ? $this->customer->getId() : 0 ;
        $customer['ip'] = $this->request->server['REMOTE_ADDR'];
        return $customer;
    }
}
