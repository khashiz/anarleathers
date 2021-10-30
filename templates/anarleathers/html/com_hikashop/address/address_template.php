<?php
 defined('_JEXEC') or die('Restricted access');
?>
<div class="uk-text-small uk-text-secondary font"><span class="uk-text-small uk-text-secondary f600 font">{address_title}</span>
{address_state} ، {address_city} ، {address_street}
<span class="uk-text-muted"><?php echo JText::sprintf('POST_CODE'); ?> : </span>{address_post_code}
<span class="uk-text-muted"><?php echo JText::sprintf('TAHVIL_GIRANDE'); ?> : </span>{address_firstname} {address_lastname}
<?php if(!empty($this->address->address_telephone)) { ?>
<span class="uk-text-muted"><?php echo JText::sprintf('TELEPHONE_IN_ADDRESS'); ?> : </span>{address_telephone}
<?php } ?>
</div>