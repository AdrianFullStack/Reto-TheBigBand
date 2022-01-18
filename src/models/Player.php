<?php

namespace Uniqoders\Game\src\models;

class Player extends Stat
{
    public string $name;
    private Stat $stats;

    public function __construct($name)
    {
        $this->name = $name;
        $this->stats = new Stat();
    }

    public function winner() {
        $this->stats->victory ++;
    }

    public function loser() {
        $this->stats->defeat ++;
    }

    public function draw() {
        $this->stats->draw ++;
    }

    public function report(): array
    {
        return [$this->name, $this->stats->victory, $this->stats->draw, $this->stats->defeat];
    }

    public function countWinner(): int
    {
        return $this->stats->victory;
    }
}