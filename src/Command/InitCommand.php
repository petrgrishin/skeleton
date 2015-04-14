<?php
/**
 * @author Petr Grishin <petr.grishin@grishini.ru>
 */


namespace PetrGrishin\Skeleton\Command;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Process;

class InitCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('init')
            ->setDefinition(array(
                new InputArgument('skeleton', InputArgument::REQUIRED, 'Skeleton, e.g. foo/bar')
            ))
            ->setDescription('Init repository by skeleton');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $skeleton = $input->getArgument('skeleton');
        $pwd = $this->config()->getValue('path.pwd');
        if ((new Finder())->files()->in($pwd)->count()) {
            throw new \Exception('Current path is not an empty directory');
        }
        $this->downloadSkeleton($skeleton);
        $this->config()->loadConfigSkeleton();

        // Input user value by skeleton config

        $iterator = (new Finder())
            ->files()
            ->name('*')
            ->exclude(['.git'])
            ->in($pwd);

        foreach ($iterator as $file) {
            //$output->writeln($file);
        }

        $output->writeln('Done.');
    }

    protected function downloadSkeleton($skeleton)
    {
        $process = new Process(sprintf('git clone https://%s/%s.git ./', $this->config()->getValue('github.domain'), $skeleton));
        $process->run();
        if (!$process->isSuccessful()) {
            throw new \Exception($process->getErrorOutput());
        }
        return $this;
    }
}