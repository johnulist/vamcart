<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('ShippingAppController', 'Shipping.Controller');

class EmsRussianPostShippingController extends ShippingAppController {
	var $uses = array('ShippingMethod');
	var $module_name = 'EmsRussianPostShipping';
	var $icon = 'ems.png';

	function settings ()
	{
		$this->set('data', $this->ShippingMethod->findByCode($this->module_name));
	}

	function install()
	{

		$new_module = array();
		$new_module['ShippingMethod']['active'] = '1';
		$new_module['ShippingMethod']['default'] = '0';
		$new_module['ShippingMethod']['name'] = Inflector::humanize($this->module_name);
		$new_module['ShippingMethod']['icon'] = $this->icon;
		$new_module['ShippingMethod']['code'] = $this->module_name;

		$new_module['ShippingMethodValue'][0]['shipping_method_id'] = $this->ShippingMethod->id;
		$new_module['ShippingMethodValue'][0]['key'] = 'city';
		$new_module['ShippingMethodValue'][0]['value'] = 'Москва';

		$this->ShippingMethod->saveAll($new_module);

		$this->Session->setFlash(__('Module Installed'));
		$this->redirect('/shipping_methods/admin/');
	}

	function uninstall()
	{

		$module_id = $this->ShippingMethod->findByCode($this->module_name);

		$this->ShippingMethod->delete($module_id['ShippingMethod']['id'], true);
			
		$this->Session->setFlash(__('Module Uninstalled'));
		$this->redirect('/shipping_methods/admin/');
	}

	function calculate ()
	{
		$method = $this->ShippingMethod->findByCode($this->module_name);

			global $order;
			
        $from_city = strtolower('city--Moskva');
        $to_city = strtolower('city--'.$order['Order']['bill_city']);
        $shipping_weight = 3;

        
        $url = 'http://emspost.ru/api/rest?method=ems.calculate&from='.$from_city.'&to='.$to_city.'&weight='.$shipping_weight;

        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $url);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);  

        $contents = $output;
        $contents = utf8_encode($contents);
        $results = json_decode($contents, true); 

		return $results['rsp']['price'];
	}

	function before_process()
	{
	}
	
}

?>