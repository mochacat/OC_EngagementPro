<?php
class ControllerReportEngagementPro extends Controller {
    public function index() {
        $this->load->language('report/engagement_pro');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('report/engagement_pro');
        $this->model_report_engagement_pro->createDatabase();

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
            'text' => $this->language->get('text_home')
        );

        $data['breadcrumbs'][] = array(
            'href' => $this->url->link('report/engagement_pro', 'token=' . $this->session->data['token'], 'SSL'),
            'text' => $this->language->get('heading_title')
        );

        $data['heading_title'] = $this->language->get('heading_title');

        $data['pane_title'] = $this->language->get('pane_title');

        $data['token'] = $this->session->data['token'];
		$url = '';
		
        if (isset($this->request->get['page'])) 
        {
            $page = $this->request->get['page'];
		} 
        else 
        {
            $page = 1;
		}
			
        //Search Tab
        $lang['search'] = array(
            'tab_search', 'search_query', 'search_customer', 'search_ip',
            'search_date', 'entry_date_start', 'entry_date_end', 'entry_ip',
			'entry_customer','button_filter'
        );
		
		//Filters
		
		$filter_data = array();
		
		$lang['filters'] = array(
			'filter_date_start', 'filter_date_end', 'filter_ip',
			'filter_customer'
		);
		
        foreach ($lang['filters'] as $filter){
			if (isset($this->request->get[$filter])){
				$filter_get = $this->request->get[$filter];

				$url .= '&' . $filter . '=' . urlencode($filter_get); //pagination url
				$data[$filter] = $filter_get; //filter text
				
				if ($filter == 'filter_customer'){
					$this->load->model('sale/customer');
					//need id, not name for db
					$customer = $this->model_sale_customer->getCustomers(array('filter_name' => $filter_get));
					if(isset($customer[0]['customer_id'])){
						$filter_get = $customer[0]['customer_id'];	
					}
				}
				$filter_data[$filter] = $filter_get; //filter results from db
			} else {
				$filter_data[$filter] = ''; //nothing to filter from db
				$data[$filter] = ''; 
			}
		}
		
		$filter_data['start'] = ($page - 1) * $this->config->get('config_limit_admin');
		$filter_data['limit'] = $this->config->get('config_limit_admin');
	
        $search_query = $this->model_report_engagement_pro->getSearches($filter_data);
        
        $data['totals']['search'] = $this->model_report_engagement_pro->countSearches($filter_data);
        $data['results']['search'] = ($data['totals']['search']) ? $this->formatSearches($search_query) : 0;
        
        //Repeat Tab
        $lang['repeat'] = array(
            'tab_repeat', 'repeat_customer', 'repeat_products', 'repeat_count'
        );
        
        $repeat_customers = $this->model_report_engagement_pro->getRepeatCustomers();

        $data['results']['repeat'] = $this->formatRepeatCustomers($repeat_customers);
        $data['totals']['repeat'] = count($repeat_customers);
        
        $tabs = array('search', 'repeat');
        
        foreach ($tabs as $tab)
        {
            //add language variables
            foreach ($lang[$tab] as $tab_lang)
            {
                $data[$tab_lang] = $this->language->get($tab_lang);
			}
			
            //need paginations for all tabs
            $pagination = $this->createPagination($url, $data['totals'][$tab], $page);
            $data['pagination'][$tab] = $pagination->render();
            
            $data['pages'][$tab] = sprintf(
                $this->language->get('text_pagination'), 
                ($data['totals'][$tab]) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, 
                ((($page - 1) * $this->config->get('config_limit_admin')) > ($data['totals'][$tab] - $this->config->get('config_limit_admin'))) ? $data['totals'][$tab] : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), 
                $data['totals'][$tab]
                , ceil($data['totals'][$tab] / $this->config->get('config_limit_admin')));
        }
        
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('report/engagement_pro.tpl', $data));
    }
    
    /* Create pagination for each tab type
     *
     * @param $url string
     * @param $total int
     * @param $page int
     * 
     * @return object
     */
    public function createPagination($url, $total, $page)
    {
        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('report/engagement_pro', 'token=' 
            . $this->session->data['token'] . $url . '&page={page}', 'SSL');
        
        return $pagination;
    }
    
    /* Format searches for the admin
     * 
     * @param array $search_results
     * 
     * @return array 
     */
    public function formatSearches($search_results)
    {
        $this->load->model('sale/customer');
        
        $format_search = array();
        $i = 0;
        foreach ($search_results as $result)
        {
            if ($result['customer_id'])
            {
                $customer = $this->model_sale_customer->getCustomer($result['customer_id']);
                $format_search[$i]['customer']['name'] = $customer['firstname'] . ' ' . $customer['lastname'];
                $format_search[$i]['customer']['url'] = $this->url->link(
                    'sale/customer/edit', 
                    'token=' . $this->session->data['token'] . '&customer_id=' . $result['customer_id'], 
                    'SSL');
            }
            else
            {
                $format_search[$i]['customer']['name'] = "Guest";
                $format_search[$i]['customer']['url'] = '';
            }
            
            $format_search[$i]['data'] = unserialize($result['data']);
            $format_search[$i]['ip'] = $result['ip'];
            $format_search[$i]['date'] = $result['date_added'];
            
            $i++;
        }
        return $format_search;
    }
    
    /* Format customers for the admin
     * 
     * @param array $customer_ids
     * 
     * @return array 
     */
    public function formatRepeatCustomers($customer_ids)
    {
        $this->load->model('sale/customer');
        $this->load->model('catalog/product');
        $format_repeat = array();
        $i = 0;
        foreach ($customer_ids as $customer_id)
        {
            if ($customer_id)
            {
                $customer = $this->model_sale_customer->getCustomer($customer_id);
                $format_repeat[$i]['customer']['name'] = $customer['firstname'] . ' ' . $customer['lastname'];
                $format_repeat[$i]['customer']['url'] = $this->url->link(
                        'sale/customer/edit', 
                        'token=' . $this->session->data['token'] . '&customer_id=' . $customer_id, 
                        'SSL');
                
                $product_ids = $this->model_report_engagement_pro->getProductsByCustomer($customer_id);
                $p = 0;
                foreach ($product_ids as $product_id)
                {
                    $product = $this->model_catalog_product->getProduct($product_id['product_id']);
                    $format_repeat[$i]['products'][$p]['name'] = $product['name'];
                    $format_repeat[$i]['products'][$p]['url'] = $this->url->link(
                        'catalog/product/edit', 
                        'token=' . $this->session->data['token'] . '&product_id=' . $product_id['product_id'], 
                        'SSL');
                    $p++;
                }
                $format_repeat[$i]['count'] = $this->model_report_engagement_pro->getTotalOrders($customer_id);
            }
            $i++;
        }
        return $format_repeat;
    }
}