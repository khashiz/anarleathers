<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_search
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Including fallback code for the placeholder attribute in the search field.
JHtml::_('jquery.framework');
JHtml::_('script', 'system/html5fallback.js', array('version' => 'auto', 'relative' => true, 'conditional' => 'lt IE 9'));

if ($width)
{
	$moduleclass_sfx .= ' ' . 'mod_search' . $module->id;
	$css = 'div.mod_search' . $module->id . ' input[type="search"]{ width:auto; }';
	JFactory::getDocument()->addStyleDeclaration($css);
	$width = ' size="' . $width . '"';
}
else
{
	$width = '';
}
?>
<div class="uk-position-absolute uk-position-top-center uk-width-1-1 uk-box-shadow-small uk-padding searchWrapper search<?php echo $moduleclass_sfx; ?>" id="searchWrapper" hidden>
    <div class="uk-grid-divider uk-grid-medium uk-child-width-1-1" data-uk-grid>
        <div>
            <div>
                <div class="uk-grid-divider uk-grid-small" data-uk-grid>
                    <div class="uk-width-expand">
                        <form action="<?php echo JRoute::_('index.php'); ?>" method="post" class="form-inline" role="search">
                            <?php
                            $output = '<label class="uk-hidden" for="mod-search-searchword' . $module->id . '" class="element-invisible">' . $label . '</label> ';
                            $output .= '<input name="searchword" id="mod-search-searchword' . $module->id . '" maxlength="' . $maxlength . '"  class="uk-input font inputbox search-query input-medium" type="search" autofocus' . $width;
                            $output .= ' placeholder="' . $text . '" />';

                            if ($button) :
                                if ($imagebutton) :
                                    $btn_output = ' <input type="image" alt="' . $button_text . '" class="button" src="' . $img . '" onclick="this.form.searchword.focus();"/>';
                                else :
                                    $btn_output = ' <button class="button btn btn-primary" onclick="this.form.searchword.focus();">' . $button_text . '</button>';
                                endif;

                                switch ($button_pos) :
                                    case 'top' :
                                        $output = $btn_output . '<br />' . $output;
                                        break;

                                    case 'bottom' :
                                        $output .= '<br />' . $btn_output;
                                        break;

                                    case 'right' :
                                        $output .= $btn_output;
                                        break;

                                    case 'left' :
                                    default :
                                        $output = $btn_output . $output;
                                        break;
                                endswitch;
                            endif;

                            echo $output;
                            ?>
                            <input type="hidden" name="task" value="search" />
                            <input type="hidden" name="option" value="com_search" />
                            <input type="hidden" name="Itemid" value="<?php echo $mitemid; ?>" />
                        </form>
                    </div>
                    <div class="uk-width-small">
                        <div class="uk-height-1-1 uk-flex uk-flex-middle">
                            <button type="button" class="uk-button uk-button-link uk-width-1-1 uk-text-bold font" data-uk-toggle="target: #searchWrapper; animation: uk-animation-fade"><?php echo JText::_('CLOSE'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="uk-child-width-1-4@m uk-flex-between" data-uk-grid><?php echo JHtml::_('content.prepare', '{loadposition searchmenu}'); ?></div>
        </div>
    </div>
</div>
