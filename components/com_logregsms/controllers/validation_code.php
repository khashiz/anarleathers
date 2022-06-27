
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


/**
 * logregsms Model.
 *
 * @package    logregsms
 * @subpackage Models
 */
class LogregsmsControllerValidation_Code extends JControllerForm
{
	/**
	 * Gets the Data.
	 *
	 * @return string The greeting to be displayed to the user
	 */
	public function step2()
	{
		$helper = new LRSHelper();
		$params = $helper::getParams();
		$code_input = $helper::$_app->input->get('codenum', '');
		$session = JFactory::getSession();
		$code_session = $session->get('smsregCode', '');
		$mobile = $session->get('smsregMobile', '');
		$referer = $session->get('smsregReferer', '');
		
		$user = $helper::User();
		if($user->guest == false) {
			$helper::$_app->redirect(JRoute::_('index.php?option=com_users&view=profile'), 'شما قبلا به سایت وارد شده اید.');
			exit;
		}
		
		if($code_session !== $code_input) {
			$session->clear('smsregAllowReg');


            JError::raiseWarning(100, 'کد وارد شده اشتباه است، لطفا مجددا با دقت بیشتری وارد کنید');
			$helper::$_app->redirect(JRoute::_('index.php?option=com_logregsms&view=validation_code'));
			exit;
		}
		
		$session->clear('smsregCode');
			
		// check 0
		//$mobile = ltrim($mobile, '0');

		// check if user register before or not
		$check = $helper::FindUserName($mobile); 
		if(!$check) {
			$session->set('smsregAllowReg', '1');
			$helper::$_app->redirect(JRoute::_('index.php?option=com_logregsms&view=registration'), 'لطفا فرم زیر را جهت ثبت نام پر کنید');
			exit;
		} else {
			$session->clear('smsregMobile');
			// login
			$newpass = rand(111111, 999999);
			
			$data = new stdClass();
			$data->username = $mobile;
			$data->password = JUserHelper::hashPassword($newpass);
			$up = $helper::Update($data, '#__users', 'username');
			
			$menuitem = $params->get('after_login', '');
			
			$login = $helper::Login($mobile, $newpass, true);
			if($login['result'] == true) {
				$msg = 'با نام کاربری '.$mobile.' با موفقیت وارد حساب کاربری خود شده اید.';
				if($menuitem == "last" && $referer) {
					$helper::$_app->redirect($referer, $msg);
				}elseif(is_numeric($menuitem)) {
						$helper::$_app->redirect(JRoute::_('index.php?Itemid='.$menuitem), $msg);
				} else {
						$helper::$_app->redirect(JRoute::_('index.php?option=com_users&view=profile'), $msg);
				}
				exit;
			}

			JError::raiseWarning( 100, $login['msg'] );
			$helper::$_app->redirect('index.php');
			
		}
	}
	public function sendCode(){ 

        date_default_timezone_set('Iran');
		$helper = new LRSHelper();
		$params = $helper::getParams();
		$app = JFactory::getApplication();
		
		$session = JFactory::getSession();
		$sms_code =  $session->get('smsregCode');
		$mobile =  $session->get('smsregMobile');
        
		$username = $params->get('username', '');
		$text = $params->get('smstext', 'کد تاییدیه شما: {code}');
		$password = $params->get('password', '');
		$line = $params->get('line', '');
		$reseller = $params->get('reseller', '');
		
		if(empty($sms_code)){
			JError::raiseWarning( 100, 'همه session ها منقضی شده اند' );
            $app->redirect('index.php?option=com_logregsms&view=validation_mobile'); 
		}
		
		$confirm = LRSHelper::getConfirm('', $sms_code, -1);
 
        $resend = (int)$params->get('resend', ''); 
        $resend_second = $resend*60; 
        

		$time = $confirm->time;
		$current = time();
		$resend_time = strtotime($time) + $resend_second;

		if($current > $resend_time){
			
			// make code and send message
		    $code = LRSHelper::rndNums(5); 
            // prepare text
            $data = array('code' => $code);
            $data = LRSHelper::Prepare($text, $data);

            // send sms
            $result = LRSSendSms::SendSms ($username, $password, $line, $reseller, $data, $mobile, $code); 
            $sms_result = isset($result['SendSimpleSMS2Result']) ? $result['SendSimpleSMS2Result'] : -1;

            $session = JFactory::getSession();
            $session->set('smsregCode', $code);
            $session->set('smsregMobile', $mobile);


            LRSHelper::Insert(
                array(
                    'created_on' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                    'to' => $mobile,
                    'from' => $line,
                    'message' => $data,
                    'result' => $sms_result
                ),
                '#__logregsms_smsarchives'
            );
			
			// update confirm
			$confirm_table = new stdClass();
			$confirm_table->id = $confirm->id;
			$confirm_table->code = $code;
			$confirm_table->time = date("Y-m-d H:i:s");
			$confirm_table->is_confirmed = -1; 
			$result_confirm = JFactory::getDbo()->updateObject('#__logregsms_confirm', $confirm_table, 'id');

			if(!$result || !$result_confirm){
				JError::raiseWarning( 100, 'ثبت و ارسال کد با خطا مواجه گردید' );
				$app->redirect('index.php?option=com_logregsms&view=validation_mobile');
			}
			else{
				/* JError::raiseNotice( 100, 'کد جدیدی برای شما ارسال گردید.' ); */
				$app->redirect('index.php?option=com_logregsms&view=validation_code');
			}
		}
		else{
			JError::raiseWarning( 100, 'صبر کن !' );
            $app->redirect('index.php?option=com_logregsms&view=validation_code');  
		}
		
	}
}
