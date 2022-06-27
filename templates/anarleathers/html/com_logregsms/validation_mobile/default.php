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

$session = JFactory::getSession(); 
$referer = $session->get('smsregReferer', ''); //die(var_dump($referer));
if($referer){
    $referer = $referer;
}
else{
   $referer = $_SERVER['HTTP_REFERER'];
}
?>
<div class="uk-card uk-card-default uk-border-rounded uk-border-rounded-large uk-card-bordered uk-box-shadow-medium uk-position-relative uk-text-zero uk-width-1-1 uk-width-3-4@s uk-margin-auto">
    <div class="uk-position-absolute uk-position-top-left cardFloatingLogo">
        <div class="uk-grid-small uk-flex-left" data-uk-grid>
            <div class="uk-width-expand uk-flex uk-flex-left uk-flex-bottom"><img src="<?php echo JUri::base().'images/sprite.svg#loginText'; ?>" class="uk-preserve-width text" data-uk-svg></div>
            <div class="uk-width-auto uk-text-gold"><img src="<?php echo JUri::base().'images/sprite.svg#anar'; ?>" class="uk-preserve-width" data-uk-svg></div>
        </div>
    </div>
    <div class="uk-card-body uk-padding floatingLogo">
        <div id="logregsms" class="validation-mobile">
            <div class="inside-wall">
                <form action="<?php echo JRoute::_('index.php?option=com_logregsms&task=validation_mobile.step1'); ?>" method="post" name="step1form" id="step1form" onSubmit="return ValidationMobileForm()">
                    <h1 class="uk-text-primary uk-margin-bottom sectionTitle font">ورود / ثبت نام</h1>
                    <div class="uk-child-width-1-1 uk-grid-small" data-uk-grid>
                        <div>
                            <label class="uk-display-block uk-margin-small-bottom uk-form-label uk-text-tiny font" for="mobilenum">شماره موبایل خود را وارد کنید</label>
                            <div>
                                <input type="tel" name="mobilenum" autocomplete="off" autofocus class="uk-input uk-border-pill uk-text-center uk-form-large font ltr" id="mobilenum" onKeyPress="numberValidate(event)" maxlength="11">
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="uk-button uk-button-gold uk-button-large uk-box-shadow-small uk-border-pill uk-width-1-1 font">ثبت و بررسی</button>
                        </div>
                    </div>
                    <input type="hidden" name="referer" value="<?php echo $referer; ?>">
                </form>
            </div>
        </div>
    </div>
</div>