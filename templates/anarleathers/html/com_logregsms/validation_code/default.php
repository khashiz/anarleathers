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

date_default_timezone_set('Iran');
$session = JFactory::getSession();
$code_session = $session->get('smsregCode', '');
$mobile = $session->get('smsregMobile', '');
$referer = $session->get('smsregReferer', '');

if(empty($code_session)){
    JError::raiseWarning( 100, 'همه session ها منقضی شده اند' );
    $app->redirect('index.php?option=com_logregsms&view=validation_mobile');
}
$helper = new LRSHelper();
$params = $helper::getParams(); 
$resend = (int)$params->get('resend', ''); 
$resend_second = $resend*60; 

$confirm = LRSHelper::getConfirm('', $code_session, -1); 
$time = $confirm->time;
$current = time();
$resend_time = strtotime($time) + $resend_second;


$holding = $resend_time - $current ;

if($current > $resend_time){
    $can_send_display = 'style="display:block"';
    $holding_display = 'style="display:none"';
}
else{
    $can_send_display = 'style="display:none"';
    $holding_display = 'style="display:block"';	
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
        <div id="logregsms" class="validation-code">
            <div class="inside-wall">
                <form action="<?php echo JRoute::_('index.php?option=com_logregsms&task=validation_code.step2'); ?>" method="post" name="step2form" id="step2form" onSubmit="return ValidationCodeForm()">
                    <h1 class="uk-text-primary uk-margin-bottom sectionTitle font">ورود / ثبت نام</h1>
                    <div class="uk-child-width-1-1 uk-grid-small" data-uk-grid>
                        <div>
                            <label class="uk-display-block uk-margin-small-bottom uk-form-label uk-text-tiny font" for="codenum">کد ارسال شده به شماره موبایل خود را وارد کنید</label>
                            <div>
                                <input type="tel" autocomplete="off" autofocus name="codenum" class="uk-input uk-border-pill uk-text-center uk-form-large font ltr form-control" id="codenum" onKeyPress="numberValidate(event)" maxlength="5">
                            </div>
                        </div>
                        <div class="buttons_row">

                            <button type="submit" class="uk-button uk-button-gold uk-button-large uk-box-shadow-small uk-border-pill uk-width-1-1 font">بررسی کد تاییدیه</button>

                            <div class="uk-text-center" id="can_send" <?php echo $can_send_display?>>
                                <a class="uk-display-inline-block uk-text-small uk-margin-top font f500 uk-text-muted" href="<?php echo JRoute::_('index.php?option=com_logregsms&view=validation_code&task=validation_code.sendCode'); ?>">ارسال مجدد کد</a>
                            </div>

                            <div class="uk-text-small uk-margin-top font f500 uk-text-muted uk-text-center" id="holding" <?php echo $holding_display?> >
                                <div id="timer_div"></div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="referer" value="<?php echo $referer; ?>">
                </form>
            </div>
        </div>
    </div>
</div>








<script>
let timeLeft = <?php echo $holding;?>;
let timerElement = document.getElementById('timer_div');
let timerId = setInterval(countdown, 1000);

function countdown() {
    if (timeLeft == -1) {
        clearTimeout(timerId);
        doSomething();
    } else {
        timerElement.innerHTML = timeLeft + ' ثانیه باقیمانده';
        timeLeft--;
    }
}

function doSomething() {
	document.getElementById('can_send').style.display="block";
	document.getElementById('holding').style.display="none";
}
</script>

<style>
.buttons_row > * {display: inline-block;}
</style>

