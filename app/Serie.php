<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Serie extends Model
{
    public $timestamps = false;
    protected $fillable = ['nome', 'capa'];

    public function getCapaUrlAttribute()
    {
        return $this->capa != null ? Storage::url($this->capa) : Storage::url('serie/no-image.png');
    }

    public function temporadas()
    {
        return $this->hasMany(Temporada::class);
    }
}
