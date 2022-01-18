<?php

namespace Uniqoders\Game\src\models;

class Stat
{
    public int $draw;
    public int $victory;
    public int $defeat;

    public function __construct()
    {
        $this->draw = 0;
        $this->victory = 0;
        $this->defeat = 0;
    }
}