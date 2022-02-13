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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="theme-color" content="<?php echo $params->get('presetcolor'); ?>">
    <jdoc:include type="head" />
</head>
<body class="<?php echo $pageclass.' '.$view.' '.$layout.' '.$task; ?>">

<div data-uk-scrollspy="target: > *; delay: 200;">
    <!--Fullscreen Icon-->
    <div class="uk-position-fixed uk-position-top-left uk-text-zero toggleScreen frontZIndex" data-uk-scrollspy-class="uk-animation-slide-left">
        <div class="uk-padding-small">
            <a href="javascript:void(0)" onclick="openFullscreen();"  data-uk-toggle="target: .toggleScreen" class="uk-padding-small uk-display-inline-block uk-text-primary uk-border-rounded hoverIcon toggleScreenLink"><img src="<?php echo JUri::base().'images/sprite.svg#expand' ?>" alt="" width="24" height="24" data-uk-svg></a>
        </div>
        <jdoc:include type="modules" name="lang" style="none" />
    </div>
    <div class="uk-position-fixed uk-position-top-left uk-text-zero toggleScreen frontZIndex" data-uk-scrollspy-class="uk-animation-slide-left" hidden>
        <div class="uk-padding-small">
            <a href="javascript:void(0)" onclick="closeFullscreen();"  data-uk-toggle="target: .toggleScreen" class="uk-padding-small uk-display-inline-block uk-text-primary uk-border-rounded hoverIcon toggleScreenLink"><img src="<?php echo JUri::base().'images/sprite.svg#collapse' ?>" alt="" width="24" height="24" data-uk-svg></a>
        </div>
        <jdoc:include type="modules" name="lang" style="none" />
    </div>
    <!--Utility Icons-->
    <div class="uk-position-fixed uk-position-top-right uk-text-zero utilityIcons" data-uk-scrollspy-class="uk-animation-slide-right" onmouseleave="UIkit.drop('#utilitiesDrop').hide();">
        <div class="uk-padding-small">
            <a href="<?php echo JUri::base().'#main/intro'; ?>" class="uk-padding-small uk-display-inline-block uk-border-rounded hoverIcon icon" id="utilitiesDropToggle" onmouseenter="toggleMainMenu()"><img src="<?php echo JUri::base().'images/sprite.svg#eye' ?>" alt="" width="32" height="32" data-uk-svg></a>
            <div data-uk-drop="pos: left-center; offset: 0; mode: click;" id="utilitiesDrop">
                <div class="uk-padding-small">
                    <div id="utilityIcons" class="uk-child-width-auto uk-flex-nowrap uk-grid-collapse" data-uk-grid data-uk-scrollspy="cls: uk-animation-slide-left; target: > div; repeat: true; delay: 100; mode: hover">
                        <div>
                            <a href="#mainMenu" data-uk-toggle class="uk-padding-small uk-display-inline-block uk-border-rounded hoverIcon icon" title="<?php echo JText::sprintf('NAV_MENU') ?>" data-uk-tooltip="cls: uk-active font; pos: bottom; offset: 15;">
                                <div id="mainMenuToggler">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                        </div>
                        <div><a href="<?php echo JRoute::_("index.php?Itemid=132"); ?>" class="uk-padding-small uk-display-inline-block uk-border-rounded hoverIcon icon" title="<?php echo JText::sprintf('NAV_CART') ?>" data-uk-tooltip="cls: uk-active font; pos: bottom; offset: 15;"><img src="<?php echo JUri::base().'images/sprite.svg#cart' ?>" alt="" width="32" height="32" class="uk-preserve-width" data-uk-svg></a></div>
                        <div><a href="<?php echo JRoute::_("index.php?Itemid=131"); ?>" class="uk-padding-small uk-display-inline-block uk-border-rounded hoverIcon icon" title="<?php echo JText::sprintf('NAV_WISHLIST') ?>" data-uk-tooltip="cls: uk-active font; pos: bottom; offset: 15;"><img src="<?php echo JUri::base().'images/sprite.svg#wishlist' ?>" alt="" width="32" height="32" class="uk-preserve-width" data-uk-svg></a></div>
                        <div>
                            <?php if ($user->guest) { ?>
                                <a href="#loginModal" data-uk-toggle class="uk-padding-small uk-display-inline-block uk-border-rounded hoverIcon icon" title="<?php echo JText::sprintf('NAV_LOGIN'); ?>" data-uk-tooltip="cls: uk-active font; pos: bottom; offset: 15;"><img src="<?php echo JUri::base().'images/sprite.svg#user' ?>" alt="" width="32" height="32" class="uk-preserve-width" data-uk-svg></a>
                            <?php } else { ?>
                                <a href="#" class="uk-padding-small uk-display-inline-block uk-border-rounded hoverIcon" title="<?php echo JText::sprintf('NAV_USER_ACCOUNT', $user->name); ?>"><img src="<?php echo JUri::base().'images/sprite.svg#user' ?>" alt="" width="32" height="32" class="uk-preserve-width" data-uk-svg></a>
                                <div class="userMenuDrop" data-uk-drop="offset: 20;">
                                    <div class="uk-card uk-card-body uk-card-bordered uk-border-rounded-large uk-card-default uk-padding-small"><jdoc:include type="modules" name="usermenu" style="xhtml"/></div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Social Icons-->
    <div class="uk-position-fixed uk-position-bottom-left uk-text-zero frontZIndex" data-uk-scrollspy-class="uk-animation-slide-left">
        <div class="uk-padding-small">
            <a href="#" class="uk-padding-small uk-display-inline-block uk-text-primary uk-border-rounded hoverIcon"><img src="<?php echo JUri::base().'images/sprite.svg#triangle' ?>" alt="" width="36" height="36" data-uk-svg></a>
            <div data-uk-drop="pos: right-center; offset: 0;" id="socialsDrop">
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
</div>
<?php if (strpos($pageclass, 'home')) { ?>
    <div id="anarContainer">
        <!-- Leather -->
        <div class="section" data-section="leather">
            <div class="uk-height-1-1 uk-position-relative sectionWrapper anchorsWrapper leather">
                <div class="shadow"></div>
                <div class="uk-position-absolute whiteShade"></div>
                <div class="uk-position-absolute uk-position-top uk-width-1-1 uk-text-center leather" data-uk-scrollspy-class="uk-animation-slide-top">
                    <a href="#" class="uk-padding-small uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#leather-top' ?>" data-uk-svg></a>
                </div>
                <div class="uk-position-absolute uk-position-right uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-right">
                    <a href="#" class="uk-padding-small uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#leather-right' ?>" data-uk-svg></a>
                </div>
                <div class="uk-position-absolute uk-position-bottom uk-width-1-1 uk-text-center style" data-uk-scrollspy-class="uk-animation-slide-bottom">
                    <a href="<?php echo JUri::base().'#main/intro'; ?>" class="uk-padding-small uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#leather-bottom' ?>" data-uk-svg></a>
                </div>
                <div class="uk-position-absolute uk-position-left uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-left">
                    <a href="#" class="uk-padding-small uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#leather-left' ?>" data-uk-svg></a>
                </div>
                <div class="uk-position-center">
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
                    <div class="uk-position-absolute uk-position-top uk-width-1-1 uk-text-center leather" data-uk-scrollspy-class="uk-animation-slide-top">
                        <a href="#" class="uk-padding uk-display-inline-block uk-text-muted fa-flip-vertical"><img src="<?php echo JUri::base().'images/sprite.svg#arrow-curve-h' ?>" data-uk-svg></a>
                    </div>
                    <div class="uk-position-absolute uk-position-right uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-right">
                        <a href="<?php echo JUri::base().'#main/intro'; ?>" class="uk-padding uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#jewelry-right' ?>" height="90" data-uk-svg></a>
                    </div>
                    <div class="uk-position-absolute uk-position-bottom uk-width-1-1 uk-text-center style" data-uk-scrollspy-class="uk-animation-slide-bottom">
                        <a href="#" class="uk-padding uk-display-inline-block uk-text-muted"><img src="<?php echo JUri::base().'images/sprite.svg#arrow-curve-h' ?>" data-uk-svg></a>
                    </div>
                    <div class="uk-position-absolute uk-position-left uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-left">
                        <a href="#" class="uk-padding uk-display-inline-block uk-text-muted"><img src="<?php echo JUri::base().'images/sprite.svg#jewelry-left' ?>" height="90" data-uk-svg></a>
                    </div>
                    <div class="uk-position-center">
                        <div><img src="<?php echo JUri::base().'images/svg/coming-soon-jewelry.svg'; ?>" data-uk-svg></div>
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
                        <a href="<?php echo JUri::base().'#leather'; ?>" class="uk-padding uk-display-inline-block uk-text-muted hoverPrimary" onmouseover="shapeon('leather','top')" onmouseleave="shapeoff('top')"><img src="<?php echo JUri::base().'images/sprite.svg#homeNavLeather' ?>" data-uk-svg></a>
                    </div>
                    <div class="uk-position-absolute uk-position-right uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-right">
                        <a href="<?php echo JUri::base().'#main/decor'; ?>" class="uk-padding uk-display-inline-block uk-text-muted hoverPrimary" onmouseover="shapeon('decor','right')" onmouseleave="shapeoff('right')"><img src="<?php echo JUri::base().'images/sprite.svg#homeNavDecor' ?>" data-uk-svg></a>
                    </div>
                    <div class="uk-position-absolute uk-position-bottom uk-width-1-1 uk-text-center style" data-uk-scrollspy-class="uk-animation-slide-bottom">
                        <a href="<?php echo JUri::base().'#style'; ?>" class="uk-padding uk-display-inline-block uk-text-muted hoverPrimary" onmouseover="shapeon('style','bottom')" onmouseleave="shapeoff('bottom')"><img src="<?php echo JUri::base().'images/sprite.svg#homeNavStyle' ?>" data-uk-svg></a>
                    </div>
                    <div class="uk-position-absolute uk-position-left uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-left">
                        <a href="<?php echo JUri::base().'#main/jewelry'; ?>" class="uk-padding uk-display-inline-block uk-text-muted hoverPrimary" onmouseover="shapeon('jewelry','left')" onmouseleave="shapeoff('left')"><img src="<?php echo JUri::base().'images/sprite.svg#homeNavJewelry' ?>" data-uk-svg></a>
                    </div>
                </div>
                <div class="hoverCover hor top <?php echo 'style-'.rand(1, 5); ?>"></div>
                <div class="hoverCover hor bottom <?php echo 'style-'.rand(1, 5); ?>"></div>
                <div class="hoverCover ver left <?php echo 'style-'.rand(1, 5); ?>"></div>
                <div class="hoverCover ver right <?php echo 'style-'.rand(1, 5); ?>"></div>
            </div>
            <!-- Decor -->
            <div class="slide decor" data-anchor="decor">
                <div class="uk-height-1-1 uk-position-relative sectionWrapper anchorsWrapper decor">
                    <div class="shadow"></div>
                    <div class="uk-position-absolute whiteShade"></div>
                    <div class="uk-position-absolute uk-position-top uk-width-1-1 uk-text-center leather" data-uk-scrollspy-class="uk-animation-slide-top">
                        <a href="#" class="uk-padding uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#decor-top' ?>" data-uk-svg></a>
                    </div>
                    <div class="uk-position-absolute uk-position-right uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-right">
                        <a href="#" class="uk-padding uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#decor-right' ?>" data-uk-svg></a>
                    </div>
                    <div class="uk-position-absolute uk-position-bottom uk-width-1-1 uk-text-center style" data-uk-scrollspy-class="uk-animation-slide-bottom">
                        <a href="#" class="uk-padding uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#decor-bottom' ?>" data-uk-svg></a>
                    </div>
                    <div class="uk-position-absolute uk-position-left uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-left">
                        <a href="<?php echo JUri::base().'#main/intro'; ?>" class="uk-padding uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#decor-left' ?>" data-uk-svg></a>
                    </div>
                    <div class="uk-position-center">
                        <div class="hexagonWrapper"><img src="<?php echo JUri::base().'images/svg/hexagon.svg'; ?>" data-uk-svg></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="uk-height-1-1 uk-position-relative sectionWrapper anchorsWrapper style">
                <div class="shadow"></div>
                <div class="uk-position-absolute whiteShade"></div>
                <div class="uk-position-absolute uk-position-top uk-width-1-1 uk-text-center leather" data-uk-scrollspy-class="uk-animation-slide-top">
                    <a href="<?php echo JUri::base().'#main/intro'; ?>" class="uk-padding uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#style-top' ?>" data-uk-svg></a>
                </div>
                <div class="uk-position-absolute uk-position-right uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-right">
                    <a href="#" class="uk-padding uk-display-inline-block uk-text-muted"><img src="<?php echo JUri::base().'images/sprite.svg#arrow-curve-v' ?>" data-uk-svg></a>
                </div>
                <div class="uk-position-absolute uk-position-bottom uk-width-1-1 uk-text-center style" data-uk-scrollspy-class="uk-animation-slide-bottom">
                    <a href="#" class="uk-padding uk-display-inline-block uk-text-muted"><img src="<?php echo JUri::base().'images/sprite.svg#arrow-curve-h' ?>" data-uk-svg></a>
                </div>
                <div class="uk-position-absolute uk-position-left uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-left">
                    <a href="#" class="uk-padding uk-display-inline-block uk-text-muted fa-flip-horizontal"><img src="<?php echo JUri::base().'images/sprite.svg#arrow-curve-v' ?>" data-uk-svg></a>
                </div>
                <div class="uk-position-center">
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
            <div class="uk-container__ <?php if (strpos($pageclass, 'xsmall')) {echo 'uk-container uk-container-xsmall';} elseif (strpos($pageclass, 'auth')) {echo 'uk-container';} elseif (strpos($pageclass, 'expand')) {echo 'uk-container-expand';} ?>">
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
<?php } ?>
<jdoc:include type="modules" name="global" style="xhtml" />
</body>
</html>