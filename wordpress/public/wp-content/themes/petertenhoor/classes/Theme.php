<?php

namespace PTH;

//utils
require_once("utils/Singleton.php");
require_once("utils/Log.php");

//components
require_once("components/FlushFrontendCacheComponent.php");
require_once("components/MainNavigation.php");
require_once("components/GraphqlCacheComponent.php");

/**
 * Class Theme
 *
 * @package PTH
 */
class Theme extends Singleton
{
    /**
     * Define text domain
     */
    const TEXT_DOMAIN = 'petertenhoor';

    /**
     * Define image sizes
     */
    const IMAGE_SIZE_POST = 'imageSizePost';

    /**
     * Theme constructor.
     */
    protected function __construct()
    {
        self::initComponents();
        self::setImageSizes();
    }

    /**
     * Init component classes
     */
    public static function initComponents()
    {
        FlushFrontendCacheComponent::getInstance();
        MainNavigation::getInstance();
        GraphqlCacheComponent::getInstance();
    }

    /**
     * Set image sizes
     */
    public static function setImageSizes()
    {
        add_theme_support('post-thumbnails');
        add_image_size(self::IMAGE_SIZE_POST, 450, 300, true);
    }
}

?>