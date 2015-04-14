<?php
/**
 * @author Petr Grishin <petr.grishin@grishini.ru>
 */

namespace PetrGrishin\Skeleton;

use Symfony\Component\Console\Application;

class Skeleton extends Application {

    public function config()
    {
        static $config;
        if (!$config) {
            $config = Config::byDefault();
            $config
                ->loadPathInfo()
                ->loadConfigVendor();
        }
        return $config;
    }
}