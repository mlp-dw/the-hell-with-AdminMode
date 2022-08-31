<?php
// src/Command/CreateUserCommand.php
namespace App\Command;

use App\Repository\QuizzRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'clear:quizz', description: 'Clear quizz > 2 months.')]
class ClearQuizzCommand extends Command
{
    
    protected static $defaultName = 'clear:quizz';

    // the command description shown when running "php bin/console list"
    protected static $defaultDescription = 'Clear quizz > 2 months.';
    // ...
    protected $quizzRepository;


    public function __construct(QuizzRepository $quizzRepository)
    {
        Parent::__construct();
        $this->quizzRepository = $quizzRepository;
    }

    protected function configure(): void
    {
        $this
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to clear a quizz > 2 months')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // ... put here the code to create the user

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        while (true) {
            $this->quizzRepository->removeObsoleteQuizz();
            dump('clean');
            sleep(2630000);
        }
        return 1;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}