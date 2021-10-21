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

<?php $type = $this->type; foreach($this->extraFields[$type] as $fieldName => $oneExtraField) { ?>
    <div class="hikashop_registration_<?php echo $fieldName;?>_line" id="hikashop_<?php echo $type.'_'.$oneExtraField->field_namekey; ?>">
        <?php echo $this->fieldsClass->getFieldName($oneExtraField,true,'uk-display-block uk-margin-small-bottom uk-form-label uk-text-tiny font');?>
        <div>
            <?php
            $onWhat='onchange';
            if($oneExtraField->field_type=='radio') $onWhat='onclick';
            echo $this->fieldsClass->display(
                    $oneExtraField,
                    @$this->$type->$fieldName,
                    'data['.$type.']['.$fieldName.']',
                    false,
                    ' class="uk-input uk-border-pill font uk-text-left ltr hkform-control" '.$onWhat.'="window.hikashop.toggleField(this.value,\''.$fieldName.'\',\''.$type.'\',0);"',
                    false,
                    $this->extraFields[$type],
                    $this->$type,
                    false
            ); ?>
        </div>
    </div>
<?php }	?>