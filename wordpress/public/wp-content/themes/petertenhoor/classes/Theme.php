<?php

namespace PTH;

//utils
require_once("utils/Singleton.php");
require_once("utils/Log.php");

//components
require_once("components/FlushFrontendCacheComponent.php");

/**
 * Class Theme
 *
 * @package PTH
 */
class Theme extends Singleton
{
    /**
     * Theme constructor.
     */
    protected function __construct()
    {
        self::initComponents();
    }

    /**
     * Init component classes
     */
    public static function initComponents()
    {
        FlushFrontendCacheComponent::getInstance();
    }
}

?>