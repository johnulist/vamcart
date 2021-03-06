<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
?>
<?php
echo $this->Admin->ShowPageHeaderStart($current_crumb, 'install.png');
?>
<p>
<?php echo __('Database successfully imported.') ?>
</p>
<p>
<?php echo $this->Admin->linkButtonCatalog(__('Click here to visit your live store.'),'/','submit.png',array('escape' => false, 'target'=>'_blank', 'class' => 'button')); ?>
</p>
<form method="post" action="http://vamcart.com/modules/evennews/index.php">
<fieldset class="form">
<legend><?php echo __('VamCart Newsletter'); ?></legend>
<div class="input text"><?php echo __('Your Name'); ?>: <input type="text" name="user_nick" /></div>
<div class="input text"><?php echo __('Your Email'); ?>: <input type="text" name="user_mail" /></div>
</fieldset>
<input type='hidden' name='action' value='subscribe_conf'>
<?php echo $this->Admin->formButtonCatalog(__('Subscribe'), 'subscribe.png', array('type' => 'submit', 'name' => 'submitbutton')); ?>
</form>
<p>
<?php echo __('We at VamCart value your privacy, we will never sell or distribute your information. You will only receive information regarding VamCart or its affiliates.'); ?>
</p>
<p>
<?php echo __('At anytime you may remove yourself from the list if you think you joined in error.'); ?>
</p>
<?php
echo $this->Admin->ShowPageHeaderEnd();
?>