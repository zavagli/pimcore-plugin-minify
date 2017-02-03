<?php

namespace Minify;

use Pimcore\API\Plugin as PluginLib;

class Plugin extends PluginLib\AbstractPlugin implements PluginLib\PluginInterface
{
    public function init()
    {
        parent::init();
    }

    public static function install()
    {
        return true;
    }

    public static function uninstall()
    {
        return true;
    }

    public static function isInstalled()
    {
        return true;
    }
  
}
