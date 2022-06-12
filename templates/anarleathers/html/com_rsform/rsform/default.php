<?php
/**
* @package RSForm! Pro
* @copyright (C) 2007-2019 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted access');

$app  = JFactory::getApplication();
$user = JFactory::getUser();
// Getting params from template
$params = $app->getTemplate(true)->params;
$menu = $app->getMenu();
$active = $menu->getActive();
$pageparams = $menu->getParams( $active->id );
// Detecting Active Variables
$itemid   = $app->input->getCmd('Itemid', '');

$socialsicons = json_decode( $params->get('socials'),true);
$total = count($socialsicons['icon']);
?>
<div class="uk-grid-row-small uk-grid-divider" data-uk-grid>
    <div class="uk-width-1-1 uk-width-expand@s">
        <?php if ($this->params->get('show_page_heading', 0)) { ?>
            <h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
        <?php } ?>
        <?php echo RSFormProHelper::displayForm($this->formId); ?>
    </div>
    <div class="uk-width-1-1 uk-width-1-3@s">
        <div class="uk-child-width-1-1 uk-grid-divider" data-uk-grid>
            <div>
                <h2 class="uk-text-primary uk-margin-bottom sectionTitle font"><?php echo JText::sprintf('CONTACTINFO'); ?></h2>
                <div>
                    <div>
                        <div>
                            <div class="uk-child-width-1-1 uk-grid-medium uk-text-zero" data-uk-grid>
                                <?php if (!empty($params->get('address')) || !empty($params->get('phone')) || !empty($params->get('fax')) || !empty($params->get('cellphone')) || !empty($params->get('email'))) { ?>
                                    <div>
                                        <div>
                                            <div class="uk-grid-small" data-uk-grid>
                                                <?php if (!empty($params->get('address'))) { ?>
                                                    <div class="uk-width-1-1">
                                                        <div>
                                                            <div class="uk-grid-small contactFields" data-uk-grid>
                                                                <div class="uk-width-auto uk-text-primary uk-text-large"><i class="fas fa-map-signs"></i></div>
                                                                <div class="uk-width-expand uk-flex uk-flex-middle"><span class="uk-text-small uk-text-bold value font"><?php echo $params->get('address'); ?></span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <?php if (!empty($params->get('phone'))) { ?>
                                                    <div class="uk-width-1-1">
                                                        <div>
                                                            <div class="uk-grid-small contactFields" data-uk-grid>
                                                                <div class="uk-width-auto uk-text-primary uk-text-large"><i class="fas fa-phone fa-flip-horizontal"></i></div>
                                                                <div class="uk-width-expand uk-flex uk-flex-middle"><span class="uk-text-small uk-text-bold uk-display-inline-block ltr value font fnum"><?php $array = preg_split('/\n|\r\n/', $params->get('phone')); echo $array[0]; ?></span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <?php if (!empty($params->get('fax'))) { ?>
                                                    <div class="uk-width-1-1">
                                                        <div class="uk-grid-small contactFields" data-uk-grid>
                                                            <div class="uk-width-auto uk-text-primary uk-text-large"><i class="fas fa-fax"></i></div>
                                                            <div class="uk-width-expand uk-flex uk-flex-middle"><span class="uk-text-small uk-text-bold uk-display-inline-block ltr value font fnum"><?php echo $params->get('fax'); ?></span></div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <h2 class="uk-text-primary uk-margin-bottom sectionTitle font"><?php echo JText::sprintf('SOCIALMEDIA'); ?></h2>
                <ul class="uk-grid-small socials uk-child-width-expand" data-uk-grid>
                    <?php for($i=0;$i<$total;$i++) { ?>
                        <?php if ($socialsicons['link'][$i] != '') { ?>
                            <li><a href="<?php echo $socialsicons['link'][$i]; ?>" target="_blank" title="<?php echo $socialsicons['title'][$i]; ?>" data-uk-tooltip="cls: uk-active font;" class="uk-flex uk-flex-center uk-flex-middle uk-text-secondary"><img src="<?php echo JURI::base().'images/sprite.svg#'.$socialsicons['icon'][$i] ?>" width="22" height="22" alt="" class="uk-preserve-width" data-uk-svg></a></li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
            <?php if (!empty($params->get('lat')) && !empty($params->get('lng'))) { ?>
                <div class="uk-hidden@m">
                    <h2 class="uk-text-primary uk-margin-bottom sectionTitle font"><?php echo JText::sprintf('PATHFINDER'); ?></h2>
                    <div>
                        <div class="uk-grid-small uk-child-width-1-2" data-uk-grid>
                            <div><a href="https://waze.com/ul?ll=<?php echo $params->get('lat'); ?>,<?php echo $params->get('lng'); ?>&navigate=yes" class="uk-width-1-1 uk-padding-small uk-button uk-button-default uk-border-rounded uk-box-shadow-small" target="_blank" rel="noreferrer"><img src="<?php echo JURI::base().'images/waze-logo.svg' ?>" width="100" alt=""></a></div>
                            <div><a href="http://maps.google.com/maps?daddr=<?php echo $params->get('lat'); ?>,<?php echo $params->get('lng'); ?>" class="uk-width-1-1 uk-padding-small uk-button uk-button-default uk-border-rounded uk-box-shadow-small" target="_blank" rel="noreferrer"><img src="<?php echo JURI::base().'images/google-maps-logo.svg'; ?>" width="100" alt=""></a></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="uk-visible@m" data-uk-lightbox>
                <a class="uk-button uk-button-default uk-border-pill uk-width-1-1 uk-button-large uk-text-bold uk-box-shadow-small font uk-flex uk-flex-center uk-flex-middle" href="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3236.5126655528593!2d51.445603815553056!3d35.78734563175184!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f8e05cb80ed9cf7%3A0xd3443023583777ec!2sTavan%20Ressan!5e0!3m2!1sen!2s!4v1643272136825!5m2!1sen!2s" data-caption="<?php echo JText::sprintf('SHOWONMAP'); ?>" data-type="iframe"><i class="fas fa-map-signs uk-margin-small-left"></i><?php echo JText::sprintf('SHOWONMAP'); ?></a>
            </div>
        </div>
    </div>
</div>