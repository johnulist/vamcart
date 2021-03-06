<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

App::uses('Controller/Component', 'SessionComponent');
App::uses('Model', 'Content');
App::uses('Model', 'ContentDescription');

class ContentBaseComponent extends Object
{
    public $components = array('Session','Smarty');

	public function beforeFilter ()
	{
	}
	
	public function initialize(Controller $controller) {
	}
    
	public function startup(Controller $controller) {
	$this->load_models();
	}

	public function shutdown(Controller $controller) {
	}
    
	public function beforeRender(Controller $controller){
	}
	
	public function beforeRedirect(Controller $controller){
	}

	public function load_models ()
	{
		// We're loading the Session component here because the smarty plugin can't yet
		
		$this->Session = new SessionComponent(new ComponentCollection());

		$this->Content = new Content();

		$this->ContentDescription = new ContentDescription();
	}


	/**
	* Returns the ID of the default page
	*
	*/
	public function default_content ()
	{
		$content = $this->Content->find('first', array('conditions' => array('Content.default' => '1')));
		$content_id = $content['Content']['id'];

		return $content_id;
	}


	/**
	* Unbinds all content descriptions.
	* Binds content description with a HasOne association
	*
	* @param int $content_id ID of content page to Get
	* @return  array  Content descriptions
	*/
	public function get_content_description ($content_id = null)
	{
		if ($content_id == null) {
			$content_id = $this->default_content();
		}

		$this->load_models();
		 
		$content_description = $this->ContentDescription->find('first', array('conditions' => array('content_id' => $content_id, 'language_id' => $this->Session->read('Customer.language_id'))));
 
		return $content_description;
	}

	/**
	* Unbinds all content descriptions and retuns the content.
	*
	* @param int $content_id ID of content page to Get
	* @return  array  Content without the descriptions
	*/
	public function get_content_information ($content_alias)
	{
		$this->load_models();

		if ($content_alias == "") {
			$content_alias = $this->default_content();
		}

		// Unbind all models then rebind just the ones we'll need
		$this->Content->unbindAll();

		// Bind the template and content_type models
		$this->Content->bindModel(array('belongsTo' => array('Template' => array('className' => 'Template'))));

		$this->Content->bindModel(array('belongsTo' => array('ContentType' => array('className' => 'ContentType'))));

		$content_conditions = "Content.id = '" . $content_alias . "' OR BINARY Content.alias = '" . $content_alias . "' AND Content.active ='1'";
		$content = $this->Content->find('first', array('recursive' => 2, 'conditions' => $content_conditions));

		if ($content === false) {
			$this->cakeError('error404');
		}

		return $content;
	}


	/**
	* Returns a list of all content in $key => $value format
	*
	* @param array $conditions array or string of conditions for findAll
	* @return  array  List of all available content.
	*/
	public function generate_content_list ($conditions = null)
	{
		$this->Content->unbindModel(array('hasMany' => array('ContentDescription')));
		$this->Content->bindModel(
			array('hasOne' => array(
					'ContentDescription' => array(
						'className'	=> 'ContentDescription',
						'conditions'	=> 'language_id = ' . $this->Session->read('Customer.language_id')
					)
				)
			)
		);

		$options = array();

		$temp_content = $this->Content->find('all', array('conditions' => $conditions));

		foreach($temp_content AS $loop_content)
		{
			$options_key = $loop_content['Content']['id'];
			$options[$options_key] = $loop_content['ContentDescription']['name'];
			//$options[$options_key] = $loop_content['Content']['id'] . '. ' . $loop_content['ContentDescription']['name'];
		}

		$top_level = array("0" => __('Top Level', true));
		$options = $top_level + $options;
		return $options;
	}
}
?>