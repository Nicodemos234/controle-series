<?php

namespace Tests\Feature;

use App\Services\CriadorDeSerie;
use App\Services\RemovedorDeSerie;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RemoverDeSerieTest extends TestCase
{
    Use RefreshDatabase;

    //** @var Serie */
    private $serie;
    protected function setUp(): void
    {
        parent::setUp();
        $criadorDeSerie = new CriadorDeSerie();
        $this->serie = $criadorDeSerie->criarSerie('Nome da série', 1, 1);
    }
    public function testRemoverUmaSerie()
    {
        $this->assertDatabaseHas(
            'series',
            ['id' => $this->serie->id]
        );
        $removerDeSerie = new RemovedorDeSerie();
        $nomeSerie = $removerDeSerie->removerSerie($this->serie->id);
        $this->assertIsString($nomeSerie);
        $this->assertEquals('Nome da série', $nomeSerie);
        $this->assertDatabaseMissing(
            'series',
            ['id' => $this->serie->id]
        );
    }
}
