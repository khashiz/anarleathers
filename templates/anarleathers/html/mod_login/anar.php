<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('UsersHelperRoute', JPATH_SITE . '/components/com_users/helpers/route.php');

JHtml::_('behavior.keepalive');
JHtml::_('bootstrap.tooltip');

?>
<div id="loginModal" class="uk-modal-full" data-uk-modal>
    <div class="uk-modal-dialog uk-background-transparent">
        <button class="uk-modal-close-full uk-close-large uk-position-top-right uk-text-white hoverGold uk-background-transparent" type="button" data-uk-close></button>
        <div class="uk-grid-collapse uk-child-width-1-1 uk-child-width-1-2@m" data-uk-grid>
            <div class="loginWrapper">
                <div data-uk-height-viewport class="uk-flex uk-flex-middle">
                    <div class="uk-padding-large uk-flex-1">
                        <div class="uk-margin-auto uk-width-2-3">
                            <div>
                                <div class="uk-flex-center uk-child-width-auto uk-grid-small" data-uk-grid>
                                    <div class="uk-flex uk-flex-bottom">
                                        <div>
                                            <img src="<?php echo JUri::base().'images/sprite.svg#loginText'; ?>" width="" height="" alt="" class="uk-margin-small-bottom" data-uk-svg>
                                        </div>
                                    </div>
                                    <div class="uk-text-gold">
                                        <img src="<?php echo JUri::base().'images/sprite.svg#anar'; ?>" width="" height="" alt="" data-uk-svg>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-margin-medium-top uk-margin-medium-bottom seperator"></div>
                            <div>
                                <form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure', 0)); ?>" method="post" id="login-form" class="form-inline">
                                    <div class="uk-child-width-1-1 uk-grid-small userdata" data-uk-grid>
                                        <div id="form-login-username" class="control-group">
                                            <div class="controls">
                                                <?php if (!$params->get('usetext', 0)) : ?>
                                                    <div class="input-prepend">
                                                        <label for="modlgn-username" class="uk-text-white uk-display-block uk-margin-small-bottom uk-form-label uk-text-tiny font"><?php echo JText::_('MOD_LOGIN_VALUE_USERNAME'); ?></label>
                                                        <input id="modlgn-username" type="text" name="username" class="uk-input uk-width-1-1 uk-border-pill font input-small" tabindex="0" size="18" />
                                                    </div>
                                                <?php else : ?>
                                                    <label class="uk-text-white uk-display-block uk-margin-small-bottom uk-form-label uk-text-tiny font" for="modlgn-username"><?php echo JText::_('MOD_LOGIN_VALUE_USERNAME'); ?></label>
                                                    <input id="modlgn-username" type="text" name="username" class="uk-input uk-width-1-1 uk-border-pill font input-small" tabindex="0" size="18" />
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div id="form-login-password" class="control-group">
                                            <div class="controls">
                                                <?php if (!$params->get('usetext', 0)) : ?>
                                                    <div class="input-prepend">
                                                        <label for="modlgn-passwd" class="uk-text-white uk-display-block uk-margin-small-bottom uk-form-label uk-text-tiny font"><?php echo JText::_('JGLOBAL_PASSWORD'); ?></label>
                                                        <input id="modlgn-passwd" type="password" name="password" class="uk-input uk-width-1-1 uk-border-pill font input-small" tabindex="0" size="18" />
                                                    </div>
                                                <?php else : ?>
                                                    <label class="uk-text-white uk-display-block uk-margin-small-bottom uk-form-label uk-text-tiny font" for="modlgn-passwd"><?php echo JText::_('JGLOBAL_PASSWORD'); ?></label>
                                                    <input id="modlgn-passwd" type="password" name="password" class="uk-input uk-width-1-1 uk-border-pill font input-small" tabindex="0" size="18" />
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php if (count($twofactormethods) > 1) : ?>
                                            <div id="form-login-secretkey" class="control-group">
                                                <div class="controls">
                                                    <?php if (!$params->get('usetext', 0)) : ?>
                                                        <div class="input-prepend input-append">
                                                            <span class="add-on">
                                                                <span class="icon-star hasTooltip" title="<?php echo JText::_('JGLOBAL_SECRETKEY'); ?>">
                                                                </span>
                                                                    <label for="modlgn-secretkey" class="element-invisible"><?php echo JText::_('JGLOBAL_SECRETKEY'); ?>
                                                                </label>
                                                            </span>
                                                            <input id="modlgn-secretkey" autocomplete="one-time-code" type="text" name="secretkey" class="input-small" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_SECRETKEY'); ?>" />
                                                            <span class="btn width-auto hasTooltip" title="<?php echo JText::_('JGLOBAL_SECRETKEY_HELP'); ?>">
                                                                <span class="icon-help"></span>
                                                            </span>
                                                        </div>
                                                    <?php else : ?>
                                                        <label for="modlgn-secretkey"><?php echo JText::_('JGLOBAL_SECRETKEY'); ?></label>
                                                        <input id="modlgn-secretkey" autocomplete="one-time-code" type="text" name="secretkey" class="input-small" tabindex="0" size="18" placeholder="<?php echo JText::_('JGLOBAL_SECRETKEY'); ?>" />
                                                        <span class="btn width-auto hasTooltip" title="<?php echo JText::_('JGLOBAL_SECRETKEY_HELP'); ?>">
                                                            <span class="icon-help"></span>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
                                            <div id="form-login-remember" class="control-group checkbox uk-hidden">
                                                <label for="modlgn-remember" class="control-label"><?php echo JText::_('MOD_LOGIN_REMEMBER_ME'); ?></label> <input id="modlgn-remember" type="checkbox" name="remember" class="inputbox" value="yes" checked/>
                                            </div>
                                        <?php endif; ?>
                                        <div id="form-login-submit" class="control-group">
                                            <div class="uk-grid-medium" data-uk-grid>
                                                <div class="controls uk-width-auto">
                                                    <button type="submit" tabindex="0" name="Submit" class="uk-button uk-button-gold uk-border-pill uk-button-large font login-button"><?php echo JText::_('JLOGIN'); ?></button>
                                                </div>
                                                <div class="uk-width-expand uk-flex uk-flex-left uk-flex-middle">
                                                    <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>" class="uk-text-white hoverGold uk-text-small font"><?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="option" value="com_users" />
                                    <input type="hidden" name="task" value="user2.login" />
                                    <input type="hidden" name="return" value="<?php echo $return; ?>" />
                                    <?php echo JHtml::_('form.token'); ?>
                                </form>
                            </div>
                            <?php $usersConfig = JComponentHelper::getParams('com_users'); ?>
                            <?php if ($usersConfig->get('allowUserRegistration')) : ?>
                                <div class="uk-margin-medium-top uk-margin-medium-bottom seperator"></div>
                                <div class="uk-text-center">
                                    <span class="uk-display-block uk-text-muted uk-margin-small-bottom font"><?php echo JText::sprintf('NO_ACCOUNT_YET'); ?></span>
                                    <a href="<?php echo JRoute::_('index.php?Itemid=113'); ?>" class="uk-button uk-button-gold uk-border-pill uk-button-large font"><?php echo JText::_('MOD_LOGIN_REGISTER'); ?></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>