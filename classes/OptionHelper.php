<?php

namespace OFFLINE\Indirect\Classes;

use OFFLINE\Indirect\Models\Category;
use OFFLINE\Indirect\Models\Redirect;
use Cms\Classes\Page;
use Cms\Classes\Theme;
use System\Classes\PluginManager;

/**
 * Class OptionHelper
 *
 * @package OFFLINE\Indirect\Classes
 */
class OptionHelper
{
    /**
     * @return array
     */
    public static function getTargetTypeOptions()
    {
        return [
            Redirect::TARGET_TYPE_PATH_URL => 'offline.indirect::lang.redirect.target_type_path_or_url',
            Redirect::TARGET_TYPE_CMS_PAGE => 'offline.indirect::lang.redirect.target_type_cms_page',
            Redirect::TARGET_TYPE_STATIC_PAGE => 'offline.indirect::lang.redirect.target_type_static_page',
        ];
    }

    /**
     * Get all CMS pages as an option array
     *
     * @return array
     */
    public static function getCmsPageOptions()
    {
        return Page::getNameList();
    }

    /**
     * Get all Static Pages as an option array
     *
     * @return array
     */
    public static function getStaticPageOptions()
    {
        $hasPagesPlugin = PluginManager::instance()->hasPlugin('RainLab.Pages');

        if (!$hasPagesPlugin) {
            return [];
        }

        $pages = \RainLab\Pages\Classes\Page::listInTheme(Theme::getActiveTheme());

        $options = [];

        /** @var \RainLab\Pages\Classes\Page $page */
        foreach ($pages as $page) {
            if (array_key_exists('title', $page->viewBag)) {
                $options[$page->getFileName()] = $page->viewBag['title'];
            }
        }

        return $options;
    }

    /**
     * @return array
     */
    public static function getCategoryOptions()
    {
        return (array) Category::all(['id', 'name'])->lists('name', 'key');
    }
}
