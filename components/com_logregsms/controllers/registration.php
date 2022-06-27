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
class LogregsmsControllerRegistration extends JControllerForm
{
	/**
	 * Gets the Data.
	 *
	 * @return string The greeting to be displayed to the user
	 */
	public function step3()
	{
		JLoader::register('FieldsHelper', JPATH_ADMINISTRATOR . '/components/com_fields/helpers/fields.php');
		JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_fields/models', 'FieldsModel');
		$fieldModel = JModelLegacy::getInstance('Field', 'FieldsModel', array('ignore_request' => true));
		
		$session = JFactory::getSession();
		$helper = new LRSHelper();
		$params = $helper::getParams();
		$name = $helper::$_app->input->getString('name', '');
		$email = $helper::$_app->input->getString('email', '');
		$referer = $helper::$_app->input->getString('referer', '');
		$password = rand(111111,999999);
		$mobile = $session->get('smsregMobile', '');
		
		$user = $helper::User();
		if($user->guest == false) {
			$helper::$_app->redirect(JRoute::_('index.php?option=com_users&view=profile'), 'شما قبلا به سایت وارد شده اید.');
			exit;
		}
		
		$is_all_fields_filled = true;
		$fields_values = isset($_POST['com_fields']) ? $_POST['com_fields'] : null;
		
		// get all users fields
		$fields_rows = FieldsHelper::getFields('com_users.user');
		foreach ($fields_rows as $k => $field) {
			if(isset($fields_values[$field->name]) && $field->required == "1" && empty($fields_values[$field->name])) {
				if($field->required == "1") {
					$is_all_fields_filled = false;
				}
			}
		}
		
		// check form	
		if(empty($name) || empty($mobile) || !$is_all_fields_filled){
			JError::raiseWarning( 100, 'فیلدها را به صورت کامل تکمیل نمایید.' );		
			$helper::$_app->redirect(JRoute::_('index.php?option=com_logregsms&view=registration'));	
		}
		
		$is_email_required = $params->get('is_email_required', "1");
		if($is_email_required == "1" && empty($email)) {
			JError::raiseWarning( 100, 'لطفا فیلد ایمیل را تکمیل کنید.' );		
			$helper::$_app->redirect(JRoute::_('index.php?option=com_logregsms&view=registration'));
		} else {
			/* $befor_at = $helper::randChar(10);
			$after_at = $helper::randChar(5);
			$after_dot = $helper::randChar(3); */
			$uri = JUri::getInstance(); 
			if(empty($email)) {
				$email = $mobile."@".$uri->getHost();
			}		
		}
        $email = trim($email);
		$emailVal = $helper::Validation($email, 'email');
		if($emailVal['result'] == false) {
			JError::raiseWarning(100, $emailVal['msg']);
			$helper::$_app->redirect(JRoute::_('index.php?option=com_logregsms&view=registration'));
			exit;
		}
		
		$user_name = $helper::getUserInfo($mobile); 
		if(!empty($user_name)){
			JError::raiseWarning( 100, 'نام کاربری تکراری می باشد.' );
			$helper::$_app->redirect(JRoute::_('index.php?option=com_logregsms&view=registration'));
		}
		
		$email_info = $helper::getUserInfo('', $email); 
		if(!empty($email_info)){ 

            JPluginHelper::importPlugin('system');
            $dispatcher = JDispatcher::getInstance();
            $paraams = array();
            $ChangeUsernameLogReg = $dispatcher->trigger('onChangeUsernameLogReg', array($email_info->id , $name, $email_info->username, $email_info->email , $mobile, $referer) ); 
            
			JError::raiseWarning( 100, 'ایمیل تکراری می باشد.' );
			$helper::$_app->redirect(JRoute::_('index.php?option=com_logregsms&view=registration'));	
		}
		
		// insert to users
		$juser = new JUser;
		$data = array();
		$data['name'] = $name;
		$data['email'] = JStringPunycode::emailToPunycode($email);
		$data['password'] = $password;
		$data['username'] = $mobile;
		$data['activation'] = '';
		$data['block'] = 0;
		$data['sendEmail'] = 0;

		if (!$juser->bind($data)) {
			$session->clear('smsregMobile');
			$session->clear('smsregAllowReg');
			$session->clear('smsregReferer');
			JError::raiseWarning( 100, $juser->getError() );
			return null;
		}

		if (!$juser->save()) {
			$session->clear('smsregMobile');
			$session->clear('smsregAllowReg');
			$session->clear('smsregReferer');
			JError::raiseWarning( 100, $juser->getError() );
			return null;
		} 

		// insert custom fields
		$userData = (array) $juser;
		$dispatcher = JEventDispatcher::getInstance();
		$userData['com_fields'] = !empty($_POST['com_fields']) ? $_POST['com_fields'] : null;
		$data = null;
		$dispatcher->trigger('onUserAfterSave', array($userData, true, true, ""));
		
		// insert to map
		$user_map = new stdClass();
		$user_map->user_id = $juser->id;
		$user_map->group_id = 2; 
		$user_map_result = $helper::$_db->insertObject('#__user_usergroup_map', $user_map);
		
		//$menuitem = $params->get('after_login', '');
		
		$helper::$_app->redirect('index.php?option=com_logregsms&task=registration.LoginBySleep&'.$session->getFormToken().'=1&p='.$password);
	}
	
	public function LoginBySleep () {
		// Check Token For Security
		if(!JSession::checkToken('get')) {
			die('Try Again!');
		}
		
		$session = JFactory::getSession();
		$helper = new LRSHelper();
		$params = $helper::getParams();
		$referer = $session->get('smsregReferer', '');
		
		// get mobile
		$mobile = $session->get('smsregMobile', '');
		if(!$mobile) {
			$session->clear('smsregMobile');
			$session->clear('smsregAllowReg');
			
			JError::raiseWarning(100, 'شماره موبایل پیدا نشد!');
			$helper::$_app->redirect(JRoute::_('index.php?option=com_logregsms&view=validation_mobile'));
			exit;
		}
		
		// get pass
		$password = $helper::$_app->input->get->getCMD('p', null);
		if(!$password) {
			$session->clear('smsregMobile');
			$session->clear('smsregAllowReg');
			$session->clear('smsregReferer');
			
			JError::raiseWarning(100, 'کلمه عبور پیدا نشد!');
			$helper::$_app->redirect(JRoute::_('index.php?option=com_logregsms&view=validation_mobile'));
			exit;
		}
		
		$menuitem = $params->get('after_login', '');
		
		// login
		$login = $helper::Login($mobile, $password, true);
		if($login['result'] == true) {
			$session->clear('smsregMobile');
			$session->clear('smsregAllowReg');
			$session->clear('smsregReferer');
		
			$msg = 'ثبت نام شما با موفقیت انجام شد. شما هم اکنون با نام کاربری '.$mobile.' وارد حساب کاربری خود شده اید.';
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
	
	public function clear() { 
		$session = JFactory::getSession();
		$helper = new LRSHelper();
		$params = $helper::getParams();
		$smsregMobile = $session->get('smsregMobile', '');
		$smsregAllowReg = $session->get('smsregAllowReg', '');
        $session->clear('smsregMobile');
        $session->clear('smsregAllowReg'); 
		$helper::$_app->redirect(JRoute::_('index.php?option=com_logregsms&view=validation_mobile'), 'لطفا شماره موبایل جدید را وارد نمایید. ');
        
	}
	
}
