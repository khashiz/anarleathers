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

// Add Stylesheets
JHtml::_('stylesheet', 'uikit-rtl.min.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'fullpage.min.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'anar.css', array('version' => 'auto', 'relative' => true));

// Add js
JHtml::_('script', 'uikit.min.js', array('version' => 'auto', 'relative' => true));
JHtml::_('script', 'fullpage.min.js', array('version' => 'auto', 'relative' => true));
JHtml::_('script', 'custom.js', array('version' => 'auto', 'relative' => true));
if (JFactory::getLanguage()->isRtl()) {JHtml::_('script', 'persianumber.min.js', array('version' => 'auto', 'relative' => true));}

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
<body class="<?php echo $view.' '.$layout.' '.$task; ?>">

<!--Main Nav-->
<div class="uk-position-fixed uk-position-top-right uk-position-z-index uk-text-zero">
    <div class="uk-padding-small mainNav">
        <div class="uk-flex uk-flex-column uk-text-primary" data-uk-scrollspy="cls: uk-animation-slide-right; target: > *; delay: 200;">
            <div><a href="<?php echo JUri::base().'#main/intro'; ?>" class="uk-padding-small uk-text-primary uk-display-inline-block uk-border-rounded hoverIcon" title="<?php echo JText::sprintf('NAV_MAIN_PAGE') ?>" data-uk-tooltip="cls: uk-active font; title: <?php echo JText::sprintf('NAV_MAIN_PAGE') ?>; pos: left-center; offset: 15;"><img src="<?php echo JUri::base().'images/sprite.svg#eye' ?>" alt="" width="24" height="24" data-uk-svg></a></div>
            <div><a href="#mainMenu" data-uk-toggle class="uk-padding-small uk-text-primary uk-display-inline-block uk-border-rounded hoverIcon" title="<?php echo JText::sprintf('NAV_MENU') ?>" data-uk-tooltip="cls: uk-active font; pos: left-center; offset: 15;"><img src="<?php echo JUri::base().'images/sprite.svg#menu' ?>" alt="" width="24" height="24" data-uk-svg></a></div>
            <div><a href="#" class="uk-padding-small uk-text-primary uk-display-inline-block uk-border-rounded hoverIcon" title="<?php echo JText::sprintf('NAV_CART') ?>" data-uk-tooltip="cls: uk-active font; pos: left-center; offset: 15;"><img src="<?php echo JUri::base().'images/sprite.svg#cart' ?>" alt="" width="24" height="24" data-uk-svg></a></div>
            <div><a href="#" class="uk-padding-small uk-text-primary uk-display-inline-block uk-border-rounded hoverIcon" title="<?php echo JText::sprintf('NAV_WISHLIST') ?>" data-uk-tooltip="cls: uk-active font; pos: left-center; offset: 15;"><img src="<?php echo JUri::base().'images/sprite.svg#wishlist' ?>" alt="" width="24" height="24" data-uk-svg></a></div>
            <div><a href="#" class="uk-padding-small uk-text-primary uk-display-inline-block uk-border-rounded hoverIcon" title="<?php echo JFactory::getUser()->guest ? JText::sprintf('NAV_LOGIN') : JText::sprintf('NAV_MENU'); ?>" data-uk-tooltip="cls: uk-active font; pos: left-center; offset: 15;"><img src="<?php echo JUri::base().'images/sprite.svg#user' ?>" alt="" width="24" height="24" data-uk-svg></a></div>
        </div>
    </div>
</div>

<!--Social Icons-->
<div data-uk-scrollspy="cls: uk-animation-slide-left; target: > *; delay: 200;">
    <div class="uk-position-fixed uk-position-bottom-left uk-position-z-index uk-text-zero">
        <div class="uk-padding-small">
            <a href="#" class="uk-padding-small uk-display-inline-block uk-text-primary uk-border-rounded hoverIcon"><img src="<?php echo JUri::base().'images/sprite.svg#triangle' ?>" alt="" width="24" height="24" data-uk-svg></a>
            <div data-uk-drop="pos: right-center; offset: 0;" id="socialsDrop">
                <div class="uk-padding-small">
                    <div id="socialIcons" class="uk-child-width-auto uk-flex-nowrap uk-flex-row-reverse uk-grid-small" data-uk-grid data-uk-scrollspy="cls: uk-animation-slide-right; target: > div; repeat: true; delay: 100;">
                        <?php for($i=0;$i<$total;$i++) { ?>
                            <?php if ($socialsicons['link'][$i] != '') { ?>
                                <div><a href="<?php echo $socialsicons['link'][$i]; ?>" target="_blank" title="<?php echo $socialsicons['title'][$i]; ?>" data-uk-tooltip="cls: uk-active font;" class="uk-flex uk-flex-center uk-flex-middle uk-text-primary"><img src="<?php echo JURI::base().'images/sprite.svg#'.$socialsicons['icon'][$i] ?>" width="24" height="24" alt="" class="uk-preserve-width" data-uk-svg></a></div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="anarContainer">
    <div class="section" data-section="leather">
        <div class="uk-height-1-1 sectionWrapper leather">
            <div class="uk-container uk-height-1-1 uk-position-relative" data-uk-scrollspy="target: > div;">
                <div class="uk-position-absolute miz">
                    <a href="" class="uk-display-inline-block"><img src="<?php echo JUri::base().'images/sectionLeather/miz.png'; ?>" width="974" height="628" alt="" class="uk-preserve-width"></a>
                </div>
                <div class="uk-position-absolute women">
                    <a href="" class="uk-display-inline-block"><img src="<?php echo JUri::base().'images/sectionLeather/women.png'; ?>" width="258" height="692" alt="" class="uk-preserve-width"></a>
                </div>
            </div>
        </div>
    </div>
    <div class="section active">
        <div class="slide jewelry" data-anchor="jewelry">
            <div>
                <h1>jewelry</h1>
                <a href="#main/intro">Introoooooooooo</a>
            </div>
        </div>
        <div class="slide active" data-anchor="intro">
            <div class="uk-height-1-1 uk-position-relative anchorsWrapper" data-uk-scrollspy="target: > div; delay: 200;">
                <div class="uk-position-absolute uk-position-top uk-width-1-1 uk-text-center leather" data-uk-scrollspy-class="uk-animation-slide-top">
                    <a href="<?php echo JUri::base().'#leather'; ?>" class="uk-padding uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#homeNavLeather' ?>" data-uk-svg></a>
                </div>
                <div class="uk-position-absolute uk-position-right uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-right">
                    <a href="<?php echo JUri::base().'#main/decor'; ?>" class="uk-padding uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#homeNavDecor' ?>" data-uk-svg></a>
                </div>
                <div class="uk-position-absolute uk-position-bottom uk-width-1-1 uk-text-center style" data-uk-scrollspy-class="uk-animation-slide-bottom">
                    <a href="<?php echo JUri::base().'#style'; ?>" class="uk-padding uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#homeNavStyle' ?>" data-uk-svg></a>
                </div>
                <div class="uk-position-absolute uk-position-left uk-height-1-1 uk-flex uk-flex-middle" data-uk-scrollspy-class="uk-animation-slide-left">
                    <a href="<?php echo JUri::base().'#main/jewelry'; ?>" class="uk-padding uk-display-inline-block uk-text-muted hoverPrimary"><img src="<?php echo JUri::base().'images/sprite.svg#homeNavJewelry' ?>" data-uk-svg></a>
                </div>
            </div>
        </div>
        <div class="slide decor" data-anchor="decor">
            <div>
                <h1>decor</h1>
                <a href="#main/intro">Introoooooooooo</a>
            </div>
        </div>
    </div>
    <div class="section" style="background-color: blue">
        <div>
            <h1>Enjoy it</h1>
            <a href="#main/intro">Introoooooooooo</a>
        </div>
    </div>
</div>

<div id="mainMenu" data-uk-offcanvas="overlay: true; flip: true;">
    <div class="uk-offcanvas-bar uk-width-1-2">

        <button class="uk-offcanvas-close" type="button" uk-close></button>


        <h3>Title</h3>

        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

    </div>
</div>

<jdoc:include type="modules" name="pagetop" style="xhtml" />
<jdoc:include type="message" />
</body>
</html>