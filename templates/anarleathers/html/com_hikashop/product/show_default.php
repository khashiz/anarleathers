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
	$form = ',0';
	if(!$this->config->get('ajax_add_to_cart', 1)) {
		$form = ',\'hikashop_product_form\'';
	}
?>
<div id="hikashop_product_top_part" class="uk-margin-large-bottom">
<!-- TOP BEGIN EXTRA DATA -->
<?php if(!empty($this->element->extraData->topBegin)) { echo implode("\r\n",$this->element->extraData->topBegin); } ?>
<!-- EO TOP BEGIN EXTRA DATA -->
	<h1 class="uk-hidden">
        <!-- NAME -->
		<span id="hikashop_product_name_main" class="hikashop_product_name_main" itemprop="name">
            <?php
            if(hikashop_getCID('product_id') != $this->element->product_id && isset($this->element->main->product_name))
                echo $this->element->main->product_name;
            else
                echo $this->element->product_name;
            ?>
        </span>
        <!-- EO NAME -->
        <!-- CODE -->
        <?php if ($this->config->get('show_code')) { ?>
            <span id="hikashop_product_code_main" class="hikashop_product_code_main">
                <?php echo $this->element->product_code; ?>
            </span>
        <?php } ?>
        <!-- EO CODE -->
        <meta itemprop="sku" content="<?php echo $this->element->product_code; ?>">
        <meta itemprop="productID" content="<?php echo $this->element->product_code; ?>">
    </h1>
<!-- TOP END EXTRA DATA -->
<?php if(!empty($this->element->extraData->topEnd)) { echo implode("\r\n", $this->element->extraData->topEnd); } ?>
<!-- EO TOP END EXTRA DATA -->
<!-- SOCIAL NETWORKS -->
<?php $this->setLayout('show_block_social'); echo $this->loadTemplate(); ?>
<!-- EO SOCIAL NETWORKS -->


<?php
$db = JFactory::getDbo();
$catQuery = $db->getQuery(true);
$catQuery
    ->select($db->quoteName(array('category_id', 'eng_title')))
    ->from($db->quoteName('#__hikashop_category'))
    ->where($db->quoteName('category_id') . ' = ' . $this->element->category_id);
$catInfo = $db->setQuery($catQuery)->loadObject();

$imgQuery = $db->getQuery(true);
$imgQuery
    ->select($db->quoteName(array('file_ref_id', 'file_path', 'file_type')))
    ->from($db->quoteName('#__hikashop_file'))
    ->where($db->quoteName('file_ref_id') . ' = ' . $this->element->category_id);
$imgInfo = $db->setQuery($imgQuery)->loadObject();
?>

    <div class="hikashop_category_description">
        <div class="uk-flex-center uk-grid-column-large uk-grid-row-collapse" data-uk-grid>
            <div class="uk-width-1-1 uk-width-auto uk-text-white">
                <img src="<?php echo JUri::base().'images/com_hikashop/upload/'.$imgInfo->file_path; ?>" class="hikashop_category_image" title="" alt="women-bags" height="150" data-uk-svg>
            </div>
            <div class="uk-width-1-1 uk-width-auto">
                <div>
                    <div class="uk-grid-small uk-flex-center uk-child-width-auto" data-uk-grid>
                        <div>
                            <div class="uk-height-1-1 uk-flex uk-flex-middle">
                                <div class="catEngTitleWrapper">
                                    <div>
                                        <img src="<?php echo JUri::base().'images/sprite.svg#anarText'; ?>" width="200" data-uk-svg>
                                    </div>
                                    <div><span class="uk-display-block uk-text-center uk-text-uppercase uk-text-primary fontEn catEngTitle"><?php echo $catInfo->eng_title; ?></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-visible@m">
                            <img src="<?php echo JUri::base().'images/sprite.svg#anar'; ?>" width="" height="150" alt="" data-uk-svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






</div>

<div class="uk-grid-large" data-uk-grid>
	<div id="hikashop_product_left_part" class="uk-width-1-1 uk-width-expand@m uk-flex-first uk-flex-last@m">
        <!-- LEFT BEGIN EXTRA DATA -->
        <?php if(!empty($this->element->extraData->leftBegin)) { echo implode("\r\n",$this->element->extraData->leftBegin); } ?>
        <!-- EO LEFT BEGIN EXTRA DATA -->
        <!-- IMAGE -->
        <?php
        $this->row =& $this->element;
        $this->setLayout('show_block_product_img');
        echo $this->loadTemplate();
        ?>
        <!-- EO IMAGE -->
        <!-- LEFT END EXTRA DATA -->
        <?php if(!empty($this->element->extraData->leftEnd)) { echo implode("\r\n",$this->element->extraData->leftEnd); } ?>
        <!-- EO LEFT END EXTRA DATA -->
	</div>

	<div id="hikashop_product_right_part" class="uk-width-1-1 uk-width-2-5@m">
        <div data-uk-sticky="offset: 70; bottom: true;">
            <!-- RIGHT BEGIN EXTRA DATA -->
            <?php if(!empty($this->element->extraData->rightBegin)) { echo implode("\r\n",$this->element->extraData->rightBegin); } ?>
            <!-- EO RIGHT BEGIN EXTRA DATA -->
            <div>
                <div class="uk-grid-row-medium uk-grid-column-large" data-uk-grid>
                    <?php if(!empty($this->element->constellation)) { ?>
                        <div class="uk-width-1-1 uk-width-expand@m">
                            <?php $this->setLayout('show_block_constellation'); echo $this->loadTemplate(); ?>
                        </div>
                    <?php } ?>
                    <div class="uk-width-1-1 uk-width-1-2@m">
                        <div class="uk-text-left uk-text-brown uk-margin-small-bottom">
                            <img src="<?php echo JUri::base().'images/svg/titles/'.$languageCode.'-'.$this->element->title_shape.'.svg'; ?>" class="uk-width-medium" height="80" alt="" data-uk-svg>
                        </div>
                        <div class="uk-text-left fontEn uk-text-uppercase uk-text-brown uk-h1 uk-margin-remove"><?php echo $this->element->p_eng_title ?></div>
                        <hr class="productSingleSep uk-margin-small-top uk-margin-small-bottom">
                        <div class="uk-text-left">
                            <p class="uk-display-block uk-margin-remove uk-text-large uk-text-lightBrown font f600"><?php echo $this->element->jens_fa; ?></p>
                            <p class="uk-display-block uk-margin-remove uk-h3 uk-text-brown"><?php echo $this->element->jens_en; ?></p>
                            <!-- DIMENSIONS -->
                            <?php $this->setLayout('show_block_dimensions'); echo $this->loadTemplate(); ?>
                            <!-- EO DIMENSIONS -->
                        </div>
                        <hr class="productSingleSep uk-margin-small-top uk-margin-small-bottom">
                        <!-- PRICE -->
                        <?php
                        $itemprop_offer = '';
                        if (!empty($this->element->prices))
                            $itemprop_offer = 'itemprop="offers" itemscope itemtype="https://schema.org/Offer"';
                        ?>
                        <span id="hikashop_product_price_main" class="hikashop_product_price_main" <?php echo $itemprop_offer; ?>>
                            <?php
                            $main =& $this->element;
                            if(!empty($this->element->main))
                                $main =& $this->element->main;
                            if(!empty($main->product_condition) && !empty($this->element->prices)) {
                                ?>
                                <meta itemprop="itemCondition" itemtype="https://schema.org/OfferItemCondition" content="https://schema.org/<?php echo $main->product_condition; ?>" />
                                <?php
                            }
                            if($this->params->get('show_price') && (empty($this->displayVariants['prices']) || $this->params->get('characteristic_display') != 'list')) {
                                $this->row =& $this->element;
                                $this->setLayout('show_block_price');
                                echo $this->loadTemplate();
                                if (!empty($this->element->prices)) {
                                    ?>
                                    <meta itemprop="price" content="<?php echo $this->itemprop_price; ?>" />
                                    <meta itemprop="availability" content="https://schema.org/<?php echo ($this->row->product_quantity != 0) ? 'InStock' : 'OutOfstock' ;?>" />
                                    <meta itemprop="priceCurrency" content="<?php echo $this->currency->currency_code; ?>" />
                                <?php	}
                            }
                            ?>
                        </span>
                        <!-- EO PRICE -->

                        <!-- CHARACTERISTICS -->
                        <?php if($this->params->get('characteristic_display') != 'list') { $this->setLayout('show_block_characteristic'); echo $this->loadTemplate(); } ?>
                        <!-- EO CHARACTERISTICS -->
                        <!-- CUSTOM ITEM FIELDS -->
                        <?php
                                /*
                        if(!$this->params->get('catalogue') && ($this->config->get('display_add_to_cart_for_free_products') || ($this->config->get('display_add_to_wishlist_for_free_products', 1) && hikashop_level(1) && $this->params->get('add_to_wishlist') && $this->config->get('enable_wishlist', 1)) || !empty($this->element->prices))) {
                            if(!empty($this->itemFields)) {
                                $form = ',\'hikashop_product_form\'';
                                if ($this->config->get('redirect_url_after_add_cart', 'stay_if_cart') == 'ask_user') {
                                    ?>
                                    <input type="hidden" name="popup" value="1"/>
                                    <?php
                                }
                                $this->setLayout('show_block_custom_item');
                                echo $this->loadTemplate();
                            }
                        }
                        */
                        ?>
                        <!-- EO CUSTOM ITEM FIELDS -->
                    </div>
                    <!-- DESCRIPTION -->
                    <?php if (!empty($this->element->product_description)) { ?>
                        <div id="hikashop_product_description_main" class="hikashop_product_description_main uk-width-1-1" itemprop="description">
                            <div>
                                <hr class="productSingleSep uk-margin-remove">
                                <a href="#moreDescription" data-uk-toggle="target: #moreDescription; animation: uk-animation-fade" class="uk-display-block uk-padding-small uk-text-small uk-text-left font f500 productDescToggler"><?php echo JText::sprintf('MORE_DETAILS'); ?><img src="<?php echo JUri::base().'images/sprite.svg#chevron-down'; ?>" width="20" class="uk-margin-small-right" data-uk-svg></a>
                                <hr class="productSingleSep uk-margin-remove">
                            </div>
                            <div class="uk-text-justify font f500 uk-text-secondary" id="moreDescription" hidden>
                                <?php echo JHTML::_('content.prepare',preg_replace('#<hr *id="system-readmore" */>#i','',$this->element->product_description)); ?>
                                <hr class="productSingleSep uk-margin-remove">
                            </div>
                        </div>
                    <?php } ?>
                    <!-- EO DESCRIPTION -->
                    <div class="uk-width-1-1">
                        <div>
                            <div class="uk-flex">
                                <!-- ADD TO CART BUTTON -->
                                <?php if(empty($this->element->characteristics) || $this->params->get('characteristic_display') != 'list') { ?>
                                    <div id="hikashop_product_quantity_main" class="hikashop_product_quantity_main uk-width-expand uk-flex">
                                        <?php
                                        $this->row =& $this->element;
                                        $this->formName = $form;
                                        $this->ajax = 'if(hikashopCheckChangeForm(\'item\',\'hikashop_product_form\')){ return hikashopModifyQuantity(\'' . (int)$this->element->product_id . '\',field,1' . $form . ',\'cart\'); } else { return false; }';
                                        $this->setLayout('quantity');
                                        echo $this->loadTemplate();
                                        ?>
                                    </div>
                                <?php } ?>
                                <!-- EO ADD TO CART BUTTON -->
                                <!-- CONTACT US BUTTON -->
                                <div id="hikashop_product_contact_mai" class="hikashop_product_contact_main uk-width-1-4">
                                    <?php
                                    $contact = (int)$this->config->get('product_contact', 0);
                                    if(hikashop_level(1) && ($contact == 2 || ($contact == 1 && !empty($this->element->product_contact)))) {
                                        $css_button = $this->config->get('css_button', 'uk-button uk-button-gold uk-button-outline uk-height-1-1 uk-box-shadow-small uk-border-pill uk-button-large uk-padding-remove-horizontal uk-width-1-1 font');
                                        ?>
                                        <a rel="noindex, nofollow" href="#askQuestion" data-uk-toggle class="uk-button uk-button-gold uk-button-outline uk-height-1-1 uk-box-shadow-small uk-border-pill uk-button-large uk-padding-remove-horizontal uk-width-1-1 font" data-caption="" data-type="iframe"><?php echo JText::_('CONTACT_US_FOR_INFO'); ?></a>
                                        <div id="askQuestion" data-uk-modal>
                                            <div class="uk-modal-dialog uk-modal-body">
                                                <iframe src="<?php echo hikashop_completeLink('product&task=contact&cid=' . (int)$this->element->product_id . $this->url_itemid).'?tmpl=component'; ?>" class="uk-width-1-1 uk-height-large" frameborder="0"></iframe>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <!-- EO CONTACT US BUTTON -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- VOTE -->
            <div id="hikashop_product_vote_mini" class="hikashop_product_vote_mini">
                <?php if($this->params->get('show_vote_product')) {
                    $js = '';
                    $this->params->set('vote_type', 'product');
                    $this->params->set('vote_ref_id', isset($this->element->main) ? (int)$this->element->main->product_id : (int)$this->element->product_id );
                    echo hikashop_getLayout('vote', 'mini', $this->params, $js);
                }
                ?>
            </div>
            <!-- EO VOTE -->

            <!-- RIGHT MIDDLE EXTRA DATA -->
            <?php if(!empty($this->element->extraData->rightMiddle)) { echo implode("\r\n",$this->element->extraData->rightMiddle); } ?>
            <!-- EO RIGHT MIDDLE EXTRA DATA -->


            <!-- OPTIONS -->
            <?php if(hikashop_level(1) && !empty ($this->element->options)) { ?>
                <div id="hikashop_product_options" class="hikashop_product_options">
                    <?php
                    $this->setLayout('option');
                    echo $this->loadTemplate();
                    ?>
                </div>
                <?php
                $form = ',\'hikashop_product_form\'';
                if($this->config->get('redirect_url_after_add_cart', 'stay_if_cart') == 'ask_user') {
                    ?>
                    <input type="hidden" name="popup" value="1"/>
                    <?php
                }
            }
            ?>
            <!-- EO OPTIONS -->

            <!-- PRICE WITH OPTIONS -->
            <?php if($this->params->get('show_price')) { ?>
                <span id="hikashop_product_price_with_options_main" class="hikashop_product_price_with_options_main"></span>
            <?php } ?>
            <!-- EO PRICE WITH OPTIONS -->


<!-- CUSTOM PRODUCT FIELDS -->
<?php
/*
	if(!empty($this->fields)) {
		$this->setLayout('show_block_custom_main');
		echo $this->loadTemplate();
	}
	*/
?>
<!-- EO CUSTOM PRODUCT FIELDS -->



<!-- TAGS -->
<?php
	if(HIKASHOP_J30) {
		$this->setLayout('show_block_tags');
		echo $this->loadTemplate();
	}
?>
<!-- EO TAGS -->
<!-- RIGHT END EXTRA DATA -->
<?php if(!empty($this->element->extraData->rightEnd)) { echo implode("\r\n",$this->element->extraData->rightEnd); } ?>
<!-- EO RIGHT END EXTRA DATA -->
<span id="hikashop_product_id_main" class="hikashop_product_id_main">
	<input type="hidden" name="product_id" value="<?php echo (int)$this->element->product_id; ?>" />
</span>
    </div>
</div>
</div>
<!-- END GRID -->
<div id="hikashop_product_bottom_part" class="hikashop_product_bottom_part">
<!-- BOTTOM BEGIN EXTRA DATA -->
<?php if(!empty($this->element->extraData->bottomBegin)) { echo implode("\r\n",$this->element->extraData->bottomBegin); } ?>
<!-- EO BOTTOM BEGIN EXTRA DATA -->

<!-- MANUFACTURER URL -->
	<span id="hikashop_product_url_main" class="hikashop_product_url_main"><?php
		if(!empty($this->element->product_url)) {
			echo JText::sprintf('MANUFACTURER_URL', '<a href="' . $this->element->product_url . '" target="_blank">' . $this->element->product_url . '</a>');
		}
	?></span>
<!-- EO MANUFACTURER URL -->
<!-- FILES -->
<?php
	$this->setLayout('show_block_product_files');
	echo $this->loadTemplate();
?>
<!-- EO FILES -->
<!-- BOTTOM MIDDLE EXTRA DATA -->
<?php if(!empty($this->element->extraData->bottomMiddle)) { echo implode("\r\n",$this->element->extraData->bottomMiddle); } ?>
<!-- EO BOTTOM MIDDLE EXTRA DATA -->
<!-- BOTTOM END EXTRA DATA -->
<?php if(!empty($this->element->extraData->bottomEnd)) { echo implode("\r\n",$this->element->extraData->bottomEnd); } ?>
<!-- EO BOTTOM END EXTRA DATA -->
</div>