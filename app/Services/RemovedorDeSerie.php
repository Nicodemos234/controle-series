<?php

namespace App\Services;

use App\{Serie, Temporada, Episodio};
use App\Events\SerieApagada;
use App\Jobs\ExcluirCapaSerie;
use Illuminate\Support\Facades\DB;
use Storage;

class RemovedorDeSerie
{
    public function removerSerie(int $serieId): string
    {
        $nomeSerie = '';
        DB::transaction(function () use ($serieId, &$nomeSerie) {
            $serie = Serie::find($serieId);
            $serieObj = (object) $serie->toArray();
            $nomeSerie = $serie->nome;

            $this->removerTemporada($serie);
            $serie->delete();

            $event = new SerieApagada($serieObj);

            event($event);
            ExcluirCapaSerie::dispatch($serieObj);
        });


        return $nomeSerie;
    }

    private function removerTemporada($serie): void
    {
        $serie->temporadas->each(function (Temporada $temporada) {
            $this->removerEpisodios($temporada);
            $temporada->delete();
        });
    }

    private function removerEpisodios(Temporada $temporada): void
    {
        $temporada->episodios->each(function (Episodio $episodio) {
            $episodio->delete();
        });
    }
}
