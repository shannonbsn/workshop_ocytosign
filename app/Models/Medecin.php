<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Factories\HasFactory;

class Medecin extends Model
{
    use HasFactory;

    protected $table = 'medecins';
    protected $primaryKey = 'id_medecin';

    protected $fillable = [
        'nom',
        'prenom',
    ];
}
