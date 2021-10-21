<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
?>
<div class="uk-card uk-card-default uk-border-rounded uk-border-rounded-large uk-card-bordered uk-box-shadow-medium uk-position-relative uk-text-zero">
    <div class="uk-position-absolute uk-position-top-left cardFloatingLogo">
        <div class="uk-grid-small uk-flex-left" data-uk-grid>
            <div class="uk-width-expand uk-flex uk-flex-left uk-flex-bottom"><img src="<?php echo JUri::base().'images/sprite.svg#loginText'; ?>" class="uk-preserve-width text" data-uk-svg></div>
            <div class="uk-width-auto uk-text-gold"><img src="<?php echo JUri::base().'images/sprite.svg#anar'; ?>" class="uk-preserve-width" data-uk-svg></div>
        </div>
    </div>
    <div class="uk-card-body uk-padding floatingLogo">
        <div class="reset<?php echo $this->pageclass_sfx; ?>">
            <?php if ($this->params->get('show_page_heading')) : ?>
                <div class="page-header">
                    <h1 class="sectionTitle uk-text-primary uk-margin-bottom font">
                        <?php echo $this->escape($this->params->get('page_heading')); ?>
                    </h1>
                </div>
            <?php endif; ?>
            <form id="user-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=reset.request'); ?>" method="post" class="form-validate form-horizontal well">
                <?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
                    <fieldset class="uk-padding-remove uk-margin-bottom noBorder">
                        <?php if (isset($fieldset->label)) : ?>
                            <p class="uk-text-small font"><?php echo JText::_($fieldset->label); ?></p>
                        <?php endif; ?>
                        <div class="uk-child-width-1-1 uk-grid-medium" data-uk-grid>
                            <?php echo $this->form->renderFieldset($fieldset->name); ?>
                            <div class="controls uk-width-expand">
                                <button type="submit" class="uk-button uk-button-gold uk-border-pill uk-box-shadow-small font validate"><?php echo JText::_('JSUBMIT'); ?></button>
                            </div>
                            <div class="uk-width-auto uk-flex uk-flex-middle">
                                <a href="<?php echo JRoute::_('index.php?Itemid=125'); ?>" class="uk-text-muted uk-text-tiny hoverGold font"><?php echo JText::sprintf('NAV_LOGIN'); ?></a>
                            </div>
                        </div>
                    </fieldset>
                <?php endforeach; ?>
                <?php echo JHtml::_('form.token'); ?>
            </form>
        </div>
    </div>
</div>
