<?php

namespace App\Console\Command;

use App\Service\FileManager;

use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class CacheClearCommand extends Command
{
    private array $paths;

    /**
     * @var FileManager
     */
    private FileManager $files;

    public function __construct(array $paths, FileManager $files)
    {
        $this->paths = $paths;
        $this->files = $files;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('cache:clear')
            ->setDescription('Clear cache')
            ->addArgument('alias', InputArgument::OPTIONAL, 'The alias of available paths.');
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $output->writeln('<comment>Clearing </comment><info>cache!</info>');

        $alias = $input->getArgument('alias');

        if (empty($alias)) {
            $helper = $this->getHelper('question');
            $options = array_merge(['all'], array_keys($this->paths));
            $question = new ChoiceQuestion('Choose path', $options, 0);
            $alias = $helper->ask($input, $output, $question);
        }

        if ($alias === 'all') {
            $paths = $this->paths;
        } else {
            if (!array_key_exists($alias, $this->paths)) {
                throw new InvalidArgumentException('Unknown path alias "' . $alias . '"' . PHP_EOL);
            }
            $paths = [$alias => $this->paths[$alias]];
        }

        foreach ($paths as $path) {
            if ($this->files->exists($path)) {
                $output->writeln('Remove ' . $path);
                $this->files->delete($path, $output);
            } else {
                $output->writeln('<comment>Skip</comment>' . $path);
            }
        }

        $output->writeln('<info>Done!</info>');
    }
}
