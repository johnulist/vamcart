<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

echo $this->Admin->ShowPageHeaderStart($current_crumb, 'import.png');

	echo $this->Form->create('ImportExport', array('enctype' => 'multipart/form-data', 'id' => 'contentform', 'action' => '/import_export/import/', 'url' => '/import_export/import/'));

	echo $this->Form->inputs(array(
					'legend' => null,
					'fieldset' => __('YML Import'),
				   'ImportExport.submittedfile' => array(
				   	'type' => 'file',
				   	'label' => __('YML Import'),
						'between'=>'<br />'
	               )
		 ));

	echo $this->Admin->formButton(__('Submit'), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cancel.png', array('type' => 'submit', 'name' => 'cancelbutton'));
	
	echo '<div class="clear"></div>';
	echo $this->Form->end();

echo $this->Admin->ShowPageHeaderEnd();

?>