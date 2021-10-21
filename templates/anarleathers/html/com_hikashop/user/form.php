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
global $Itemid;
$url_itemid='';
if(!empty($Itemid)){
	$url_itemid='&Itemid='.$Itemid;
}
?>
<div class="uk-card uk-card-default uk-border-rounded uk-card-bordered uk-box-shadow-medium">
    <div class="uk-card-body uk-padding floatingLogo">
        <div class="uk-position-absolute uk-position-top-left cardFloatingLogo">
            <div class="uk-grid-small uk-flex-left" data-uk-grid>
                <div class="uk-width-expand uk-flex uk-flex-left uk-flex-bottom"><img src="<?php echo JUri::base().'images/sprite.svg#loginText'; ?>" class="uk-preserve-width text" data-uk-svg></div>
                <div class="uk-width-auto uk-text-gold"><img src="<?php echo JUri::base().'images/sprite.svg#anar'; ?>" class="uk-preserve-width" data-uk-svg></div>
            </div>
        </div>
        <form action="<?php echo hikashop_completeLink('user&task=register'.$url_itemid); ?>" method="post" name="hikashop_registration_form" enctype="multipart/form-data" onsubmit="hikashopSubmitForm('hikashop_registration_form'); return false;">
	<div class="hikashop_user_registration_page">
		<fieldset class="input uk-padding-remove uk-margin-remove noBorder">
			<h2 class="sectionTitle uk-text-primary uk-margin-bottom font"><?php echo $this->title;?></h2>
            <div>
			<?php
			$this->setLayout('registration');
			$this->registration_page=true;
			$this->form_name = 'hikashop_registration_form';
			$usersConfig = JComponentHelper::getParams('com_users');
			$allowRegistration = $usersConfig->get('allowUserRegistration');
			if ($allowRegistration || $this->simplified_registration == 2){
				echo $this->loadTemplate();
			}else{
				echo JText::_('REGISTRATION_NOT_ALLOWED');
			}
			 ?>
            </div>
		</fieldset>
	</div>
</form>
    </div>
</div>