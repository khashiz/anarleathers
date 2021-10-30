<?php
/**
 * @package	HikaShop for Joomla!
 * @version	4.4.3
 * @author	hikashop.com
 * @copyright	(C) 2010-2021 HIKARI SOFTWARE. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><?php
$this->fieldsClass->prefix = '';
$displayTitle = false;
ob_start();
foreach ($this->fields as $fieldName => $oneExtraField) {
    if ($oneExtraField->field_namekey == 'constellation') {
        $value = '';
        if(empty($this->element->$fieldName) && !empty($this->element->main->$fieldName))
            $this->element->$fieldName = $this->element->main->$fieldName;
        if(isset($this->element->$fieldName))
            $value = trim($this->element->$fieldName);
        if(!empty($value) || $value === '0' || $oneExtraField->field_type == 'customtext') {
            $displayTitle = true;
            ?>
            <?php echo $this->fieldsClass->show($oneExtraField,$value); ?>
            <?php
        }
    }
}
$specifFields = ob_get_clean();
if($displayTitle){
?>

<div id="hikashop_product_custom_info_main" class="hikashop_product_custom_info_main">
    <?php echo $specifFields; ?>
</div>
<?php } ?>