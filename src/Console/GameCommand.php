<?php

namespace Uniqoders\Game\src\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Uniqoders\Game\src\config\Config;
use Uniqoders\Game\src\models\Play;
use Uniqoders\Game\src\models\Player;

class GameCommand extends Command
{
    private $config;

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('game')
            ->setDescription('New game: you vs computer')
            ->addArgument('name', InputArgument::OPTIONAL, 'what is your name?', 'Player 1');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->config = new Config();
        $output->write(PHP_EOL . 'Made with ♥ by Uniqoders.' . PHP_EOL . PHP_EOL);

        $player_name = $input->getArgument('name');

        $computer = new Player('Computer');
        $player = new Player($player_name);
        $play = new Play($this->config->rules());

        $round = 1;
        $max_round = 5;

        $ask = $this->getHelper('question');

        $question = new ConfirmationQuestion('The Big Bang Theory? y/n: ', false);
        $isBigBang = !$ask->ask($input, $output, $question) ? Command::SUCCESS : Command::FAILURE;

        // Weapons available
        $weapons = $this->config->weapons($isBigBang);

        $question = new ConfirmationQuestion('Change max round? y/n: ', false);
        $changeMaxRound = !$ask->ask($input, $output, $question) ? Command::SUCCESS : Command::FAILURE;
        if($changeMaxRound) {
            $question = new Question('Please enter the max round: ');
            $question->setValidator(function ($value) {
                $value = trim($value);
                if ($value == '' || $value == 0) {
                    throw new \Exception('The max round cannot be empty');
                }

                if (!is_numeric($value)) {
                    throw new \Exception('Only numbers!');
                }
                return $value;
            });
            $max_round = $ask->ask($input, $output, $question);
        }

        do {
            // User selection
            $question = new ChoiceQuestion('Please select your weapon', array_values($weapons), 1);
            $question->setErrorMessage('Weapon %s is invalid.');

            $user_weapon = $ask->ask($input, $output, $question);
            $output->writeln('You have just selected: ' . $user_weapon);
            $user_weapon = array_search($user_weapon, $weapons);

            // Computer selection
            $computer_weapon = array_rand($weapons);
            $output->writeln('Computer has just selected: ' . $weapons[$computer_weapon]);

            if ($play->fight($computer_weapon, $user_weapon) === 1) {
                $player->winner();
                $computer->loser();
                $output->writeln($player->name . ' win!');
            } else if ($play->fight($computer_weapon, $user_weapon) === 2) {
                $computer->winner();
                $player->loser();
                $output->writeln('Computer win!');
            } else {
                $computer->draw();
                $player->draw();
                $output->writeln('Draw!');
            }

            $round++;
        } while ($round <= $max_round && ($player->countWinner() < 3 && $computer->countWinner() < 3));

        // Display stats
        $stats = [
            $computer,
            $player
        ];

        $stats = array_map(function ($player) {
            return $player->report();
        }, $stats);

        $table = new Table($output);
        $table
            ->setHeaders(['Player', 'Victory', 'Draw', 'Defeat'])
            ->setRows($stats);

        $table->render();

        return 0;
    }
}
