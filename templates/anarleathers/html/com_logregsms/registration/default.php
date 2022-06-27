<?php
/**
 * @package    logregsms
 * @subpackage C:
 * @author     Mohammad Hosein Mir {@link https://joomina.ir}
 * @author     Created on 22-Feb-2019
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');

$email_required = $this->params->get('is_email_required', "1");
$session = JFactory::getSession();
$referer = $session->get('smsregReferer', '');
?>
<div class="uk-card uk-card-default uk-border-rounded uk-border-rounded-large uk-card-bordered uk-box-shadow-medium uk-position-relative uk-text-zero uk-width-1-1 uk-width-3-4@s uk-margin-auto">
    <div class="uk-position-absolute uk-position-top-left cardFloatingLogo">
        <div class="uk-grid-small uk-flex-left" data-uk-grid>
            <div class="uk-width-expand uk-flex uk-flex-left uk-flex-bottom"><img src="<?php echo JUri::base().'images/sprite.svg#loginText'; ?>" class="uk-preserve-width text" data-uk-svg></div>
            <div class="uk-width-auto uk-text-gold"><img src="<?php echo JUri::base().'images/sprite.svg#anar'; ?>" class="uk-preserve-width" data-uk-svg></div>
        </div>
    </div>
    <div class="uk-card-body uk-padding floatingLogo">
        <div id="logregsms" class="registration-form col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form action="<?php echo JRoute::_('index.php?option=com_logregsms&task=registration.step3'); ?>" method="post" name="step2form" id="step2form" onSubmit="return ValidationRegistrationForm()">
                <div class="uk-child-width-1-1 uk-grid-medium" data-uk-grid>
                    <div class="form-group">
                        <label for="username" class="uk-display-block uk-margin-small-bottom uk-form-label uk-text-tiny font">نام کاربری * </label>
                        <div>
                            <input type="text" name="username" required class="uk-input uk-border-pill uk-text-center uk-form-large font form-control" id="username" value="<?php echo $this->mobile;?>" readonly disabled />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="uk-display-block uk-margin-small-bottom uk-form-label uk-text-tiny font">نام * </label>
                        <div>
                            <input type="text" name="name" required class="uk-input uk-border-pill uk-form-large font form-control" id="name" placeholder="به فارسی وارد کنید"/>
                        </div>
                    </div>
                    <?php if($email_required == "1" || $email_required == "2") : ?>
                        <div class="form-group">
                            <label for="email" class="uk-display-block uk-margin-small-bottom uk-form-label uk-text-tiny font"> نشانی ایمیل <?php echo $email_required == "1" ? "*" : ""; ?> </label>
                            <div>
                                <input type="email" id="email" name="email" <?php echo $email_required == "1" ? 'required="required"' : ""; ?> class="uk-input uk-border-pill uk-text-left uk-form-large font ltr form-control" value="<?php echo $email;?>" />
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if(!empty($this->fields)) { ?>
                        <?php $js = ""; ?>
                        <?php foreach ($this->fields as $key => $value) { ?>
                            <?php if($value->fieldname == "mobile" || $value->fieldname == "cellphone") { ?>
                                <?php $value->setValue($this->mobile); ?>
                                <?php $value->readonly = true; ?>
                                <?php $value->hidden = true; ?>
                            <?php } ?>
                            <?php if ($value->hidden) { ?>
                                <div class="form-group" style="display: none;">
                                    <?php echo $value->input; ?>
                                </div>
                            <?php } else { ?>
                                <div class="form-group">
                                    <?php echo $value->label; ?>
                                    <?php echo $value->input; ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                    <div class="form-group">
                        <button type="submit" name="submform" id="subform" class="uk-button uk-button-gold uk-button-large uk-box-shadow-small uk-border-pill uk-width-1-1 font">ثبت نام</button>
                    </div>
                    <div class="uk-text-center">
                        <a class="uk-display-inline-block uk-text-small font f500 uk-text-muted" href="<?php echo JRoute::_('index.php?option=com_logregsms&task=registration.clear'); ?>">ورود با شماره موبایل جدید</a>
                    </div>
                </div>
                <input type="hidden" name="referer" value="<?php echo $referer; ?>">
            </form>
        </div>
    </div>
</div>