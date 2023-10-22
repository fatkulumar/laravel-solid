<?php

namespace App\Models;

use App\Traits\GenUid;
use App\Traits\Acessor\ConverDateToIndonesia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory, GenUid, ConverDateToIndonesia;

    protected $fillable = [
        'test',
        'foto'
    ];
}
