<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ModelClient extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'clients';
    protected $primaryKey = 'id_client';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'tel',
        'password',
    ];
}
