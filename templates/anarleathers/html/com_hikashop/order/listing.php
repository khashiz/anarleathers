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
<div id="hikashop_order_listing">
<?php echo $this->toolbarHelper->process($this->toolbar, $this->title); ?>
<form action="<?php echo hikashop_completeLink('order'); ?>" method="post" name="adminForm" id="adminForm">

<div class="uk-margin-medium-bottom ordersListTop">
	<div class="uk-grid-small" data-uk-grid>
		<div class="uk-width-auto">
            <div>
                <div class="uk-grid-small" data-uk-grid>
                    <div class="uk-width-auto@m"><input type="text" name="search" id="hikashop_search" value="<?php echo $this->escape($this->pageInfo->search);?>" placeholder="<?php echo JText::_('HIKA_SEARCH_ORDERS'); ?>" class="uk-input uk-width-1-1 uk-border-pill font" onchange="this.form.submit();" /></div>
                    <div class="uk-width-auto@m"><button class="uk-button uk-button-gold uk-border-pill font uk-height-1-1" onclick="this.form.submit();"><?php echo JText::_('HIKA_SEARCH_GO'); ?></button></div>
                </div>
            </div>
            <?php
                foreach($this->leftFilters as $name => $filterObj) {
                    if(is_string($filterObj))
                        echo $filterObj;
                    else
                        echo $filterObj->displayFilter($name, $this->pageInfo->filter);
                }
            ?>
        </div>
		<div class="uk-width-expand">
            <?php
            foreach($this->rightFilters as $name => $filterObj) {
                if ($name === 'order_status') {
                    if(is_string($filterObj))
                        echo $filterObj;
                    else
                        echo $filterObj->displayFilter($name, $this->pageInfo->filter, 'class="uk-width-1-1 uk-width-small@m uk-border-pill font uk-select uk-select"');
                }
            }
            ?>
		</div>
	</div>
</div>

<div>
	<div>
<?php
	$url_itemid = (!empty($this->Itemid) ? '&Itemid=' . $this->Itemid : '');
	$cancel_orders = false;
	$print_invoice = false;
	$cancel_url = '&cancel_url='.base64_encode(hikashop_currentURL());

	$i = 0;
	$k = 0;
	echo '<h3 class="uk-text-primary uk-margin-bottom sectionTitle font">'.JText::sprintf("HIKA_MY_ORDERS").'</h3>';
	if (count($this->rows)) {
	foreach($this->rows as &$row) {
		$order_link = hikashop_completeLink('order&task=show&cid='.$row->order_id.$url_itemid.$cancel_url);
?>
		<div class="uk-card uk-card-default uk-box-shadow-small uk-card-bordered uk-border-rounded-large uk-overflow-hidden" data-order-container="<?php echo (int)$row->order_id; ?>">
			<div class="uk-card-header">
                <a class="uk-text-center uk-child-width-1-4 uk-grid-divider uk-link-reset uk-grid-small" href="<?php echo $order_link; ?>" data-uk-grid>
                    <?php
                    $status = "";
                    switch ($row->order_status) {
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
                    <!-- ORDER STATUS -->
                    <div>
                        <span class="uk-text-small font fnum f600 <?php echo $status; ?>"><?php echo hikashop_orderStatus($row->order_status); ?></span>
                    </div>
                    <!-- EO ORDER STATUS -->

                    <div class="hika_cpanel_date">
                        <!-- ORDER DATE -->
                        <span class="uk-text-small font fnum f600 uk-text-gold"><?php echo hikashop_getDate((int)$row->order_created, 'D ، d M Y'); ?></span>
                        <!-- EO ORDER DATE -->
                    </div>
                    <div class="hika_cpanel_price">
                        <!-- ORDER TOTAL -->
                        <span class="uk-text-small font fnum f600 uk-text-gold"><?php echo $this->currencyClass->format($row->order_full_price, $row->order_currency_id); ?></span>
                        <!-- EO ORDER TOTAL -->
                    </div>
                    <!-- ORDER NUMBER -->
                    <div>
                        <span class="uk-text-small font f600 uk-text-gold"><?php echo  JText::_('ORDER_NUMBER').$row->order_number; ?></span>
                        <?php if(!empty($row->order_invoice_number)) { ?>
                            <span class="hika_invoice_number_title"><?php echo JText::_('INVOICE_NUMBER'); ?> : </span>
                            <span class="hika_invoice_number_value"><?php echo $row->order_invoice_number; ?></span>
                        <?php } ?>
                    </div>
                    <!-- EO ORDER NUMBER -->
                </a>
			</div>
<!-- END GRID -->
			<div class="uk-card-body uk-padding-small">

				<div>
                    <?php
                    if($row->order_id == $this->row->order_id) {
                        $this->setLayout('order_products');
                        echo $this->loadTemplate();
                    }
                    ?>
				</div>
			</div>
<!-- END GRID -->

            <div class="uk-card-footer uk-padding-small uk-background-muted">
                <div class="uk-child-width-1-1 uk-child-width-auto@m uk-grid-small" data-uk-grid>
                    <!-- TOP RIGHT EXTRA DATA -->
                    <?php if(!empty($row->extraData->topRight)) { echo implode("\r\n", $row->extraData->topRight); } ?>
                    <!-- EO TOP RIGHT EXTRA DATA -->
                    <!-- ACTIONS BUTTON -->
                    <?php
                    $dropData = array();
                    $dropData[] = array(
                        'class' => 'uk-button-default uk-background-white',
                        'name' => JText::_('HIKA_ORDER_DETAILS'),
                        'link' => $order_link
                    );

                    if(!empty($row->show_print_button)) {
                        $print_invoice = true;
                        $dropData[] = array(
                            'class' => 'uk-button-default uk-background-white',
                            'name' => JText::_('PRINT_INVOICE'),
                            'link' => '#print_invoice',
                            'click' => 'return window.localPage.printInvoice('.(int)$row->order_id.');',
                        );
                    }
                    if(!empty($row->show_cancel_button)) {
                        $cancel_orders = true;
                        $dropData[] = array(
                            'name' => '<i class="fas fa-ban"></i> '. JText::_('CANCEL_ORDER'),
                            'link' => '#cancel_order',
                            'click' => 'return window.localPage.cancelOrder('.(int)$row->order_id.',\''.$row->order_number.'\');',
                        );
                    }
                    if(!empty($row->show_payment_button) && bccomp($row->order_full_price, 0, 5) > 0) {
                        $url_param = ($this->payment_change) ? '&select_payment=1' : '';
                        $url = hikashop_completeLink('order&task=pay&order_id='.$row->order_id.$url_param.$url_itemid);
                        if($this->config->get('force_ssl',0) && strpos('https://',$url) === false)
                            $url = str_replace('http://','https://', $url);
                        $dropData[] = array(
                            'class' => 'uk-button-gold',
                            'name' => JText::_('PAY_NOW'),
                            'link' => $url
                        );
                    }
                    if($this->config->get('allow_reorder', 0)) {
                        $url = hikashop_completeLink('order&task=reorder&order_id='.$row->order_id.$url_itemid);
                        if($this->config->get('force_ssl',0) && strpos('https://',$url) === false)
                            $url = str_replace('http://','https://', $url);
                        $dropData[] = array(
                            'name' => '<i class="fas fa-redo-alt"></i> '. JText::_('REORDER'),
                            'link' => $url
                        );
                    }
                    if(!empty($row->show_contact_button)) {
                        $url = hikashop_completeLink('order&task=contact&order_id='.$row->order_id.$url_itemid);
                        $dropData[] = array(
                            'class' => 'uk-button-default uk-background-white',
                            'name' => JText::_('CONTACT_US_ABOUT_YOUR_ORDER'),
                            'link' => $url
                        );
                    }

                    if(!empty($row->actions)) {
                        $dropData = array_merge($dropData, $row->actions);
                    }

                    /*
                    if(!empty($dropData)) {
                        echo $this->dropdownHelper->display(
                            JText::_('HIKASHOP_ACTIONS'),
                            $dropData,
                            array('type' => 'btn',  'right' => true, 'up' => false)
                        );
                    }
                    */

                    echo '<div class="uk-child-width-1-1 uk-child-width-auto@m uk-grid-small" data-uk-grid>';
                    for ($k=0;$k<count($dropData);$k++){
                        echo '<div><a href="'.$dropData[$k]['link'].'" onclick="'.$dropData[$k]['click'].'" class="uk-button uk-border-pill uk-width-1-1 uk-box-shadow-small font f600 uk-height-1-1 '.$dropData[$k]['class'].'">'.$dropData[$k]['name'].'</a></div>';
                    }
                    ?>
                    <!-- PRODUCTS LISTING BUTTON -->
                    <div>
                        <?php if($row->order_id == $this->row->order_id) { ?>
                            <a class="uk-button uk-border-pill uk-width-1-1 uk-box-shadow-small font f600 uk-height-1-1 uk-button-default uk-background-white" data-title="<?php echo $this->escape(JText::_('HIDE_PRODUCTS')); ?>" href="#" onclick="return window.localPage.handleDetails(this, <?php echo (int)$row->order_id; ?>);"><i class="fas fa-angle-up"></i></a>
                        <?php } else { ?>
                            <a class="uk-button uk-border-pill uk-width-1-1 uk-box-shadow-small font f600 uk-height-1-1 uk-button-default uk-background-white" data-title="<?php echo $this->escape(JText::_('DISPLAY_PRODUCTS')); ?>" href="#" onclick="return window.localPage.handleDetails(this, <?php echo (int)$row->order_id; ?>);"><i class="fas fa-angle-down"></i></a>
                        <?php } ?>
                    </div>
                    <!-- EO PRODUCTS LISTING BUTTON -->
                    <!-- EO ACTIONS BUTTON -->

                    <?php echo '</div>'; ?>


                </div>
            </div>
		</div>
<?php
		$i++;
		$k = 1 - $k;
	}
	unset($row);
    } else { ?>
        <div class="uk-placeholder uk-placeholder-large uk-border-rounded-large uk-margin-remove">
            <p class="uk-text-center uk-text-muted uk-margin-large-top uk-margin-large-bottom font"><?php echo JText::sprintf('HIKA_CPANEL_NO_ORDERS'); ?></p>
        </div>
        <?php
    }
?>
<!-- PAGINATION -->
		<div class="hikashop_orders_footer">
			<div class="pagination">
				<?php // $this->pagination->form = '_bottom'; echo $this->pagination->getListFooter(); ?>
				<?php echo '<span class="hikashop_results_counter uk-hidden">'.$this->pagination->getResultsCounter().'</span>'; ?>
			</div>
		</div>
<!-- EO PAGINATION -->
	</div>

	<input type="hidden" name="Itemid" value="<?php echo $this->Itemid; ?>"/>
	<input type="hidden" name="option" value="<?php echo HIKASHOP_COMPONENT; ?>" />
	<input type="hidden" name="task" value="listing" />
	<input type="hidden" name="ctrl" value="<?php echo hikaInput::get()->getCmd('ctrl'); ?>" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_('form.token'); ?>
</div>
</form>
<script type="text/javascript">
if(!window.localPage) window.localPage = {};
window.localPage.handleDetails = function(btn, id) {
	var d = document, details = d.getElementById('hika_order_'+id+'_details');

	if(details) {
		details.style.display = (details.style.display == 'none' ? '' : 'none');
		if(details.style.display) {
			btn.innerHTML = '<i class="fas fa-angle-down"></i>';
			btn.setAttribute('data-original-title','<?php echo $this->escape(JText::_('DISPLAY_PRODUCTS')); ?>');
		} else{
			btn.innerHTML = '<i class="fas fa-angle-up"></i>';
			btn.setAttribute('data-original-title','<?php echo $this->escape(JText::_('HIDE_PRODUCTS')); ?>');
		}
		return false;
	}

	return window.localPage.loadOrderDetails(btn, id);
};
window.localPage.loadOrderDetails = function(btn, id) {
	var d = document, o = window.Oby, el = d.querySelector('[data-order-container="'+id+'"]');
	if(!el) return false;
	btn.classList.add('hikadisabled');
	btn.disabled = true;
	btn.blur();
	btn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i>';
	var c = d.createElement('div');
	o.xRequest("<?php echo hikashop_completeLink('order&task=order_products', 'ajax', false, true); ?>", {mode:'POST',data:'cid='+id},function(xhr){
		if(!xhr.responseText || xhr.status != 200) {
			btn.innerHTML = '<i class="fas fa-angle-down"></i>';
			return;
		}
		btn.classList.remove('hikadisabled');
		btn.disabled = false;
		var resp = o.trim(xhr.responseText);
		c.innerHTML = resp;
		el.appendChild(c.querySelector('#hika_order_'+id+'_details'));
		btn.innerHTML = '<i class="fas fa-angle-up"></i>';
		btn.setAttribute('data-original-title','<?php echo $this->escape(JText::_('HIDE_PRODUCTS')); ?>');
	});
	return false;
};
</script>
<?php

if(!empty($this->rows) && ($print_invoice || $cancel_orders)) {
	echo $this->popupHelper->display(
		'',
		'INVOICE',
		hikashop_completeLink('order&task=invoice'.$url_itemid.$url_token,true),
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
		$u = hikashop_completeLink('order&task=invoice'.$url_itemid.$url_token,true);
		echo $u;
		echo (strpos($u, '?') === false) ? '?' : '&';
	?>order_id='+id);
	return false;
};
</script>
<form action="<?php echo hikashop_completeLink('order&task=cancel_order&email=1'); ?>" name="hikashop_cancel_order_form" id="hikashop_cancel_order_form" method="POST">
	<input type="hidden" name="Itemid" value="<?php echo $this->Itemid; ?>"/>
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
?>
</div>
