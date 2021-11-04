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
<?php
$url_itemid = (isset($this->url_itemid)) ? $this->url_itemid : '';
$cancel_orders = false;
$print_invoice = false;
?>
    <h3 class="uk-text-primary uk-margin-bottom sectionTitle font"><?php echo $this->cpanel_data->cpanel_title; ?></h3>
<?php

if(empty($this->cpanel_data->cpanel_orders)) {
?>
	<div class="uk-placeholder uk-placeholder-large uk-border-rounded-large uk-margin-remove">
		<p class="uk-text-center uk-text-muted uk-margin-large-top uk-margin-large-bottom font"><?php echo JText::_('HIKA_CPANEL_NO_ORDERS'); ?></p>
	</div>
<?php
}
$cancel_url = '&cancel_url='.base64_encode(hikashop_currentURL());
$count = 0;
foreach($this->cpanel_data->cpanel_orders as $order_id => $order) {
	$order_link = hikashop_completeLink('order&task=show&cid='.$order_id.$url_itemid.$cancel_url);
?>
<div class="uk-card uk-card-default uk-box-shadow-small uk-card-bordered uk-border-rounded-large uk-overflow-hidden <?php if ($count != count($this->cpanel_data->cpanel_orders)-1) {echo 'uk-margin-bottom';} ?>">
	<div class="uk-card-header">
		<a class="uk-text-center uk-child-width-1-4 uk-grid-divider uk-link-reset uk-grid-small" href="<?php echo $order_link; ?>" data-uk-grid>
            <div>
                <?php
                $status = "";
                switch ($order->order_status) {
                    case "confirmed":
                    case "delivered":
                    case "shipped":
                        $status = "uk-text-success";
                        break;
                    case "cancelled":
                    case "refunded":
                        $status = "uk-text-danger";
                        break;
                    default:
                        $status = "";
                }
                ?>
                <?php if(!empty($order->extraData->topMiddle)) { echo implode("\r\n", $order->extraData->topMiddle); } ?>
                <span class="uk-text-small font fnum f600 <?php echo $status; ?>"><?php echo hikashop_orderStatus($order->order_status); ?></span>
                <?php if(!empty($order->extraData->bottomMiddle)) { echo implode("\r\n", $order->extraData->bottomMiddle); } ?>
            </div>
			<div>
                <span class="uk-text-small font fnum f600 uk-text-gold"><?php echo JHtml::date($order->order_created, 'D ، d M Y'); ?></span>
			</div>
			<div>
                <span class="uk-text-small font fnum f600 uk-text-gold"><?php echo $this->currencyClass->format($order->order_full_price, $order->order_currency_id); ?></span>
			</div>
            <div>
                <?php if(!empty($order->extraData->topLeft)) { echo implode("\r\n", $order->extraData->topLeft); } ?>
                <span class="uk-text-small font f600 uk-text-gold"><?php echo  JText::_('ORDER_NUMBER').$order->order_number; ?></span>
                <?php /* if(!empty($order->order_invoice_number)) { ?>
                    <span class="hika_cpanel_title"><?php echo JText::_('INVOICE_NUMBER'); ?> : </span>
                    <span class="hika_cpanel_value"><?php echo $order->order_invoice_number; ?></span>
                <?php } */ ?>
                <?php if(!empty($order->extraData->bottomLeft)) { echo implode("\r\n", $order->extraData->bottomLeft); } ?>
            </div>
		</a>
	</div>
	<div class="uk-card-body uk-padding-small">
        <div>
            <div class="uk-child-width-1-2 uk-child-width-auto@m uk-grid-small" data-uk-grid>
                <?php if(!empty($order->extraData->beforeProductsListing)) { echo implode("\r\n", $order->extraData->beforeProductsListing); } ?>
                <?php
                $show_more = false;
                $max_products = (int)$this->config->get('max_products_cpanel', 4);
                if($max_products <= 0) $max_products = 4;
                if(count($order->products) > $max_products) {
                    $order->products = array_slice($order->products, 0, $max_products);
                    $show_more = true;
                }
                $group = $this->config->get('group_options',0);
                foreach($order->products as $product) {
                    if($group && $product->order_product_option_parent_id)
                        continue;
                    $link = '#';
                    if(!empty($product->product_id) && !empty($this->products[$product->product_id]) && !empty($this->products[$product->product_id]->product_published))
                        $link = hikashop_contentLink('product&task=show&cid='.$product->product_id.'&name='.@$this->products[$product->product_id]->alias . $url_itemid, $this->products[$product->product_id]);

                    ?>
                    <div>
                        <?php
                        if(!empty($this->cpanel_data->cpanel_order_image)) {
                            $img = $this->imageHelper->getThumbnail(@$product->images[0]->file_path, array(50, 50), array('default' => true, 'forcesize' => true,  'scale' => 'outside'));
                            if(!empty($img) && $img->success) {
                                ?>
                                <a title="<?php echo strip_tags($product->order_product_name); ?>" class="uk-card uk-card-default uk-border-rounded uk-box-shadow-small uk-display-inline-block uk-padding-small uk-position-relative" href="<?php echo $link; ?>">
                                    <span class="orderQuantityCount uk-flex uk-flex-center uk-flex-middle fnum uk-background-primary uk-text-white font f600 uk-position-top-left"><?php echo  $product->order_product_quantity; ?></span>
                                    <img class="hika_cpanel_product_image" src="<?php echo $img->url; ?>" alt="" />
                                </a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                <?php } ?>

            </div>
        </div>
	</div>
    <div class="uk-card-footer uk-padding-small uk-background-muted">
        <div>
            <?php if(!empty($order->extraData->topRight)) { echo implode("\r\n", $order->extraData->topRight); } ?>
            <?php
            $dropData = array(
                array(
                        'class' => 'uk-button-default uk-background-white',
                    'name' => JText::_('HIKA_ORDER_DETAILS'),
                    'link' => $order_link
                )
            );

            if(!empty($order->show_print_button)) {
                $print_invoice = true;
                $dropData[] = array(
                    'class' => 'uk-button-default uk-background-white',
                    'name' => JText::_('PRINT_INVOICE'),
                    'link' => '#print_invoice',
                    'click' => 'return window.localPage.printInvoice('.(int)$order->order_id.');',
                );
            }
            if(!empty($order->show_contact_button)) {
                $url = hikashop_completeLink('order&task=contact&order_id='.$order->order_id.$url_itemid);
                $dropData[] = array(
                    'class' => 'uk-button-default uk-background-white',
                    'name' => JText::_('CONTACT_US_ABOUT_YOUR_ORDER'),
                    'link' => $url
                );
            }
            if(!empty($order->show_cancel_button)) {
                $cancel_orders = true;
                $dropData[] = array(
                    'class' => 'uk-button-danger',
                    'name' => JText::_('CANCEL_ORDER'),
                    'link' => '#cancel_order',
                    'click' => 'return window.localPage.cancelOrder('.(int)$order->order_id.',\''.$order->order_number.'\');',
                );
            }
            if(!empty($order->show_payment_button) && bccomp($order->order_full_price, 0, 5) > 0) {
                $url_param = ($this->payment_change) ? '&select_payment=1' : '';
                $url = hikashop_completeLink('order&task=pay&order_id='.$order->order_id.$url_param.$url_itemid);
                if($this->config->get('force_ssl',0) && strpos('https://',$url) === false)
                    $url = str_replace('http://','https://', $url);
                $dropData[] = array(
                    'class' => 'uk-button-gold',
                    'name' => JText::_('PAY_NOW'),
                    'link' => $url
                );
            }
            if($this->config->get('allow_reorder', 0)) {
                $url = hikashop_completeLink('order&task=reorder&order_id='.$order->order_id.$url_itemid);
                if($this->config->get('force_ssl',0) && strpos('https://',$url) === false)
                    $url = str_replace('http://','https://', $url);
                $dropData[] = array(
                    'class' => 'uk-button-default uk-background-white',
                    'name' => JText::_('REORDER'),
                    'link' => $url
                );
            }

            if(!empty($order->actions)) {
                $dropData = array_merge($dropData, $order->actions);
            }

            echo '<div class="uk-child-width-1-1 uk-child-width-auto@m uk-grid-small" data-uk-grid>';
            for ($k=0;$k<count($dropData);$k++){
                echo '<div><a href="'.$dropData[$k]['link'].'" onclick="'.$dropData[$k]['click'].'" class="uk-button uk-border-pill uk-width-1-1 uk-box-shadow-small font f600 uk-height-1-1 '.$dropData[$k]['class'].'">'.$dropData[$k]['name'].'</a></div>';
            }
            echo '</div>';

            /*
            if(!empty($dropData)) {
                echo $this->dropdownHelper->display(
                    JText::_('HIKASHOP_ACTIONS'),
                    $dropData,
                    array('type' => 'btn', 'right' => true, 'up' => false)
                );
            }
            */

            ?>
            <?php if(!empty($order->extraData->bottomRight)) { echo implode("\r\n", $order->extraData->bottomRight); } ?>
        </div>
    </div>

</div>
    <?php if(!empty($order->extraData->afterProductsListing)) { echo implode("\r\n", $order->extraData->afterProductsListing); } ?>
    <?php if(!empty($order->extraData->beforeInfo)) { echo implode("\r\n", $order->extraData->beforeInfo); } ?>
    <?php if(!empty($order->extraData->afterInfo)) { echo implode("\r\n", $order->extraData->afterInfo); } ?>
<?php
    $count++;
}

if(!empty($this->cpanel_data->cpanel_orders) && ($print_invoice || $cancel_orders)) {
	echo $this->popupHelper->display(
		'',
		'INVOICE',
		hikashop_completeLink('order&task=invoice'.$url_itemid.'',true),
		'hikashop_print_popup',
		760, 480, '', '', 'link'
	);
?>
<script>
if(!window.localPage) window.localPage = {};
window.localPage.cancelOrder = function(id, number) {
	var d = document, form = d.getElementById('hikashop_cancel_order_form');
	if(!form || !form.elements['order_id']) {
		console.log('Error: Form not found, cannot cancel the order');
		return false;
	}
	if(!confirm('<?php echo JText::_('HIKA_CONFIRM_CANCEL_ORDER', true); ?>'.replace(/ORDER_NUMBER/, number)))
		return false;
	form.elements['order_id'].value = id;
	form.submit();
	return false;
};
window.localPage.printInvoice = function(id) {
	hikashop.openBox('hikashop_print_popup','<?php
		$u = hikashop_completeLink('order&task=invoice'.$url_itemid,true);
		echo $u;
		echo (strpos($u, '?') === false) ? '?' : '&';
	?>order_id='+id);
	return false;
};
</script>
<form action="<?php echo hikashop_completeLink('order&task=cancel_order&email=1'); ?>" name="hikashop_cancel_order_form" id="hikashop_cancel_order_form" method="POST">
	<input type="hidden" name="Itemid" value="<?php global $Itemid; echo $Itemid; ?>"/>
	<input type="hidden" name="option" value="<?php echo HIKASHOP_COMPONENT; ?>" />
	<input type="hidden" name="task" value="cancel_order" />
	<input type="hidden" name="email" value="1" />
	<input type="hidden" name="order_id" value="" />
	<input type="hidden" name="ctrl" value="order" />
	<input type="hidden" name="redirect_url" value="<?php echo hikashop_currentURL(); ?>" />
	<?php echo JHTML::_('form.token'); ?>
</form>
<?php
}
