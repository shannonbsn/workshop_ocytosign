<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelRdv extends Model
{
    use HasFactory;

    protected $table = 'rdvs';
    protected $primaryKey = 'id_rdv';

    protected $fillable = [
        'id_medecin',
        'id_interprete',
        'date_debut',
        'date_fin',
        'presentiel'
    ];
}
