<?php
/**
 * @package	HikaShop for Joomla!
 * @version	4.4.3
 * @author	hikashop.com
 * @copyright	(C) 2010-2021 HIKARI SOFTWARE. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><?php if(empty($this->ajax)) { ?>
<div class="uk-width-1-1">
    <hr class="uk-divider-icon uk-margin-remove">
</div>
<div id="hikashop_checkout_coupon_<?php echo $this->step; ?>_<?php echo $this->module_position; ?>" data-checkout-step="<?php echo $this->step; ?>" data-checkout-pos="<?php echo $this->module_position; ?>" class="hikashop_checkout_coupon uk-width-1-1">
<?php } ?>
	<div class="hikashop_checkout_loading_elem"></div>
	<div class="hikashop_checkout_loading_spinner"></div>

<?php
	$cart = $this->checkoutHelper->getCart();
	if(empty($cart->coupon)) {
?>
        <div class="uk-margin-bottom">
            <div data-uk-grid>
                <div class="uk-width-expand"><h3 class="uk-margin-remove uk-text-secondary uk-text-primary sectionTitle font"><?php echo JText::_('HIKASHOP_HAVE_COUPON'); ?></h3></div>
                <div class="uk-width-auto"><?php $this->checkoutHelper->displayMessages('coupon'); ?></div>
            </div>
        </div>
	<div>
        <div class="uk-grid-small" data-uk-grid>
            <div class="uk-width-expand">
                <input class="uk-input uk-border-pill font uk-height-1-1 hikashop_checkout_coupon_field" id="hikashop_checkout_coupon_input_<?php echo $this->step; ?>_<?php echo $this->module_position; ?>" type="text" name="checkout[coupon]" value=""/>
            </div>
            <div class="uk-width-small">
                <button type="submit" onclick="return window.checkout.submitCoupon(<?php echo $this->step.','.$this->module_position; ?>);" class="uk-button uk-button-default uk-text-bold uk-box-shadow-small uk-border-pill font uk-width-1-1 uk-height-1-1"><?php echo JText::_('HIKA_APPLY_COUPON'); ?></button>
            </div>
        </div>
    </div>
<?php
	} else {
	    echo '<div class="uk-child-width-auto uk-grid-small uk-text-zero" data-uk-grid>';
		echo '<div><p class="uk-margin-remove uk-text-small uk-text-secondary font f500">'.JText::sprintf('HIKASHOP_COUPON_LABEL', @$cart->coupon->discount_code).'</p></div>';
		if(empty($cart->cart_params->coupon_autoloaded)) {
			global $Itemid;
			$url_itemid = '';
			if(!empty($Itemid))
				$url_itemid = '&Itemid=' . $Itemid;
?>
	<div><a href="#removeCoupon" class="uk-text-danger uk-text-small font f500" onclick="return window.checkout.removeCoupon(<?php echo $this->step; ?>,<?php echo $this->module_position; ?>);" title="<?php echo JText::_('REMOVE_COUPON'); ?>"><?php echo JText::sprintf('REMOVE_COUPON'); ?></a></div>
<?php
		}
		echo '</div>';
	}

	if(empty($this->ajax)) { ?>
</div>
<script type="text/javascript">
if(!window.checkout) window.checkout = {};
window.Oby.registerAjax(['checkout.coupon.updated','cart.updated'], function(params){
	if(params && (params.cart_empty || (params.resp && params.resp.empty))) return;
	window.checkout.refreshCoupon(<?php echo (int)$this->step; ?>, <?php echo (int)$this->module_position; ?>);
});
window.checkout.refreshCoupon = function(step, id) { return window.checkout.refreshBlock('coupon', step, id); };
window.checkout.submitCoupon = function(step, id) {
	var el = document.getElementById('hikashop_checkout_coupon_input_' + step + '_' + id);
	if(!el)
		return false;
	if(el.value == '') {
		window.Oby.addClass(el, 'hikashop_red_border');
		return false;
	}
	return window.checkout.submitBlock('coupon', step, id);
};
window.checkout.removeCoupon = function(step, id) {
	window.checkout.submitBlock('coupon', step, id, {'checkout[removecoupon]':1});
	return false;
};
</script>
<?php }
