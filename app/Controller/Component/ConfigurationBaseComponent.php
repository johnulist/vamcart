<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class ConfigurationBaseComponent extends Object 
{

	public function beforeFilter ()
	{
	}

	public function initialize(Controller $controller) {
	}
    
	public function startup(Controller $controller) {
	}

	public function shutdown(Controller $controller) {
	}

	public function beforeRedirect(Controller $controller){
	}
    
	public function beforeRender(Controller $controller){
	}
	
	public function load_configuration ()
	{
		$config_values = Cache::read('vam_config');
		
		if($config_values === false)
		{
			App::import('Model', 'Configuration');
				$Configuration =& new Configuration();
	
			$configuration_values = $Configuration->find('all');

			$config_values = array_combine(Set::extract($configuration_values, '{n}.Configuration.key'),
						 		 Set::extract($configuration_values, '{n}.Configuration.value'));		

			Cache::write('vam_config', $config_values, intval($config_values['CACHE_TIME']));
		}
		
		return $config_values;
		
	}	
}
?>