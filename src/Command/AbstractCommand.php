<?php
/**
 * @author Petr Grishin <petr.grishin@grishini.ru>
 */

namespace PetrGrishin\Skeleton\Command;

use PetrGrishin\Skeleton\Config;
use Symfony\Component\Console\Command\Command;

class AbstractCommand extends Command
{

    /**
     * @return Config
     */
    public function config()
    {
        return $this->getApplication()->config();
    }
}