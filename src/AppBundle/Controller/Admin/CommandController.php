<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Yaml\Yaml;

class CommandController extends Controller
{

    public function clearCacheAction(KernelInterface $kernel)
    {
        $this->yamlParcerAsseatsUpper();

        $content = $this->doCommand($kernel, 'cache:clear');

        $this->addFlash('success', $content);
        return $this->redirectToRoute('admin.index');
    }
    
    public function commandCacheWarmup(KernelInterface $kernel)
    {
        return $this->doCommand($kernel, 'cache:warmup');
    }

    private function doCommand($kernel, $command)
    {
        $env = $kernel->getEnvironment();

        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput(array(
            'command' => $command,
            '--env' => $env
        ));

        $output = new BufferedOutput();
        $application->run($input, $output);

        $content = $output->fetch();

        return $content;
    }

    public function yamlParcerAsseatsUpper()
    {
        $path_to_file = $this->get('kernel')->getRootDir().'/../src/AppBundle/Resources/config/asseats.yml';
        $arr = Yaml::parse(file_get_contents($path_to_file));

        $upper = $arr['parameters']['my_version'];
        $arr['parameters']['my_version'] = ++$upper;

        $yaml = Yaml::dump($arr);
        file_put_contents($path_to_file, $yaml);
    }
}