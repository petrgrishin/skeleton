<?php
/**
 * @author Petr Grishin <petr.grishin@grishini.ru>
 */
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Yaml;

$console = new Application('Skeleton', '0.0.0');
$console
    ->register('init')
    ->setDefinition(array(
        new InputArgument('skeleton', InputArgument::REQUIRED, 'Skeleton, e.g. foo/bar'),
    ))
    ->setDescription('Init repository by skeleton')
    ->setCode(function (InputInterface $input, OutputInterface $output) {
        $skeleton = $input->getArgument('skeleton');

        $localConfig = trim(`cat ~/.vendor`);
        $loadLocalConfig = Yaml::parse($localConfig);

        $process = new Process(sprintf('git clone https://github.com/%s.git ./', $skeleton));
        $process->run();
        if (!$process->isSuccessful()) {
            return $output->writeln($process->getErrorOutput());
        }
        $skeletonConfig = trim(`cat .skeleton`);
        $loadSkeletonConfig = Yaml::parse($skeletonConfig);

        $iterator = (new Finder())
            ->files()
            ->name('*')
            ->exclude(['.git'])
            ->in(trim(`pwd`));

        foreach ($iterator as $file) {
            // replace content by $file->getRealpath();
        }

        $output->writeln('Done.');
    })
;
$console->run();
