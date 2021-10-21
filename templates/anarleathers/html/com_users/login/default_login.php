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
        <div class="login<?php echo $this->pageclass_sfx; ?>">
            <?php if ($this->params->get('show_page_heading')) : ?>
                <div class="page-header">
                    <h1 class="sectionTitle uk-text-primary uk-margin-bottom font">
                        <?php echo $this->escape($this->params->get('page_heading')); ?>
                    </h1>
                </div>
            <?php endif; ?>
            <?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
            <div class="login-description">
                <?php endif; ?>
                <?php if ($this->params->get('logindescription_show') == 1) : ?>
                    <?php echo $this->params->get('login_description'); ?>
                <?php endif; ?>
                <?php if ($this->params->get('login_image') != '') : ?>
                    <img src="<?php echo $this->escape($this->params->get('login_image')); ?>" class="login-image" alt="<?php echo JText::_('COM_USERS_LOGIN_IMAGE_ALT'); ?>" />
                <?php endif; ?>
                <?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
            </div>
        <?php endif; ?>
            <form action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post" class="form-validate form-horizontal well">
                <fieldset class="uk-padding-remove uk-margin-remove noBorder">
                    <div class="uk-child-width-1-1 uk-child-width-1-2@m uk-grid-medium" data-uk-grid>
                        <?php echo $this->form->renderFieldset('credentials'); ?>
                        <?php if ($this->tfa) : ?>
                            <?php echo $this->form->renderField('secretkey'); ?>
                        <?php endif; ?>
                        <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
                            <div class="control-group uk-hidden">
                                <div class="control-label">
                                    <label for="remember"><?php echo JText::_('COM_USERS_LOGIN_REMEMBER_ME'); ?></label>
                                </div>
                                <div class="controls">
                                    <input id="remember" type="checkbox" name="remember" class="inputbox" value="yes" checked />
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="control-group uk-width-expand">
                            <div class="controls">
                                <button type="submit" class="uk-button uk-button-gold uk-border-pill uk-box-shadow-small font"><?php echo JText::_('JLOGIN'); ?></button>
                            </div>
                        </div>
                        <div class="uk-width-auto uk-flex uk-flex-middle">
                            <div>
                                <div>
                                    <div class="uk-grid-small uk-grid-divider uk-child-width-auto" data-uk-grid>
                                        <div>
                                            <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>" class="uk-text-muted uk-text-tiny hoverGold font"><?php echo JText::_('COM_USERS_LOGIN_RESET'); ?></a>
                                        </div>
                                        <?php $usersConfig = JComponentHelper::getParams('com_users'); ?>
                                        <?php if ($usersConfig->get('allowUserRegistration')) : ?>
                                            <div>
                                                <a href="<?php echo JRoute::_('index.php?Itemid=113'); ?>" class="uk-text-muted uk-text-tiny hoverGold font"><?php echo JText::_('COM_USERS_LOGIN_REGISTER'); ?></a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $return = $this->form->getValue('return', '', $this->params->get('login_redirect_url', $this->params->get('login_redirect_menuitem'))); ?>
                        <input type="hidden" name="return" value="<?php echo base64_encode($return); ?>" />
                        <?php echo JHtml::_('form.token'); ?>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>