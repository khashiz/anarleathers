<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$user = JFactory::getUser();


$db = JFactory::getDbo();
$userQuery = $db->getQuery(true);
$userQuery
    ->select($db->quoteName(array('user_cms_id', 'mobile')))
    ->from($db->quoteName('#__hikashop_user'))
    ->where($db->quoteName('user_cms_id') . ' = ' . $user->id);
$userInfo = $db->setQuery($userQuery)->loadObject();

$id = '';

if ($tagId = $params->get('tag_id', ''))
{
	$id = ' id="' . $tagId . '"';
}

// The menu class is deprecated. Use nav instead
?>
<aside class="uk-width-1-1 uk-width-1-4@m">
    <div>
        <div class="uk-card uk-card-default uk-card-bordered uk-border-rounded-large">
            <div class="uk-card-body uk-padding-small userMenu">
                <span class="uk-card uk-card-default uk-card-bordered uk-display-inline-block uk-border-circle uk-padding-small uk-position-absolute uk-text-gold avatar">
                    <img src="<?php echo JUri::base().'images/sprite.svg#userOutline'; ?>" width="48" height="48" data-uk-svg>
                </span>
                <div class="uk-text-center uk-margin-medium-top uk-margin-bottom uk-text-gold userName">
                    <span class="uk-display-block font"><?php echo $user->name; ?></span>
                    <?php if (!empty($userInfo->mobile)) { ?>
                        <span class="uk-display-block font"><?php echo $userInfo->mobile; ?></span>
                    <?php } ?>
                </div>
                <ul class="nav menu<?php echo $class_sfx; ?> mod-list"<?php echo $id; ?>>
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

                        echo '<li class="' . $class . '">';

                        switch ($item->type) :
                            case 'separator':
                            case 'component':
                            case 'heading':
                            case 'url':
                                require JModuleHelper::getLayoutPath('mod_menu', 'dashboard_' . $item->type);
                                break;

                            default:
                                require JModuleHelper::getLayoutPath('mod_menu', 'dashboard_url');
                                break;
                        endswitch;

                        // The next item is deeper.
                        if ($item->deeper)
                        {
                            echo '<ul class="nav-child unstyled small">';
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
</aside>