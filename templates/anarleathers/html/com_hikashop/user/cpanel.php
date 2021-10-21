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


<?php if(!empty($this->title)) { ?>
    <h1><?php echo $this->title; ?></h1>
<?php } ?>
<?php $legacy = (int)$this->config->get('cpanel_legacy', false); ?>

<?php if($legacy) { ?>
    <div class="uk-card-body uk-padding floatingLogo" id="hikashopcpanel">
        <div>
            <?php foreach($this->buttons as $name => $btn) { ?>
                <div class="icon-wrapper hikashop_cpanel_<?php echo $name; ?>_div">
                    <div class="icon">
                        <a href="<?php echo hikashop_level($btn['level']) ? $btn['link'] : '#'; ?>">
                            <span class="hkIcon icon-48-<?php echo $btn['image'];?>"></span>
                            <span><?php echo $btn['text'];?></span>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php return; ?>
<?php } ?>
<?php /* if(!empty($this->extraData->topLeft)) { echo implode("\r\n", $this->extraData->topLeft); } ?>
<div class="uk-card uk-card-default uk-card-bordered uk-border-rounded-large">
    <?php $flag = false; ?>
    <div class="uk-card-body uk-padding-small">
        <ul>
            <?php foreach($this->buttons as $name => $btn) { ?>
                <?php $data = isset($btn['counter']) ? $btn['counter'] : false; ?>
                <li>
                    <a class="hika_cpanel_icon hikashop_cpanel_<?php echo $name; ?>_div" href="<?php echo hikashop_level($btn['level']) ? $btn['link'] : '#'; ?>" data-toggle="hk-tooltip" data-title="<?php echo htmlspecialchars('<strong>'.$btn['text'].'</strong><br/>'.$btn['description']); ?>">
                        <span class="hikashop_cpanel_button_text"><?php echo $btn['text'];?></span>
                        <?php if (($data != "") && ($sub_menu == true)) { ?>
                            <span class="hikashop_cpanel_data"><?php echo $data; ?></span>
                        <?php } ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<?php if(!empty($this->extraData->bottomLeft)) { echo implode("\r\n", $this->extraData->bottomLeft); } */ ?>
<div id="hikashop_dashboard">
    <div>
        <div>
            <div>
                <div>
                    <?php
                    if(!empty($this->extraData->topMain)) { echo implode("\r\n", $this->extraData->topMain); }
                    echo $this->loadTemplate('orders');
                    if(!empty($this->extraData->bottomMain)) { echo implode("\r\n", $this->extraData->bottomMain); }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>