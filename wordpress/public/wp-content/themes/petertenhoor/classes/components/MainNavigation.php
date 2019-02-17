<?php

namespace PTH;

/**
 * Class MainNavigation
 * @package PTH
 */
class MainNavigation extends Singleton
{

    const NAVIGATION_LOCATION_SLUG = 'main_nav';

    /**
     * MainNavigation constructor.
     */
    protected function __construct()
    {
        add_action('after_setup_theme', [$this, 'registerMainNavigation']);
    }

    /**
     * Register navigation
     */
    public static function registerMainNavigation()
    {
        register_nav_menu(self::NAVIGATION_LOCATION_SLUG, __('Main navigation', Theme::TEXT_DOMAIN));
    }

}