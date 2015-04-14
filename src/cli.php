<?php
/**
 * @author Petr Grishin <petr.grishin@grishini.ru>
 */
require_once __DIR__ . '/../vendor/autoload.php';

use PetrGrishin\Skeleton\Command\InitCommand;
use Symfony\Component\Console\Application;


$console = new Application('Skeleton', '0.0.0');
$console->add(new InitCommand());
$console->run();
