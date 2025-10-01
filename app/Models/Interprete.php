<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Factories\HasFactory;


class Interprete extends Model
{
    use HasFactory;

    protected $table = 'interpretres';
    protected $primaryKey = 'id_interprete';

    protected $fillable = [
        'id_medecin',
        'nom',
        'prenom',
    ];

    // Relation avec Medecin
    public function medecin()
    {
        return $this->belongsTo(Medecin::class, 'id_medecin');
    }
}
