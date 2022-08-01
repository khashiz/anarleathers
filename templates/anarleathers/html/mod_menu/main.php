<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$id = '';

if ($tagId = $params->get('tag_id', ''))
{
	$id = ' id="' . $tagId . '"';
}

// The menu class is deprecated. Use nav instead
?>
<div id="mainMenu" class="uk-modal-full" data-uk-modal="esc-close:false">
    <div class="uk-modal-dialog">
        <div data-uk-height-viewport>
            <ul class="nav mainMenuWrapper menu<?php echo $class_sfx; ?> mod-list"<?php echo $id; ?>>
                <?php foreach ($list as $i => &$item)
                {
                    $class = 'item-' . $item->id;

                    if ($item->id == $default_id)
                    {
                        $class .= ' default';
                    }

                    if ($item->id == $active_id || ($item->type === 'alias' && $item->params->get('aliasoptions') == $active_id))
                    {
                        $class .= ' current';
                    }

                    if (in_array($item->id, $path))
                    {
                        $class .= ' active';
                    }
                    elseif ($item->type === 'alias')
                    {
                        $aliasToId = $item->params->get('aliasoptions');

                        if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
                        {
                            $class .= ' active';
                        }
                        elseif (in_array($aliasToId, $path))
                        {
                            $class .= ' alias-parent-active';
                        }
                    }

                    if ($item->type === 'separator')
                    {
                        $class .= ' divider';
                    }

                    if ($item->deeper)
                    {
                        $class .= ' deeper';
                    }

                    if ($item->parent)
                    {
                        $class .= ' parent';
                    }

                    echo '<li class="level level-'.$item->level.' '. $class . '">';

                    switch ($item->type) :
                        case 'separator':
                        case 'component':
                        case 'heading':
                        case 'url':
                            require JModuleHelper::getLayoutPath('mod_menu', 'main_' . $item->type);
                            break;

                        default:
                            require JModuleHelper::getLayoutPath('mod_menu', 'main_url');
                            break;
                    endswitch;

                    // The next item is deeper.
                    if ($item->deeper)
                    {
                        echo '<ul class="nav-child uk-flex-1 unstyled small level-'.$item->level.'" '.(($item->level == 2 ? " data-uk-drop='mode:hover;offset:5'":"")).'><span class="uk-position-absolute" style="background-image: url('.$item->menu_image.')"></span>';
                    }
                    // The next item is shallower.
                    elseif ($item->shallower)
                    {
                        echo '</li>';
                        echo str_repeat('</ul></li>', $item->level_diff);
                    }
                    // The next item is on the same level.
                    else
                    {
                        echo '</li>';
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</div>