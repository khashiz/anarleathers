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
if(empty($this->row) || empty($this->row->products))
	return;

$url_itemid = (!empty($this->Itemid) ? '&Itemid=' . $this->Itemid : '');
$order_link = hikashop_completeLink('order&task=show&cid='.$this->row->order_id.$url_itemid);

$show_more = false;
$max_products = (int)$this->config->get('max_products_cpanel', 4);
if($max_products <= 0) $max_products = 4;
if(count($this->row->products) > $max_products) {
	$this->row->products = array_slice($this->row->products, 0, $max_products);
	$show_more = true;
}

?>
<div id="hika_order_<?php echo $this->row->order_id; ?>_details" class="uk-child-width-1-2 uk-child-width-auto@m uk-grid-small" data-uk-grid>
	<?php if(!empty($this->row->extraData->beforeProductsListing)) { echo implode("\r\n", $this->row->extraData->beforeProductsListing); } ?>
<?php
$group = $this->config->get('group_options',0);
foreach($this->row->products as $product) {
	if($group && $product->order_product_option_parent_id)
		continue;
	$link = '#';
	if(!empty($product->product_id) && !empty($this->products[$product->product_id]) && !empty($this->products[$product->product_id]->product_published))
		$link = hikashop_contentLink('product&task=show&cid='.$product->product_id.'&name='.@$this->products[$product->product_id]->alias . $url_itemid, $this->products[$product->product_id]);
?>
	<div class="">
<!-- PRODUCT IMAGE -->
<?php
	$img = $this->imageHelper->getThumbnail(@$product->images[0]->file_path, array(50, 50), array('default' => true, 'forcesize' => true,  'scale' => 'outside'));
	if(!empty($img) && $img->success) {
?>
		<a class="uk-card uk-card-default uk-border-rounded uk-box-shadow-small uk-display-inline-block uk-padding-small uk-position-relative" href="<?php echo $link; ?>">
            <span class="orderQuantityCount uk-flex uk-flex-center uk-flex-middle fnum uk-background-primary uk-text-white font f600 uk-position-top-left"><?php echo $product->order_product_quantity; ?></span>
            <img class="hika_order_product_image" src="<?php echo $img->url; ?>" alt="" /></a>
<?php
	}
?>
<!-- EO PRODUCT IMAGE -->
		<a href="<?php echo $link; ?>">
<!-- PRODUCT NAME -->
			<span class="uk-hidden"><?php echo $product->order_product_name; ?></span>
<!-- EO PRODUCT NAME -->
<!-- PRODUCT CODE -->
<?php
	if($this->config->get('show_code')) {
?>
			<span class="hikashop_order_product_code"><?php echo $product->order_product_code; ?></span>
<?php
	}
?>
<!-- EO PRODUCT CODE -->
<?php
	if($group) {
		foreach($this->row->products as $j => $optionElement) {
			if($optionElement->order_product_option_parent_id != $product->order_product_id)
				continue;
			$product->order_product_price += $optionElement->order_product_price;
			$product->order_product_tax += $optionElement->order_product_tax;
			$product->order_product_total_price += $optionElement->order_product_total_price;
			$product->order_product_total_price_no_vat += $optionElement->order_product_total_price_no_vat;
		}
	}
?>
		</a>
<!-- PRODUCT PRICE -->
		<p class="uk-hidden">
			<span class="hika_cpanel_product_price_times"> x
			</span>
			<span class="hika_cpanel_product_price_amount">
				<?php echo $this->currencyClass->format( $product->order_product_price + $product->order_product_tax, $this->row->order_currency_id ); ?>
			</span>
		</p>
<!-- EO PRODUCT PRICE -->
<!-- PRODUCT EXTRA DATA -->
<?php
	if(!empty($product->extraData))
		echo '<p class="hikashop_order_product_extra">' . (is_string($product->extraData) ? $product->extraData : implode('<br/>', $product->extraData)) . '</p>';
?>
<!-- EO PRODUCT EXTRA DATA -->
	</div>
<?php
}
if($show_more) {
?>
	<a href="<?php echo $order_link; ?>" class=""><?php echo JText::_('SHOW_MORE_PRODUCTS'); ?></a>
<?php
}
?>
<?php if(!empty($this->row->extraData->afterProductsListing)) { echo implode("\r\n", $this->row->extraData->afterProductsListing); } ?>
</div>
