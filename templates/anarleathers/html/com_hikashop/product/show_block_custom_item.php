<?php
/**
 * @package	HikaShop for Joomla!
 * @version	4.4.3
 * @author	hikashop.com
 * @copyright	(C) 2010-2021 HIKARI SOFTWARE. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?>
<div id="hikashop_product_custom_item_info" class="hikashop_product_custom_item_info uk-margin-small-top">
	<div class="hikashop_product_custom_item_info_table">
        <?php
        foreach ($this->itemFields as $fieldName => $oneExtraField) {
            if(empty($this->element->$fieldName))
                $this->element->$fieldName = $oneExtraField->field_default;
            $itemData = hikaInput::get()->getString('item_data_' . $fieldName, $this->element->$fieldName);
            ?>
            <div id="hikashop_item_<?php echo $oneExtraField->field_namekey; ?>" class="uk-grid-small uk-flex-left hikashop_item_<?php echo $oneExtraField->field_namekey;?>_line" data-uk-grid>
                <div class="uk-flex-last uk-flex uk-flex-middle uk-flex-left uk-width-auto">
                    <span id="hikashop_product_custom_item_name_<?php echo $oneExtraField->field_id;?>" class="hikashop_product_custom_item_name font f600 uk-text-small uk-text-brown">
                        <?php echo $this->fieldsClass->getFieldName($oneExtraField); ?>
                    </span>
                </div>
                <div class="uk-width-expand uk-flex uk-flex-middle uk-flex-left">
                    <span id="hikashop_product_custom_item_value_<?php echo $oneExtraField->field_id;?>" class="hikashop_product_custom_item_value <?php if ($oneExtraField->field_type=='checkbox') {echo 'switchToggle';} ?>">
                        <?php
                        $onWhat='onchange';
                        if($oneExtraField->field_type=='radio')
                            $onWhat='onclick';
                        $oneExtraField->product_id = $this->element->product_id;
                        echo $this->fieldsClass->display($oneExtraField, $itemData, 'data[item]['.$oneExtraField->field_namekey.']', false, ' '.$onWhat.'="window.hikashop.toggleField(this.value,\''.$fieldName.'\',\'item\',0);"', false, $this->itemFields); ?>
                    </span>
                </div>
            </div>
        <?php } ?>
	</div>
</div>