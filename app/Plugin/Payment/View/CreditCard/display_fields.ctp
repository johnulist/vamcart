<div class="css_form">
<div id="credit_card_details">
	<div>
		<?php 
		echo $this->Form->inputs(array(
		'legend' => false,
		'fieldset' => false,
		   'CreditCard.cc_number' => array(
   		'label' => '{lang}Credit Card Number{/lang}: ',
			'type' => 'text'
			)
		));
		?>
	</div>
	<div>
		<label>{lang}Credit Card Expiration{/lang}: </label>
		<?php
			echo $this->Form->month('CreditCard.cc_expiration_month', date('m'), array('name' => 'data[CreditCard][cc_expiration_month]'));
			echo '&nbsp;&nbsp;';
			echo $this->Form->year('CreditCard.cc_expiration_year',2005,2050,2005,array('name' => 'data[CreditCard][cc_expiration_year]'),false);	
		?>
	</div>
	<div>
	</div>
</div>
</div>
<span class="button"><button type="submit" value="{lang}Confirm Order{/lang}">{lang}Confirm Order{/lang}</button></span>