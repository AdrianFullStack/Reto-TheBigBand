<?php

namespace Uniqoders\Game\src\models;

class Play
{
    private array $rules;

    public function __construct($rules)
    {
        $this->rules = $rules;
    }

    public function fight($player1,$player2) {
        return $this->rules[$player1][$player2];
    }
}