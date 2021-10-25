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
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('bootstrap.tooltip');


// Load user_profile plugin language
$lang = JFactory::getLanguage();
$lang->load('plg_user_profile', JPATH_ADMINISTRATOR);

?>
<div class="profile-edit<?php echo $this->pageclass_sfx; ?>">
    <?php if ($this->params->get('show_page_heading')) : ?>
        <h1 class="uk-text-primary uk-margin-bottom sectionTitle font"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
    <?php endif; ?>
    <script type="text/javascript">
        Joomla.twoFactorMethodChange = function(e)
        {
            var selectedPane = 'com_users_twofactor_' + jQuery('#jform_twofactor_method').val();

            jQuery.each(jQuery('#com_users_twofactor_forms_container>div'), function(i, el)
            {
                if (el.id != selectedPane)
                {
                    jQuery('#' + el.id).hide(0);
                }
                else
                {
                    jQuery('#' + el.id).show(0);
                }
            });
        }
    </script>
    <form id="member-profile" action="<?php echo JRoute::_('index.php?option=com_users&task=profile.save'); ?>" method="post" class="form-validate form-horizontal well" enctype="multipart/form-data">
        <?php // Iterate through the form fieldsets and display each one. ?>
        <div class="uk-child-width-1-1 uk-grid-medium" data-uk-grid>
            <?php foreach ($this->form->getFieldsets() as $group => $fieldset) : ?>
                <?php $fields = $this->form->getFieldset($group); ?>
                <?php if (count($fields)) : ?>
                    <div>
                        <div class="uk-child-width-1-1 uk-grid-medium" data-uk-grid>
                            <fieldset class="uk-margin-bottom-remove uk-margin-top-remove uk-padding-remove-vertical noBorder">
                                <div class="uk-child-width-1-1 uk-child-width-1-2@m uk-grid-medium" data-uk-grid>
                                    <?php // If the fieldset has a label set, display it as the legend. ?>
                                    <?php if (isset($fieldset->description) && trim($fieldset->description)) : ?>
                                        <p>
                                            <?php echo $this->escape(JText::_($fieldset->description)); ?>
                                        </p>
                                    <?php endif; ?>
                                    <?php // Iterate through the fields in the set and display them. ?>
                                    <?php foreach ($fields as $field) : ?>
                                        <?php // If the field is hidden, just display the input. ?>
                                        <?php if ($field->hidden) : ?>
                                            <?php echo $field->input; ?>
                                        <?php else : ?>
                                            <div class="control-group">
                                                <div class="control-label"><?php echo $field->label; ?></div>
                                                <div class="controls">
                                                    <?php if ($field->fieldname === 'password1') : ?>
                                                        <?php // Disables autocomplete ?>
                                                        <input type="password" style="display:none">
                                                    <?php endif; ?>
                                                    <?php echo $field->input; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php if (count($this->twofactormethods) > 1) : ?>
            <fieldset>
                <div class="control-group">
                    <div class="control-label">
                        <label id="jform_twofactor_method-lbl" for="jform_twofactor_method" class="hasTooltip"
                               title="<?php echo '<strong>' . JText::_('COM_USERS_PROFILE_TWOFACTOR_LABEL') . '</strong><br />' . JText::_('COM_USERS_PROFILE_TWOFACTOR_DESC'); ?>">
                            <?php echo JText::_('COM_USERS_PROFILE_TWOFACTOR_LABEL'); ?>
                        </label>
                    </div>
                    <div class="controls">
                        <?php echo JHtml::_('select.genericlist', $this->twofactormethods, 'jform[twofactor][method]', array('onchange' => 'Joomla.twoFactorMethodChange()'), 'value', 'text', $this->otpConfig->method, 'jform_twofactor_method', false); ?>
                    </div>
                </div>
                <div id="com_users_twofactor_forms_container">
                    <?php foreach ($this->twofactorform as $form) : ?>
                        <?php $style = $form['method'] == $this->otpConfig->method ? 'display: block' : 'display: none'; ?>
                        <div id="com_users_twofactor_<?php echo $form['method']; ?>" style="<?php echo $style; ?>">
                            <?php echo $form['form']; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </fieldset>
            <fieldset>
                <div class="alert alert-info">
                    <?php echo JText::_('COM_USERS_PROFILE_OTEPS_DESC'); ?>
                </div>
                <?php if (empty($this->otpConfig->otep)) : ?>
                    <div class="alert alert-warning">
                        <?php echo JText::_('COM_USERS_PROFILE_OTEPS_WAIT_DESC'); ?>
                    </div>
                <?php else : ?>
b                       <?php foreach ($this->otpConfig->otep as $otep) : ?>
                        <span class="span3">
							<?php echo substr($otep, 0, 4); ?>-<?php echo substr($otep, 4, 4); ?>-<?php echo substr($otep, 8, 4); ?>-<?php echo substr($otep, 12, 4); ?>
						</span>
                    <?php endforeach; ?>
                <?php endif; ?>
            </fieldset>
        <?php endif; ?>
        <div class="control-group uk-margin-medium-top">
            <div class="controls uk-child-width-auto uk-grid-small" data-uk-grid>
                <div>
                    <button type="submit" class="uk-button uk-button-gold uk-box-shadow-small uk-border-pill uk-width-1-1 uk-height-1-1 font validate"><?php echo JText::_('JSUBMIT'); ?></button>
                </div>
                <div>
                    <a class="uk-button uk-button-default uk-box-shadow-small uk-border-pill uk-width-1-1 font validate" href="<?php echo JRoute::_('index.php?Itemid=112'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
                </div>
                <input type="hidden" name="option" value="com_users" />
                <input type="hidden" name="task" value="profile.save" />
            </div>
        </div>
        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>