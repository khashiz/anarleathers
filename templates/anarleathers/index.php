<?php
defined('_JEXEC') or die;
/** @var JDocumentHtml $this */
$app  = JFactory::getApplication();
$user = JFactory::getUser();
// Output as HTML5
$this->setHtml5(true);
// Getting params from template
$params = $app->getTemplate(true)->params;
$menu = $app->getMenu();
$active = $menu->getActive();
$pageparams = $menu->getParams( $active->id );
$pageclass = $pageparams->get( 'pageclass_sfx' );
// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');
$netparsi = JTEXT::_('NETPARSI');

$lang = JFactory::getLanguage();
$languages = JLanguageHelper::getLanguages('lang_code');
$languageCode = $languages[ $lang->getTag() ]->sef;

JHtml::_('jquery.framework');

// Add Stylesheets
JHtml::_('stylesheet', 'uikit-rtl.min.css', array('version' => 'auto', 'relative' => true));
if (strpos($pageclass, 'home')) {
    JHtml::_('stylesheet', 'fullpage.min.css', array('version' => 'auto', 'relative' => true));
}
JHtml::_('stylesheet', 'anar.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'mobileNav.css', array('version' => 'auto', 'relative' => true));

// Add js
JHtml::_('script', 'uikit.min.js', array('version' => 'auto', 'relative' => true));
JHtml::_('script', 'persianumber.min.js', array('version' => 'auto', 'relative' => true));
JHtml::_('script', 'fullpage.min.js', array('version' => 'auto', 'relative' => true));
JHtml::_('script', 'custom.js', array('version' => 'auto', 'relative' => true));

$socialsicons = json_decode( $params->get('socials'),true);
$total = count($socialsicons['icon']);
?>
<!DOCTYPE html>
<html lang="<?php echo JFactory::getLanguage()->getTag(); ?>" dir="<?php echo JFactory::getLanguage()->isRtl() ? 'rtl' : 'ltr'; ?>">
<head>
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=no" />
    <meta name="theme-color" content="<?php echo $params->get('presetcolor'); ?>">
    <jdoc:include type="head" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sen&display=swap" rel="stylesheet">
</head>
<body class="<?php echo $pageclass.' view_'.$view.' layout_'.$layout.' task_'.$task; ?>">
<div class="mobileBar uk-text-center uk-hidden@s uk-width-1-1 uk-position-z-index-2" <?php echo strpos($pageclass, 'home') ? '' : 'data-uk-sticky';  ?>>
    <div class="logo">
        <div class="uk-container">
            <a href="<?php echo JUri::base(); ?>" title="<?php echo $sitename; ?>" class="uk-padding-tiny uk-display-inline-block uk-text-secondary"><img src="<?php echo JUri::base().'images/sprite.svg#anar' ?>" alt="<?php echo $sitename; ?>" width="" height="60" data-uk-svg></a>
        </div>
    </div>
    <div class="icons uk-position-relative">
        <div class="uk-container">
            <div class="uk-padding-tiny uk-padding-remove-horizontal">
                <div class="uk-child-width-expand uk-text-center uk-flex-center uk-grid-collapse iconsWrapper" data-uk-grid>
                    <div class="uk-flex uk-flex-center">
                        <a href="<?php echo JUri::base().'anar'; ?>" class="icon uk-flex uk-flex-middle uk-text-secondary cursorPointer"><img src="<?php echo JUri::base().'images/sprite.svg#eye' ?>" alt="" width="24" height="24" data-uk-svg></a>
                    </div>
                    <div class="uk-flex uk-flex-center">
                        <input type="checkbox" class="uk-hidden hamMenuMobileOpener" id="mainMenuTogglerMobile" />
                        <label for="mainMenuTogglerMobile" class="icon uk-flex uk-flex-middle uk-height-1-1">
                            <div>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </label>
                        <jdoc:include type="modules" name="offcanvas" style="none" />
                    </div>
                    <div class="uk-flex uk-flex-center">
                        <a href="<?php echo JUri::base().'auth'; ?>" class="icon uk-flex uk-flex-middle uk-height-1-1 uk-text-secondary" title="<?php echo JText::sprintf('NAV_LOGIN'); ?>"><img src="<?php echo JUri::base().'images/sprite.svg#user' ?>" alt="" width="24" height="24" class="uk-preserve-width" data-uk-svg></a>
                    </div>
                    <div class="uk-flex uk-flex-center">
                        <a href="<?php echo JRoute::_("index.php?Itemid=132"); ?>" class="icon uk-flex uk-flex-middle uk-height-1-1 uk-text-secondary" title="<?php echo JText::sprintf('NAV_CART') ?>"><img src="<?php echo JUri::base().'images/sprite.svg#cart' ?>" alt="" width="24" height="24" class="uk-preserve-width" data-uk-svg></a>
                    </div>
                    <?php /* ?>
                    <div>
                        <a href="<?php echo JRoute::_("index.php?Itemid=131"); ?>" class="icon uk-flex uk-flex-middle uk-height-1-1 uk-text-secondary" title="<?php echo JText::sprintf('NAV_WISHLIST') ?>"><img src="<?php echo JUri::base().'images/sprite.svg#wishlist' ?>" alt="" width="24" height="24" class="uk-preserve-width" data-uk-svg></a>
                    </div>
                    <?php */ ?>
                    <div class="uk-flex uk-flex-center">
                        <a href="#searchWrapper" data-uk-toggle="animation: uk-animation-fade" class="icon uk-flex uk-flex-middle uk-height-1-1 uk-text-secondary" title="<?php echo JText::sprintf('NAV_SEARCH') ?>"><img src="<?php echo JUri::base().'images/sprite.svg#search' ?>" alt="" width="24" height="24" class="uk-preserve-width" data-uk-svg></a>
                    </div>
                    <div class="uk-flex uk-flex-center">
                        <a href="tel:02100000000" class="icon uk-flex uk-flex-middle uk-height-1-1 uk-text-secondary" title="<?php echo JText::sprintf('CALL') ?>"><img src="<?php echo JUri::base().'images/sprite.svg#phone' ?>" alt="" width="24" height="24" class="uk-preserve-width" data-uk-svg></a>
                    </div>
	                <?php /* ?>
                    <div>
                        <jdoc:include type="modules" name="lang" style="none" />
                    </div>
                    <?php */ ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$mobile_boxes = json_decode( $params->get('mobile_boxes'),true);
$total_boxes = count($mobile_boxes['bg']);
?>
<?php if (strpos($pageclass, 'home')) { ?>
<div class="uk-flex-1 uk-flex uk-flex-column uk-position-relative uk-position-z-index uk-hidden@s">
    <div class="uk-flex-1 uk-flex uk-flex-column mobileHome">
	    <?php for($b=0;$b<$total;$b++) { ?>
		    <?php if ($mobile_boxes['bg'][$b] != '') { ?>
                <a href="<?php echo JRoute::_("index.php?Itemid={$mobile_boxes['link'][$b]}"); ?>" class="uk-display-block uk-position-relative uk-flex-1 homeMobileBox leather uk-text-white" style="background-image: url('<?php echo $mobile_boxes['bg'][$b]; ?>');">
                    <span class="uk-display-inline-block uk-position-<?php echo $mobile_boxes['pos'][$b]; ?>"><img src="<?php echo JUri::base().'images/sprite.svg#mob-'.$mobile_boxes['svg'][$b]; ?>" width="150" data-uk-svg></span>
                </a>
		    <?php } ?>
	    <?php } ?>
    </div>
</div>
<?php } ?>
<jdoc:include type="modules" name="search" style="none" />
<div class="uk-visible@s" ata-uk-scrollspy="target: > *; delay: 200;">
    <!--Fullscreen Icon-->
    <div class="uk-position-fixed uk-animation-slide-left uk-position-top-left uk-text-zero toggleScreen frontZIndex" data-uk-scrollspy-class="uk-animation-slide-left">
        <div class="uk-padding-small screenToggler">
            <a href="<?php echo JUri::base(); ?>" title="<?php echo $sitename; ?>" class="uk-padding-small uk-display-inline-block uk-text-primary uk-border-rounded hoverIcon toggleScreenLink"><img src="<?php echo JUri::base().'images/logo_small.svg' ?>" alt="<?php echo $sitename; ?>" width="78" height="24" data-uk-svg></a>
            <jdoc:include type="modules" name="lang" style="none" />
            <a href="javascript:void(0)" onclick="openFullscreen();"  data-uk-toggle="target: .toggleScreen" class="uk-visible@m uk-padding-small uk-display-inline-block uk-text-primary uk-border-rounded hoverIcon toggleScreenLink"><img src="<?php echo JUri::base().'images/sprite.svg#expand' ?>" alt="" width="24" height="24" data-uk-svg></a>
        </div>
    </div>
    <div class="uk-position-fixed uk-position-top-left uk-text-zero toggleScreen frontZIndex" data-uk-scrollspy-class="uk-animation-slide-left" hidden>
        <div class="uk-padding-small">
            <a href="<?php echo JUri::base(); ?>" title="<?php echo $sitename; ?>" class="uk-padding-small uk-display-inline-block uk-text-primary uk-border-rounded hoverIcon toggleScreenLink"><img src="<?php echo JUri::base().'images/logo_small.svg' ?>" alt="<?php echo $sitename; ?>" width="78" height="24" data-uk-svg></a>
            <jdoc:include type="modules" name="lang" style="none" />
            <a href="javascript:void(0)" onclick="closeFullscreen();"  data-uk-toggle="target: .toggleScreen" class="uk-visible@m uk-padding-small uk-display-inline-block uk-text-primary uk-border-rounded hoverIcon toggleScreenLink"><img src="<?php echo JUri::base().'images/sprite.svg#collapse' ?>" alt="" width="24" height="24" data-uk-svg></a>
        </div>
    </div>
    <!--Utility Icons-->
    <div class="uk-position-fixed uk-animation-slide-right uk-position-top-right uk-text-zero utilityIcons" data-uk-scrollspy-class="uk-animation-slide-right">
        <div class="uk-flex">
            <span class="icon uk-flex uk-flex-middle uk-padding-small uk-text-primary cursorPointer" id="eye" data-status="off" onclick="eyeAction();"><img src="<?php echo JUri::base().'images/sprite.svg#eye' ?>" alt="" width="36" height="36" data-uk-svg></span>
            <div class="uk-flex" id="utilityIconsWrapper">
                <div style="display: none">
                    <a href="#mainMenu" data-uk-toggle id="mainMenuToggler" class="icon uk-flex uk-flex-middle uk-height-1-1 uk-padding-small" title="<?php echo JText::sprintf('NAV_MENU') ?>" data-uk-tooltip="cls: uk-active font; pos: bottom; offset: 15;">
                        <div>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                </div>
                <div style="display: none">
                    <a href="<?php echo JRoute::_("index.php?Itemid=132"); ?>" class="icon uk-flex uk-flex-middle uk-height-1-1 uk-padding-small" title="<?php echo JText::sprintf('NAV_CART') ?>" data-uk-tooltip="cls: uk-active font; pos: bottom; offset: 15;"><img src="<?php echo JUri::base().'images/sprite.svg#cart' ?>" alt="" width="22" height="22" class="uk-preserve-width" data-uk-svg></a>
                </div>
                <div style="display: none">
                    <a href="<?php echo JRoute::_("index.php?Itemid=131"); ?>" class="icon uk-flex uk-flex-middle uk-height-1-1 uk-padding-small" title="<?php echo JText::sprintf('NAV_WISHLIST') ?>" data-uk-tooltip="cls: uk-active font; pos: bottom; offset: 15;"><img src="<?php echo JUri::base().'images/sprite.svg#wishlist' ?>" alt="" width="22" height="22" class="uk-preserve-width" data-uk-svg></a>
                </div>
                <?php if ($user->guest) { ?>
                    <div style="display: none">
                        <?php /* ?>
                        <a href="#loginModal" data-uk-toggle class="icon uk-flex uk-flex-middle uk-height-1-1 uk-padding-small" title="<?php echo JText::sprintf('NAV_LOGIN'); ?>" data-uk-tooltip="cls: uk-active font; pos: bottom; offset: 15;"><img src="<?php echo JUri::base().'images/sprite.svg#user' ?>" alt="" width="22" height="22" class="uk-preserve-width" data-uk-svg></a>
                        <?php */ ?>
                        <a href="<?php echo JUri::base().'auth'; ?>" class="icon uk-flex uk-flex-middle uk-height-1-1 uk-padding-small" title="<?php echo JText::sprintf('NAV_LOGIN'); ?>" data-uk-tooltip="cls: uk-active font; pos: bottom; offset: 15;"><img src="<?php echo JUri::base().'images/sprite.svg#user' ?>" alt="" width="22" height="22" class="uk-preserve-width" data-uk-svg></a>
                    </div>
                <?php } else { ?>
                    <div style="display: none">
                        <div class="icon uk-flex uk-flex-middle uk-height-1-1 uk-padding-small">
                            <a href="#" class="icon uk-flex uk-flex-middle" title="<?php echo JText::sprintf('NAV_USER_ACCOUNT', $user->name); ?>"><img src="<?php echo JUri::base().'images/sprite.svg#user' ?>" alt="" width="22" height="22" class="uk-preserve-width" data-uk-svg></a>
                            <div class="userMenuDrop" data-uk-drop="offset: 20;">
                                <div class="uk-card uk-card-body uk-card-bordered uk-border-rounded-large uk-card-default uk-padding-small"><jdoc:include type="modules" name="usermenu" style="xhtml"/></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div style="display: none">
                    <a href="#searchWrapper" data-uk-toggle="animation: uk-animation-fade" class="icon uk-flex uk-flex-middle uk-height-1-1 uk-padding-small" title="<?php echo JText::sprintf('NAV_SEARCH') ?>" data-uk-tooltip="cls: uk-active font; pos: bottom; offset: 15;"><img src="<?php echo JUri::base().'images/sprite.svg#search' ?>" alt="" width="22" height="22" class="uk-preserve-width" data-uk-svg></a>
                </div>
            </div>
        </div>
    </div>
    <?php if (strpos($pageclass, 'home') || strpos($pageclass, 'home')) { ?>
    <!--Social Icons-->
    <div class="uk-animation-slide-left uk-position-bottom-left uk-text-zero frontZIndex">
        <div class="uk-padding-small">
            <a href="#" class="uk-padding-small uk-display-inline-block uk-text-primary uk-border-rounded hoverIcon"><img src="<?php echo JUri::base().'images/sprite.svg#triangle' ?>" alt="" width="36" height="36" data-uk-svg></a>
            <div data-uk-drop="pos: right-center; offset: 0; mode: click;" id="socialsDrop">
                <div class="uk-padding-small">
                    <div id="socialIcons" class="uk-child-width-auto uk-flex-nowrap uk-flex-row-reverse uk-grid-small" data-uk-grid data-uk-scrollspy="cls: uk-animation-slide-right; target: > div; repeat: true; delay: 100;">
                        <?php for($i=0;$i<$total;$i++) { ?>
                            <?php if ($socialsicons['link'][$i] != '') { ?>
                                <div><a href="<?php echo $socialsicons['link'][$i]; ?>" target="_blank" title="<?php echo $socialsicons['title'][$i]; ?>" data-uk-tooltip="cls: uk-active font;" class="uk-flex uk-flex-center uk-flex-middle uk-text-primary"><img src="<?php echo JURI::base().'images/sprite.svg#'.$socialsicons['icon'][$i] ?>" width="22" height="22" alt="" class="uk-preserve-width" data-uk-svg></a></div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<?php if (strpos($pageclass, 'home')) { ?>
    <div id="anarContainer" class="uk-visible@m">
        <!-- Leather -->
        <div class="section" data-section="leather">
            <div class="uk-height-1-1 uk-position-relative sectionWrapper anchorsWrapper leather">
                <div class="shadow"></div>
                <div class="uk-position-absolute whiteShade"></div>
                <div class="uk-position-absolute uk-position-z-index uk-position-top uk-width-1-1 uk-text-center leather" data-uk-scrollspy-class="uk-animation-slide-top">
                    <a href="#" class="uk-visible@m uk-padding-small uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#leather-top' ?>" data-uk-svg></a>
                    <a href="#" class="uk-hidden">aaaaa</a>
                </div>
                <div class="uk-position-absolute uk-position-z-index uk-position-right uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-right">
                    <a href="<?php echo JUri::base().'leather/gifts'; ?>" class="uk-visible@m uk-padding-small uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#leather-right' ?>" data-uk-svg></a>
                    <a href="<?php echo JUri::base().'leather/gifts'; ?>" class="uk-hidden">aaaaa</a>
                </div>
                <div class="uk-position-absolute uk-position-z-index uk-position-bottom uk-width-1-1 uk-text-center style" data-uk-scrollspy-class="uk-animation-slide-bottom">
                    <a href="<?php echo JUri::base().'#main/intro'; ?>" class="uk-visible@m uk-padding-small uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#leather-bottom' ?>" data-uk-svg></a>
                    <a href="<?php echo JUri::base().'#main/intro'; ?>" class="uk-hidden@m uk-display-inline-block uk-padding-small uk-text-primary"><img src="<?php echo JUri::base().'images/sprite.svg#felesh-bottom'; ?>" width="55" height="26" alt="Felesh Bottom" data-uk-svg></a>
                </div>
                <div class="uk-position-absolute uk-position-z-index uk-position-left uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-left">
                    <a href="<?php echo JUri::base().'leather/sets'; ?>" class="uk-visible@m uk-padding-small uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#leather-left' ?>" data-uk-svg></a>
                    <a href="<?php echo JUri::base().'leather/sets'; ?>" class="uk-hidden">aaaaa</a>
                </div>
                <div class="uk-position-center uk-padding uk-padding-remove-vertical">
                    <div class="triangleWrapper"><img src="<?php echo JUri::base().'images/svg/triangle.svg'; ?>" class="uk-width-1-1 uk-height-1-1" data-uk-svg></div>
                </div>
            </div>
        </div>
        <div class="section active">
            <!-- Jewelry -->
            <div class="slide jewelry" data-anchor="jewelry">
                <div class="uk-height-1-1 uk-position-relative sectionWrapper anchorsWrapper jewelry">
                    <div class="shadow"></div>
                    <div class="uk-position-absolute whiteShade"></div>
                    <?php /* ?>
                    <div class="uk-position-absolute uk-position-top uk-width-1-1 uk-text-center leather" data-uk-scrollspy-class="uk-animation-slide-top">
                        <a href="#" class="uk-padding uk-display-inline-block uk-text-muted fa-flip-vertical"><img src="<?php echo JUri::base().'images/sprite.svg#arrow-curve-h' ?>" data-uk-svg></a>
                    </div>
                    <?php */ ?>
                    <div class="uk-position-absolute uk-position-right uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-right">
                        <a href="<?php echo JUri::base().'#main/intro'; ?>" class="uk-visible@m uk-padding uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#jewelry-right' ?>" height="90" data-uk-svg></a>
                        <a href="<?php echo JUri::base().'#main/intro'; ?>" class="uk-hidden">aaaaa</a>
                    </div>
                    <?php /* ?>
                    <div class="uk-position-absolute uk-position-bottom uk-width-1-1 uk-text-center style" data-uk-scrollspy-class="uk-animation-slide-bottom">
                        <a href="#" class="uk-padding uk-display-inline-block uk-text-muted"><img src="<?php echo JUri::base().'images/sprite.svg#arrow-curve-h' ?>" data-uk-svg></a>
                    </div>
                    <div class="uk-position-absolute uk-position-left uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-left">
                        <a href="#" class="uk-padding uk-display-inline-block uk-text-muted"><img src="<?php echo JUri::base().'images/sprite.svg#jewelry-left' ?>" height="90" data-uk-svg></a>
                    </div>
                    <?php */ ?>
                    <div class="uk-position-center uk-padding uk-padding-remove-vertical">
                        <div class="triangleWrapper"><img src="<?php echo JUri::base().'images/svg/downtriangle.svg'; ?>" class="uk-width-1-1 uk-height-1-1" data-uk-svg></div>
                    </div>
                </div>
            </div>
            <!-- Main Intro -->
            <div class="slide hmWrapper active" data-anchor="intro">
                <span class="line two"></span>
                <span class="line three"></span>
                <div class="uk-height-1-1 uk-position-relative anchorsWrapper uk-position-z-index" data-uk-scrollspy="target: > div; delay: 200;">
                    <div class="uk-position-absolute uk-position-center uk-height-1-1 homeMainWrapper" data-uk-height-viewport data-uk-scrollspy-class="uk-animation-fade">
                        <img src="<?php echo JUri::base().'images/sprite.svg#homeMain'; ?>" class="uk-height-1-1 homeMain logo" data-uk-svg>
                    </div>
                    <div class="uk-position-absolute uk-position-top uk-width-1-1 uk-text-center leather" data-uk-scrollspy-class="uk-animation-slide-top">
                        <a href="<?php echo JUri::base().'#leather'; ?>" class="uk-visible@m uk-padding uk-display-inline-block hoverPrimary" onmouseover="shapeon('leather','top')" onmouseleave="shapeoff('top')"><img src="<?php echo JUri::base().'images/sprite.svg#homeNavLeather' ?>" data-uk-svg></a>
                        <a href="<?php echo JUri::base().'#leather'; ?>" class="uk-hidden@m uk-display-inline-block uk-text-primary" style="padding-top: 140px;"><img src="<?php echo JUri::base().'images/sprite.svg#felesh-up'; ?>" width="55" height="26" alt="Felesh Up" data-uk-svg></a>
                    </div>
                    <div class="uk-position-absolute uk-position-right uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-right">
                        <a href="<?php echo JUri::base().'#main/decor'; ?>" class="uk-visible@m uk-padding uk-display-inline-block hoverPrimary" onmouseover="shapeon('decor','right')" onmouseleave="shapeoff('right')"><img src="<?php echo JUri::base().'images/sprite.svg#homeNavDecor' ?>" data-uk-svg></a>
                        <a href="<?php echo JUri::base().'#main/decor'; ?>" class="uk-padding-small uk-hidden@m uk-text-primary"><img src="<?php echo JUri::base().'images/sprite.svg#felesh-right'; ?>" width="26" height="55" alt="Felesh Right" data-uk-svg></a>
                    </div>
                    <div class="uk-position-absolute uk-position-bottom uk-width-1-1 uk-text-center style" data-uk-scrollspy-class="uk-animation-slide-bottom">
                        <a href="<?php echo JUri::base().'#style'; ?>" class="uk-visible@m uk-padding uk-display-inline-block hoverPrimary" onmouseover="shapeon('jewelry','bottom')" onmouseleave="shapeoff('bottom')"><img src="<?php echo JUri::base().'images/sprite.svg#homeNavStyle' ?>" data-uk-svg></a>
                        <a href="<?php echo JUri::base().'#style'; ?>" class="uk-hidden@m uk-display-inline-block uk-text-primary" style="padding-bottom: 140px;"><img src="<?php echo JUri::base().'images/sprite.svg#felesh-bottom'; ?>" width="55" height="26" alt="Felesh Bottom" data-uk-svg></a>
                    </div>
                    <div class="uk-position-absolute uk-position-left uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-left">
                        <a href="<?php echo JUri::base().'#main/jewelry'; ?>" class="uk-visible@m uk-padding uk-display-inline-block hoverPrimary" onmouseover="shapeon('style','left')" onmouseleave="shapeoff('left')"><img src="<?php echo JUri::base().'images/sprite.svg#homeNavJewelry' ?>" data-uk-svg></a>
                        <a href="<?php echo JUri::base().'#main/jewelry'; ?>" class="uk-padding-small uk-hidden@m uk-text-primary"><img src="<?php echo JUri::base().'images/sprite.svg#felesh-left'; ?>" width="26" height="55" alt="Felesh Left" data-uk-svg></a>
                    </div>
                </div>
                <div class="hoverCover hor top"><img src="<?php echo JUri::base().'images/homebg/top-'.rand(1, 3).'.jpg'; ?>" width="" height="" alt="" data-uk-cover></div>
                <div class="hoverCover hor bottom"><img src="<?php echo JUri::base().'images/homebg/bottom-'.rand(1, 3).'.jpg'; ?>" width="" height="" alt="" data-uk-cover></div>
                <div class="hoverCover ver left"><img src="<?php echo JUri::base().'images/homebg/left-'.rand(1, 3).'.jpg'; ?>" width="" height="" alt="" data-uk-cover></div>
                <div class="hoverCover ver right"><img src="<?php echo JUri::base().'images/homebg/right-'.rand(1, 3).'.jpg'; ?>" width="" height="" alt="" data-uk-cover></div>
            </div>
            <!-- Decor -->
            <div class="slide decor" data-anchor="decor">
                <div class="uk-height-1-1 uk-position-relative sectionWrapper anchorsWrapper decor">
                    <div class="shadow"></div>
                    <div class="uk-position-absolute whiteShade"></div>
                    <div class="uk-position-absolute uk-position-top uk-width-1-1 uk-text-center leather" data-uk-scrollspy-class="uk-animation-slide-top">
                        <a href="#" class="uk-visible@m uk-padding uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#decor-top' ?>" data-uk-svg></a>
                        <a href="#" class="uk-hidden">aaaaa</a>
                    </div>
                    <div class="uk-position-absolute uk-position-right uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-right">
                        <a href="<?php echo JUri::base().'decoration/interior-design'; ?>" class="uk-visible@m uk-padding uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#decor-right' ?>" data-uk-svg></a>
                        <a href="<?php echo JUri::base().'decoration/interior-design'; ?>" class="uk-hidden">aaaaa</a>
                    </div>
                    <div class="uk-position-absolute uk-position-bottom uk-width-1-1 uk-text-center style" data-uk-scrollspy-class="uk-animation-slide-bottom">
                        <a href="<?php echo JUri::base().'decoration'; ?>" class="uk-visible@m uk-padding uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#decor-bottom' ?>" data-uk-svg></a>
                        <a href="<?php echo JUri::base().'decoration'; ?>" class="uk-hidden">aaaaa</a>
                    </div>
                    <div class="uk-position-absolute uk-position-left uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-left">
                        <a href="<?php echo JUri::base().'#main/intro'; ?>" class="uk-visible@m uk-padding uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#decor-left' ?>" data-uk-svg></a>
                        <a href="<?php echo JUri::base().'#main/intro'; ?>" class="uk-hidden">aaaaa</a>
                    </div>
                    <div class="uk-position-center uk-padding uk-padding-remove-vertical">
                        <div class="hexagonWrapper"><img src="<?php echo JUri::base().'images/svg/hexagon.svg'; ?>" class="uk-width-1-1 uk-height-1-1" data-uk-svg></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Style -->
        <div class="section">
            <div class="uk-height-1-1 uk-position-relative sectionWrapper anchorsWrapper style">
                <div class="shadow"></div>
                <div class="uk-position-absolute whiteShade"></div>
                <div class="uk-position-absolute uk-position-top uk-width-1-1 uk-text-center leather" data-uk-scrollspy-class="uk-animation-slide-top">
                    <a href="<?php echo JUri::base().'#main/intro'; ?>" class="uk-visible@m uk-padding uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#style-top' ?>" data-uk-svg></a>
                </div>
                <div class="uk-position-absolute uk-position-right uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-right">
                    <a href="#" class="uk-visible@m uk-padding uk-display-inline-block uk-text-muted"><img src="<?php echo JUri::base().'images/sprite.svg#arrow-curve-v' ?>" data-uk-svg></a>
                </div>
                <div class="uk-position-absolute uk-position-bottom uk-width-1-1 uk-text-center style" data-uk-scrollspy-class="uk-animation-slide-bottom">
                    <a href="#" class="uk-visible@m uk-padding uk-display-inline-block uk-text-muted"><img src="<?php echo JUri::base().'images/sprite.svg#arrow-curve-h' ?>" data-uk-svg></a>
                </div>
                <div class="uk-position-absolute uk-position-left uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-left">
                    <a href="#" class="uk-visible@m uk-padding uk-display-inline-block uk-text-muted fa-flip-horizontal"><img src="<?php echo JUri::base().'images/sprite.svg#arrow-curve-v' ?>" data-uk-svg></a>
                </div>
                <div class="uk-position-center uk-padding uk-padding-remove-vertical">
                    <div><img src="<?php echo JUri::base().'images/svg/coming-soon-style.svg'; ?>" data-uk-svg></div>
                </div>
            </div>
        </div>
    </div>
<?php } elseif (strpos($pageclass, 'anar')) { ?>
    <jdoc:include type="message" />
    <jdoc:include type="component" />
<?php } else { ?>
    <div class="mainWrapper uk-flex uk-flex-middle <?php if ($layout != 'listing'&& !strpos($pageclass, 'noPadding')) echo 'uk-padding-large uk-padding-remove-horizontal'; ?>" data-uk-height-viewport="expand: true">
        <div class="uk-padding___ uk-padding-remove-vertical___ uk-flex-1">
            <div class="<?php if (strpos($pageclass, 'xsmall')) {echo 'uk-container uk-container-xsmall';} elseif (strpos($pageclass, 'auth')) {echo 'uk-container';} elseif (strpos($pageclass, 'expand')) {echo 'uk-container-expand';} elseif ($view == 'validation_code' || $view == 'validation_mobile' || $view == 'registration') {echo 'uk-container uk-container-xsmall';} ?>">
                <div>
                    <div class="uk-grid-medium" data-uk-grid>
                        <jdoc:include type="modules" name="sidestart" style="xhtml" />
                        <div class="uk-width-1-1 uk-width-expand@m">
                            <div class="<?php if (strpos($pageclass, 'boxed')) {echo 'uk-card uk-card-default uk-border-rounded uk-border-rounded-large uk-card-bordered uk-box-shadow-medium uk-position-relative uk-text-zer';} ?>">
                                <?php if (strpos($pageclass, 'boxed')) { ?>
                                    <div class="uk-position-absolute uk-position-top-left cardFloatingLogo">
                                        <div class="uk-grid-small uk-flex-left" data-uk-grid>
                                            <div class="uk-width-expand uk-flex uk-flex-left uk-flex-bottom"><img src="<?php echo JUri::base().'images/sprite.svg#loginText'; ?>" class="uk-preserve-width text" data-uk-svg></div>
                                            <div class="uk-width-auto uk-text-gold"><img src="<?php echo JUri::base().'images/sprite.svg#anar'; ?>" class="uk-preserve-width" data-uk-svg></div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="<?php if (strpos($pageclass, 'boxed')) {echo 'uk-card-body uk-padding floatingLogo';} ?>">
                                    <jdoc:include type="message" />
                                    <jdoc:include type="component" />
                                </div>
                            </div>
                        </div>
                        <jdoc:include type="modules" name="sideend" style="xhtml" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (!strpos($pageclass, 'auth') && $view != 'validation_code' && $view != 'registration' && $view != 'validation_mobile') { ?>
        <footer class="uk-padding-small uk-padding-remove-horizontal ltr">
            <div class="uk-padding-large uk-padding-remove-vertical">
                <div class="uk-child-width-1-1 uk-grid-divider uk-grid-small" data-uk-grid>
                    <jdoc:include type="modules" name="footer" style="xhtml" />
                    <div class="moduletable uk-text-white">
                        <ul class="nav menu mod-list uk-grid-small uk-child-width-auto uk-flex-between uk-text-center" data-uk-grid>
                            <li class="item-229"><a href="#" class="fontEn uk-link-reset uk-text-bold uk-h4">About Anar</a></li>
                            <li class="item-230"><a href="##" class="fontEn uk-link-reset uk-text-bold uk-h4">News</a></li>
                            <li class="item-231"><a href="<?php echo JUri::base().'contact-us'; ?>" class="fontEn uk-link-reset uk-text-bold uk-h4">Contact Us</a></li>
                            <li class="uk-width-1-1 uk-width-1-3@s item-232 uk-flex uk-flex-center">
                                <div class="uk-flex uk-flex-middle">
                                    <a href="##" class="fontEn uk-link-reset uk-text-bold uk-h4 uk-margin-remove-bottom uk-margin-right uk-visible@s">Follow Us :</a>
                                    <ul class="uk-grid-small socials" data-uk-grid>
                                        <?php for($i=0;$i<$total;$i++) { ?>
                                            <?php if ($socialsicons['link'][$i] != '') { ?>
                                                <li><a href="<?php echo $socialsicons['link'][$i]; ?>" target="_blank" title="<?php echo $socialsicons['title'][$i]; ?>" data-uk-tooltip="cls: uk-active font;" class="uk-flex uk-flex-center uk-flex-middle uk-text-white"><img src="<?php echo JURI::base().'images/sprite.svg#'.$socialsicons['icon'][$i] ?>" width="22" height="22" alt="" class="uk-preserve-width" data-uk-svg></a></li>
                                            <?php } ?>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="uk-text-center">
                        <div class="uk-grid-small uk-child-width-auto uk-flex-center uk-flex-between@s uk-text-white" data-uk-grid>
                            <div><span class="uk-link-reset uk-display-block fontEn">Producer of Fully Handmade Bags and Accessories From the Most Desirable Genuine Cow Leather and Valuable Jewels</span></div>
                            <div class="uk-visible@s"><span class="uk-link-reset uk-display-block fontEn">Anar Leather</span></div>
                            <div><span class="uk-link-reset uk-display-block fontEn">&copy; All Rights Reserved</span></div>
                            <div><span class="uk-link-reset uk-display-block fontEn">Since 2013</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    <?php } ?>
<?php } ?>
<jdoc:include type="modules" name="global" style="xhtml" />
</body>
</html>