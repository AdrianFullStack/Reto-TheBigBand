<?php

namespace Uniqoders\Game\src\config;

class Config
{
    public function weapons($isBigBang)
    {
        if ($isBigBang) {
            return [
                0 => 'Piedra',
                1 => 'Papel',
                2 => 'Tijeras',
                3 => 'Lagarto',
                4 => 'Spock'
            ];
        }
        return [
            0 => 'Piedra',
            1 => 'Papel',
            2 => 'Tijeras',
        ];
    }

    public function rules()
    {
        // 0 => Draw
        // 1 => Winner
        // 2 => Loser
        return [
            [0, 1, 2, 2, 1],
            [2, 0, 1, 1, 2],
            [1, 2, 0, 2, 1],
            [1, 2, 1, 0, 2],
            [2, 1, 2, 1, 0],
        ];
    }
}