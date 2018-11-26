<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Stormz23\Marvel\Repositories\Read\Marvel;

class MarvelTest extends TestCase
{
    public function testGetAllCharacters()
    {
        $config = config("services.marvel");
        $repo = new Marvel($config['apiPublicKey'], $config['apiPrivateKey']);

        $characters = $repo->getAllCharacters();

        $this->assertTrue(count($characters) == 100);
    }

    public function testGetAllSeries()
    {
        $config = config("services.marvel");
        $repo = new Marvel($config['apiPublicKey'], $config['apiPrivateKey']);

        $series = $repo->getAllSeries();

        $this->assertTrue(count($series) == 100);

        $serie489 = null;
        foreach ($series as $serie) {

            if ($serie['id'] == 489) {

                $serie489 = $serie;
                break;
            }
        }

        $this->assertTrue(isset($serie489));

        return $serie489;
    }

    /**
    *   @depends testGetAllSeries
    **/
    public function testGetSerieCharacters($serie)
    {
        $config = config("services.marvel");
        $repo = new Marvel($config['apiPublicKey'], $config['apiPrivateKey']);

        $characters = $repo->getSerieCharacters($serie['id']);

        $this->assertTrue(count($characters) > 2);
    }
}
