<?php


namespace Pitchart\Wssc\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Console\Helper\Table;
use Curl\Curl;
use Pitchart\Wssc\Http\Response;

class CheckCommand extends Command implements ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Command configuration
     */
    protected function configure()
    {
        $this
            ->setName('check:url')
            ->setDescription('Check security based on an URL')
            ->addArgument('url', InputArgument::REQUIRED, 'The URL to check')
        ;
    }

    /**
     * Command execution
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');

        $checkerChain = $this->container->get('wssc.checker_chain');
        $checkerChain->processChecks($url);

        $translator = $this->container->get('translator');

        $results = array();
        foreach ($checkerChain->getResults() as $check => $result) {
            $color = $result === true ? 'info' : 'error';
            $message = $result === true ? $translator->trans('checker.result.success') : $translator->trans('checker.result.fail');
            $results[] = array(
                sprintf('<comment>%s</comment>', $translator->trans('checker.name.'.$check)),
                sprintf('<%1$s>%2$s</%1$s>', $color, $message)
            );
        }
        $output->writeln('Testing HTTP configuration for '.$url);
        $table = new Table($output);
        $table
            ->setHeaders(array('Test', 'Result'))
            ->setRows($results)
        ;
        $table->render();

    }
}
