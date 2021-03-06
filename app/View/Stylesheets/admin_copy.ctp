<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

	$this->Html->script(array(
			'focus-first-input.js',
		'modified.js'
	), array('inline' => false));

	echo $this->Admin->ShowPageHeaderStart($current_crumb, 'copy.png');

	echo $this->Form->create('Stylesheet', array('id' => 'contentform', 'action' => '/stylesheets/admin_copy/' . $stylesheet['Stylesheet']['id'], 'url' => '/stylesheets/admin_copy/' . $stylesheet['Stylesheet']['id']));
	echo $this->Form->inputs(array(
					'legend' => null,
					'fieldset' =>  __('Copy Stylesheet'),
					'Stylesheet.name' => array(
						'type' => 'text',
						'label' => __('Name the copy:'),
	               ),								
					'Stylesheet.stylesheet' => array(
						'type' => 'hidden',
						'value' => $stylesheet['Stylesheet']['stylesheet']
	               ),												   																
			));
	echo $this->Admin->formButton(__('Submit'), 'submit.png', array('type' => 'submit', 'name' => 'submit')) . $this->Admin->formButton(__('Cancel'), 'cancel.png', array('type' => 'submit', 'name' => 'cancelbutton'));
	echo '<div class="clear"></div>';
	echo $this->Form->end();
	echo $this->Admin->ShowPageHeaderEnd(); 
?>