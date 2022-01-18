<?php

namespace Uniqoders\Tests\Unit\Console;

use Uniqoders\Game\src\config\Config;
use Uniqoders\Game\src\models\Play;
use Uniqoders\Tests\Unit\UnitTestCase;

class MakeDrinkCommandTest extends UnitTestCase
{
    /**
    0 => 'Piedra',
    1 => 'Papel',
    2 => 'Tijeras',
    3 => 'Lagarto',
    4 => 'Spock'
     */

    private Config $config;
    private Play $play;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->config = new Config();
        $this->play = new Play($this->config->rules());
    }

    public function testTijerasCortanPapel()
    {
        $this->assertEquals($this->play->fight(2, 1), 2, 'Yo pierdo');
    }

    public function testPapelCubrePiedra()
    {
        $this->assertEquals($this->play->fight(1, 0), 2, 'Yo pierdo');
    }

    public function testPiedraAplastaLagarto()
    {
        $this->assertEquals($this->play->fight(0, 3), 2, 'Yo pierdo');
    }

    public function testLagartoEnvenenaSpock()
    {
        $this->assertEquals($this->play->fight(3, 4), 2, 'Yo pierdo');
    }

    public function testSpockDestrozaTijeras()
    {
        $this->assertEquals($this->play->fight(4, 2), 2, 'Yo pierdo');
    }

    public function testTijerasDecapitanLagarto()
    {
        $this->assertEquals($this->play->fight(2, 3), 2, 'Yo pierdo');
    }

    public function testLagartoComePapel()
    {
        $this->assertEquals($this->play->fight(3, 1), 2, 'Yo pierdo');
    }

    public function testPapelRefutaSpock()
    {
        $this->assertEquals($this->play->fight(1, 4), 2, 'Yo pierdo');
    }

    public function testSpockVaporizaPiedra()
    {
        $this->assertEquals($this->play->fight(4, 0), 2, 'Yo pierdo');
    }

    public function testPiedraAplastaTijeras()
    {
        $this->assertEquals($this->play->fight(0, 2), 2, 'Yo pierdo');
    }

    public function testEmpatePiedra()
    {
        $this->assertEquals($this->play->fight(0, 0), 0, 'Empate');
    }

    public function testEmpatePapel()
    {
        $this->assertEquals($this->play->fight(1, 1), 0, 'Empate');
    }

    public function testEmpateTijeras()
    {
        $this->assertEquals($this->play->fight(2, 2), 0, 'Empate');
    }

    public function testEmpateLagarto()
    {
        $this->assertEquals($this->play->fight(3, 3), 0, 'Empate');
    }

    public function testEmpateSpock()
    {
        $this->assertEquals($this->play->fight(4, 4), 0, 'Empate');
    }
}
