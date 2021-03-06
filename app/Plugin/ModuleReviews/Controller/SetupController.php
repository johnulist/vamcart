<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('ModuleReviewsAppController', 'ModuleReviews.Controller');

class SetupController extends ModuleReviewsAppController {
	var $uses = array('Module', 'Content');
	var $components = array('ModuleBase');
	
	function upgrade ()
	{
		$this->ModuleBase->upgrade();
		$this->Session->setFlash(__('Module Upgraded'));
		$this->redirect('/modules/admin/');		
	}
		
	function install()
	{

		$this->loadModels();
		
		// Create the new module record		
		$new_module = array();
		$new_module['Module']['name'] = __('Reviews');
		$new_module['Module']['alias'] = 'reviews';
		$new_module['Module']['version'] = $this->ModuleBase->get_version();
		$new_module['Module']['nav_level'] = '3';				
		$this->Module->save($new_module);
		
		// Create new core pages
		$default_alias = 'read-reviews';
		$default_name = 'Read Reviews';
		$default_description = '{module alias=\'reviews\' action=\'display\'}';
		
		$this->ModuleBase->create_core_page($default_alias,$default_name,$default_description);

		$default_alias = 'create-review';
		$default_name = 'Write Review';
		$default_description = '{module alias=\'reviews\' action=\'create\'}';
		
		$this->ModuleBase->create_core_page($default_alias,$default_name,$default_description);		
		
		// Create the database table
		$install_query = "
		CREATE TABLE `module_reviews` (
		`id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`content_id` INT( 10 ) NOT NULL ,
		`name` VARCHAR( 50 ) NOT NULL ,
		`content` TEXT NOT NULL ,
		`created` DATETIME NOT NULL ,
		`modified` DATETIME NOT NULL
		) ENGINE = innodb;";
		
		$this->Module->query($install_query);
		
		$this->Session->setFlash(__('Module Installed'));
		$this->redirect('/modules/admin/');
	}
	
	
	function uninstall()
	{
		$this->loadModels();
		
		// Delete the module record
		$module = $this->Module->findByAlias('reviews');
		$this->Module->delete($module['Module']['id']);
		
		$core_page = $this->Content->find('first', array('conditions' => array('Content.parent_id' => '-1','alias' => 'read-reviews')));
		$this->Content->delete($core_page['Content']['id'],true);

		$core_page2 = $this->Content->find('first', array('conditions' => array('Content.parent_id' => '-1','alias' => 'create-review')));
		$this->Content->delete($core_page2['Content']['id'],true);		
		
		// Delete the module record
		$uninstall_query = "DROP TABLE `module_reviews`;";
		$this->Module->query($uninstall_query);
		
		$this->Session->setFlash(__('Module Uninstalled')); 
		$this->redirect('/modules/admin/');
	}

}

?>