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
if ($pageclass == 'home') {
    JHtml::_('stylesheet', 'fullpage.min.css', array('version' => 'auto', 'relative' => true));
}
JHtml::_('stylesheet', 'anar.css', array('version' => 'auto', 'relative' => true));

// Add js
JHtml::_('script', 'uikit.min.js', array('version' => 'auto', 'relative' => true));
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
    <!--Utility Icons-->
    <div class="uk-position-fixed uk-position-top-right uk-position-z-index uk-text-zero" data-uk-scrollspy-class="uk-animation-slide-right">
        <div class="uk-padding-small">
            <a href="<?php echo JUri::base().'#main/intro'; ?>" class="uk-padding-small uk-display-inline-block uk-text-primary uk-border-rounded hoverIcon"><img src="<?php echo JUri::base().'images/sprite.svg#eye' ?>" alt="" width="36" height="36" data-uk-svg></a>
            <div data-uk-drop="pos: left-center; offset: 0;" id="utilitiesDrop">
                <div class="uk-padding-small">
                    <div id="utilityIcons" class="uk-child-width-auto uk-flex-nowrap uk-grid-small" data-uk-grid data-uk-scrollspy="cls: uk-animation-slide-left; target: > div; repeat: true; delay: 100;">
                        <div><a href="#mainMenu" data-uk-toggle class="uk-padding-small uk-text-primary uk-display-inline-block uk-border-rounded hoverIcon" title="<?php echo JText::sprintf('NAV_MENU') ?>" data-uk-tooltip="cls: uk-active font; pos: bottom; offset: 15;"><img src="<?php echo JUri::base().'images/sprite.svg#menu' ?>" alt="" width="22" height="22" class="uk-preserve-width" data-uk-svg></a></div>
                        <div><a href="#" class="uk-padding-small uk-text-primary uk-display-inline-block uk-border-rounded hoverIcon" title="<?php echo JText::sprintf('NAV_CART') ?>" data-uk-tooltip="cls: uk-active font; pos: bottom; offset: 15;"><img src="<?php echo JUri::base().'images/sprite.svg#cart' ?>" alt="" width="26" height="22" class="uk-preserve-width" data-uk-svg></a></div>
                        <div><a href="#" class="uk-padding-small uk-text-primary uk-display-inline-block uk-border-rounded hoverIcon" title="<?php echo JText::sprintf('NAV_WISHLIST') ?>" data-uk-tooltip="cls: uk-active font; pos: bottom; offset: 15;"><img src="<?php echo JUri::base().'images/sprite.svg#wishlist' ?>" alt="" width="22" height="22" class="uk-preserve-width" data-uk-svg></a></div>
                        <div>
                            <?php if ($user->guest) { ?>
                                <a href="#loginModal" data-uk-toggle class="uk-padding-small uk-text-primary uk-display-inline-block uk-border-rounded hoverIcon" title="<?php echo JText::sprintf('NAV_LOGIN'); ?>" data-uk-tooltip="cls: uk-active font; pos: bottom; offset: 15;"><img src="<?php echo JUri::base().'images/sprite.svg#user' ?>" alt="" width="22" height="22" class="uk-preserve-width" data-uk-svg></a>
                            <?php } else { ?>
                                <a href="#" class="uk-padding-small uk-text-primary uk-display-inline-block uk-border-rounded hoverIcon" title="<?php echo JText::sprintf('NAV_USER_ACCOUNT', $user->name); ?>"><img src="<?php echo JUri::base().'images/sprite.svg#user' ?>" alt="" width="22" height="22" class="uk-preserve-width" data-uk-svg></a>
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
    <div class="uk-position-fixed uk-position-bottom-left uk-position-z-index uk-text-zero" data-uk-scrollspy-class="uk-animation-slide-left">
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
<?php if ($pageclass == 'home') { ?>
    <div id="anarContainer">
        <div class="section" data-section="leather">
            <div class="uk-height-1-1 sectionWrapper leather">
                <div class="uk-container uk-height-1-1 uk-position-relative" data-uk-scrollspy="target: > div;">
                    <div class="uk-position-absolute miz">
                        <a href="<?php echo JRoute::_("index.php?Itemid=125"); ?>" class="uk-display-inline-block"><img src="<?php echo JUri::base().'images/sectionLeather/miz.png'; ?>" width="974" height="628" alt="" class="uk-preserve-width"></a>
                    </div>
                    <div class="uk-position-absolute women">
                        <a href="<?php echo JRoute::_("index.php?Itemid=124"); ?>" class="uk-display-inline-block"><img src="<?php echo JUri::base().'images/sectionLeather/women.png'; ?>" width="258" height="692" alt="" class="uk-preserve-width"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="section active">
            <div class="slide jewelry" data-anchor="jewelry">
                <div class="uk-height-1-1 sectionWrapper jewelry">
                    <div class="uk-container uk-height-1-1 uk-position-relative" data-uk-scrollspy="target: > div;">
                        <div class="">fdffefrfefef</div>
                    </div>
                </div>
            </div>
            <div class="slide hmWrapper active" data-anchor="intro">
                <span class="line two"></span>
                <span class="line three"></span>
                <div class="uk-height-1-1 uk-position-relative anchorsWrapper uk-position-z-index" data-uk-scrollspy="target: > div; delay: 200;">
                    <div class="uk-position-absolute uk-position-center uk-height-1-1 homeMainWrapper" data-uk-height-viewport data-uk-scrollspy-class="uk-animation-fade">
                        <img src="<?php echo JUri::base().'images/sprite.svg#homeMain'; ?>" class="uk-height-1-1 homeMain logo" data-uk-svg>
                    </div>
                    <div class="uk-position-absolute uk-position-top uk-width-1-1 uk-text-center leather" data-uk-scrollspy-class="uk-animation-slide-top">
                        <a href="<?php echo JUri::base().'#leather'; ?>" class="uk-padding uk-display-inline-block uk-text-muted hoverPrimary" onmouseover="shapeon('leather')" onmouseleave="shapeoff()"><img src="<?php echo JUri::base().'images/sprite.svg#homeNavLeather' ?>" data-uk-svg></a>
                    </div>
                    <div class="uk-position-absolute uk-position-right uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-right">
                        <a href="<?php echo JUri::base().'#main/decor'; ?>" class="uk-padding uk-display-inline-block uk-text-muted hoverPrimary" onmouseover="shapeon('decor')" onmouseleave="shapeoff()"><img src="<?php echo JUri::base().'images/sprite.svg#homeNavDecor' ?>" data-uk-svg></a>
                    </div>
                    <div class="uk-position-absolute uk-position-bottom uk-width-1-1 uk-text-center style" data-uk-scrollspy-class="uk-animation-slide-bottom">
                        <a href="<?php echo JUri::base().'#style'; ?>" class="uk-padding uk-display-inline-block uk-text-muted hoverPrimary" onmouseover="shapeon('style')" onmouseleave="shapeoff()"><img src="<?php echo JUri::base().'images/sprite.svg#homeNavStyle' ?>" data-uk-svg></a>
                    </div>
                    <div class="uk-position-absolute uk-position-left uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-left">
                        <a href="<?php echo JUri::base().'#main/jewelry'; ?>" class="uk-padding uk-display-inline-block uk-text-muted hoverPrimary" onmouseover="shapeon('jewelry')" onmouseleave="shapeoff()"><img src="<?php echo JUri::base().'images/sprite.svg#homeNavJewelry' ?>" data-uk-svg></a>
                    </div>
                </div>
            </div>
            <div class="slide decor" data-anchor="decor">
                <div class="uk-height-1-1 sectionWrapper decor">
                    <div class="uk-container uk-height-1-1 uk-position-relative" data-uk-scrollspy="target: > div;">
                        <div class="">fdffefrfefef</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="uk-height-1-1 sectionWrapper style">
                <div class="uk-container uk-height-1-1 uk-position-relative" data-uk-scrollspy="target: > div;">
                    <div class="">fdffefrfefef</div>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="mainWrapper uk-padding-large uk-padding-remove-horizontal uk-flex uk-flex-middle" data-uk-height-viewport="expand: true">
        <div class="uk-padding uk-padding-remove-vertical uk-flex-1">
            <div class="uk-container <?php if (strpos($pageclass, 'xsmall')) {echo 'uk-container-xsmall';} elseif (strpos($pageclass, 'expand')) {echo 'uk-container-expand';} ?>">
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