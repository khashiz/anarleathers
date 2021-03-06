<?php
/**
 * @package	HikaShop for Joomla!
 * @version	4.4.3
 * @author	hikashop.com
 * @copyright	(C) 2010-2021 HIKARI SOFTWARE. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
$lang = JFactory::getLanguage();
$languages = JLanguageHelper::getLanguages('lang_code');
$languageCode = $languages[ $lang->getTag() ]->sef;
?><?php
$mainDivName = $this->params->get('main_div_name', '');

$link = hikashop_contentLink('product&task=show&cid=' . (int)$this->row->product_id . '&name=' . $this->row->alias . $this->itemid . $this->category_pathway, $this->row);
$haveLink = (int)$this->params->get('link_to_product_page', 1);

if(!empty($this->row->extraData->top)) { echo implode("\r\n",$this->row->extraData->top); }

?>
<div class="hikashop_listing_img_title" id="div_<?php echo $mainDivName.'_'.$this->row->product_id;  ?>">
    <?php /* ?>
    <div class="uk-margin-top uk-position-top-center listItemTitleSVG">
        <a href="<?php echo $link;?>" class="uk-display-inline-block">
            <img src="<?php echo JUri::base().'images/svg/titles/'.$languageCode.'-'.$this->row->title_shape.'.svg'; ?>" width="" height="80" alt="" data-uk-svg>
        </a>
    </div>
    <?php */ ?>
    <?php if($this->row->thumbvideo) { ?>
        <div>
            <a href="<?php echo $link;?>" class="uk-display-block">
                <div class="uk-cover-container">
                    <canvas width="500" height="500"></canvas>
                    <video src="<?php echo JUri::base().'images/video/video-'.$this->row->product_id.'.mp4'; ?>" autoplay loop muted playsinline data-uk-cover></video>
                </div>
            </a>
        </div>
    <?php } else { ?>
        <!-- IMAGE -->
        <?php if (empty($this->row->fading_images)) { ?>
        <?php if($this->config->get('thumbnail', 1)) { ?>
        <div class="uk-position-relative listItemIMGContainer">
            <div class="uk-position-relative">
                <?php if($haveLink) { ?>
                <a href="<?php echo $link;?>" title="<?php echo $this->escape($this->row->product_name); ?>" class="uk-display-block uk-cover-container productContainer">
                    <?php } ?>
                    <?php
                    $img = $this->image->getThumbnail(
                        @$this->row->file_path,
                        array('width' => $this->image->main_thumbnail_x, 'height' => $this->image->main_thumbnail_y),
                        array('default' => true,'forcesize'=>$this->config->get('image_force_size',true),'scale'=>$this->config->get('image_scale_mode','inside'))
                    );
                    if($img->success) {
                        $html = '<canvas width="800" height="800"></canvas><img data-uk-cover class="hikashop_product_listing_image" title="'.$this->escape(@$this->row->file_description).'" alt="'.$this->escape(@$this->row->file_name).'" src="'.$img->url.'"/>';
                        if($this->config->get('add_webp_images', 1) && function_exists('imagewebp') && !empty($img->webpurl)) {
                            $html = '
                <picture>
                    <source srcset="'.$img->webpurl.'" type="image/webp">
                    <source srcset="'.$img->url.'" type="image/'.$img->ext.'">
                    '.$html.'
                </picture>
                ';
                        }
                        echo $html;
                        ?>		<meta itemprop="image" content="<?php echo $img->url; ?>"/>
                        <?php
                    }
                    if($this->params->get('display_badges', 1)) {
                        $this->classbadge->placeBadges($this->image, $this->row->badges, -10, 0);
                    }
                    ?>
                    <?php if($haveLink) { ?>
                </a>
            <?php } ?>
            </div>
        </div>
        <?php } ?>
        <?php } else { ?>
        <style>
            div.faderWrapper > a > div:nth-child(2){display: none}
        </style>
        <div class="uk-margin-auto faderWrapper productContainer" onmouseover="jQuery('.faderWrapper > a > div:nth-child(1)').fadeOut(0); jQuery('.faderWrapper > a > div:nth-child(2)').fadeIn(0);" onmouseleave="jQuery('.faderWrapper > a > div:nth-child(2)').fadeOut(0); jQuery('.faderWrapper > a > div:nth-child(1)').fadeIn(0);">
            <a href="<?php echo $link;?>" class="uk-display-block">
                <?php
                $fieldClass = hikashop_get('class.field');
                $field = $fieldClass->getField('fading_images', 'product');
                echo $fieldClass->show($field,$this->row->fading_images);
                ?>
            </a>
        </div>
        <?php } ?>
        <!-- EO IMAGE -->
    <?php } ?>

<!-- PRICE -->
<?php
	if($this->params->get('show_price','-1')=='-1'){
		$config =& hikashop_config();
		$this->params->set('show_price',$config->get('show_price'));
	}
	if($this->params->get('show_price')){
		$this->setLayout('listing_price');
		echo $this->loadTemplate();
	}
?>
<!-- EO PRICE -->

<!-- NAME -->
	<span class="hikashop_product_name uk-hidden">
<?php if($haveLink) { ?>
		<a href="<?php echo $link;?>">
<?php } ?>
			<?php echo $this->row->product_name; ?>
<?php if($haveLink) { ?>
		</a>
<?php } ?>
	</span>
	<meta itemprop="name" content="<?php echo $this->escape(strip_tags($this->row->product_name)); ?>">
<!-- EO NAME -->

<!-- CODE -->
		<span class='hikashop_product_code_list'>
<?php if ($this->config->get('show_code')) { ?>
<?php if($haveLink) { ?>
			<a href="<?php echo $link;?>">
<?php } ?>
				<?php echo $this->row->product_code; ?>
<?php if($haveLink) { ?>
			</a>
<?php } ?>
<?php } ?>
		</span>
<!-- EO CODE -->

<!-- CUSTOM PRODUCT FIELDS -->
<?php
if(!empty($this->productFields)) {
	foreach($this->productFields as $fieldName => $oneExtraField) {
		if(empty($this->row->$fieldName) && (!isset($this->row->$fieldName) || $this->row->$fieldName !== '0'))
			continue;

		if(!empty($oneExtraField->field_products)) {
			$field_products = is_string($oneExtraField->field_products) ? explode(',', trim($oneExtraField->field_products, ',')) : $oneExtraField->field_products;
			if(!in_array($this->row->product_id, $field_products))
				continue;
		}
?>

        <?php echo $this->fieldsClass->show($oneExtraField,$this->row->$fieldName); ?>

<?php
	}
}
?>
<!-- EO CUSTOM PRODUCT FIELDS -->

<!-- AFTER PRODUCT NAME AREA -->
<?php if(!empty($this->row->extraData->afterProductName)) { echo implode("\r\n",$this->row->extraData->afterProductName); } ?>
<!-- EO AFTER PRODUCT NAME AREA -->

<!-- VOTE -->
<?php

if($this->params->get('show_vote')) {
	$this->setLayout('listing_vote');
	echo $this->loadTemplate();
}
?>
<!-- EO VOTE -->

<!-- ADD TO CART BUTTON -->
<?php
if($this->params->get('add_to_cart') || $this->params->get('add_to_wishlist')) {
	$this->setLayout('add_to_cart_listing');
	echo $this->loadTemplate();
}
?>
<!-- EO ADD TO CART BUTTON -->

<!-- COMPARISON -->
<?php
if(hikaInput::get()->getVar('hikashop_front_end_main', 0) && hikaInput::get()->getVar('task') == 'listing' && $this->params->get('show_compare')) {
	$css_button = $this->config->get('css_button', 'hikabtn');
	$css_button_compare = $this->config->get('css_button_compare', 'hikabtn-compare');
?>
	<br/>
<?php
	if((int)$this->params->get('show_compare') == 1) {
?>
	<a class="<?php echo $css_button . ' ' . $css_button_compare; ?>" href="<?php echo $link; ?>" onclick="if(window.hikashop.addToCompare) { return window.hikashop.addToCompare(this); }" data-addToCompare="<?php echo $this->row->product_id; ?>" data-product-name="<?php echo $this->escape($this->row->product_name); ?>" data-addTo-class="hika-compare"><span><?php
		echo JText::_('ADD_TO_COMPARE_LIST');
	?></span></a>
<?php
	} else {
?>
	<label><input type="checkbox" class="hikashop_compare_checkbox" onchange="if(window.hikashop.addToCompare) { return window.hikashop.addToCompare(this); }" data-addToCompare="<?php echo $this->row->product_id; ?>" data-product-name="<?php echo $this->escape($this->row->product_name); ?>" data-addTo-class="hika-compare"><?php echo JText::_('ADD_TO_COMPARE_LIST'); ?></label>
<?php
	}
}
?>
<!-- EO COMPARISON -->

<!-- CONTACT US BUTTON -->
<?php
	$contact = (int)$this->config->get('product_contact', 0);
	if(hikashop_level(1) && $this->params->get('product_contact_button', 0) && ($contact == 2 || ($contact == 1 && !empty($this->row->product_contact)))) {
		$css_button = $this->config->get('css_button', 'hikabtn');
?>
	<a href="<?php echo hikashop_completeLink('product&task=contact&cid=' . (int)$this->row->product_id . $this->itemid); ?>" class="uk-button uk-button-gold uk-button-outline uk-height-1-1 uk-box-shadow-small uk-border-pill uk-button-large uk-padding-remove-horizontal uk-width-1-1 font"><?php
		echo JText::_('CONTACT_US_FOR_INFO');
	?></a>
<?php
	}
?>

<!-- EO CONTACT US BUTTON -->

<!-- PRODUCT DETAILS BUTTON -->
<?php
	$details_button = (int)$this->params->get('details_button', 0);
	if($details_button) {
		$css_button = $this->config->get('css_button', 'hikabtn');
?>
	<a href="<?php echo $link; ?>" class="<?php echo $css_button; ?>"><?php
		echo JText::_('PRODUCT_DETAILS');
	?></a>
<?php
	}
?>

<!-- EO PRODUCT DETAILS BUTTON -->

	<meta itemprop="url" content="<?php echo $link; ?>">
</div>
<?php

if(!empty($this->row->extraData->bottom)) { echo implode("\r\n",$this->row->extraData->bottom); }

if(isset($this->rows[0]) && $this->rows[0]->product_id == $this->row->product_id) {
	$css = '';
	if((int)$this->image->main_thumbnail_y>0){
		$css .= '
#'.$mainDivName.' .hikashop_product_image { height:'.(int)$this->image->main_thumbnail_y.'px; }';
	}
	if((int)$this->image->main_thumbnail_x>0){
		$css .= '
#'.$mainDivName.' .hikashop_product_image_subdiv { width:'.(int)$this->image->main_thumbnail_x.'px; }';
	}
	$doc = JFactory::getDocument();
	$doc->addStyleDeclaration($css);
}
