<?php
// src/Command/CreateUserCommand.php
namespace App\Command;

use App\Repository\QuizzRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'process:clear:quizz', description: 'run process clear quizz')]
class ProcessClearQuizzCommand extends Command
{
    
    protected static $defaultName = 'process:clear:quizz';

    // the command description shown when running "php bin/console list"
    protected static $defaultDescription = 'run process clear quizz';
    // ...
    protected $quizzRepository;

    protected function configure(): void
    {
        $this
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to run process clear quizz')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // ... put here the code to create the user

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable
        $process = new Process(['./bin/console']);
        $process->run(fn ($err, $res) => dump($res, $err));
        dump('test');
        return 1;
        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}