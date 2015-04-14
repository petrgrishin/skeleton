<?php
/**
 * @author Petr Grishin <petr.grishin@grishini.ru>
 */

namespace PetrGrishin\Skeleton;

use PetrGrishin\ArrayAccess\ArrayAccess;
use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Yaml;

class Config extends ArrayAccess
{

    public static function byDefault()
    {
        return new static(array(
            'path' => array(),
            'process' => array(
                'timeout' => 300
            ),
            'github' => array(
                'domain' => 'github.com'
            ),
            'config' => array(
                'vendor' => '~/.vendor',
                'skeleton' => '.skeleton',
            )
        ));
    }

    public function loadPathInfo()
    {
        $process = new Process('pwd');
        $process->run();
        if (!$process->isSuccessful()) {
            throw new \Exception($process->getErrorOutput());
        }
        $this->setValue('path.pwd', trim($process->getOutput()));
        return $this;
    }

    public function loadConfigVendor() {
        $this->loadConfigByKey('vendor');
        return $this;
    }

    public function loadConfigSkeleton() {
        $this->loadConfigByKey('skeleton');
        return $this;
    }

    protected function loadConfigByKey($key) {
        $process = new Process(sprintf('cat %s', $this->getValue('config.' . $key)));
        $process->run();
        if (!$process->isSuccessful()) {
            // An optional config
            return $this;
        }
        $configVendor = Yaml::parse($process->getOutput());
        $this->setValue($key, $configVendor);
        return $this;
    }
}