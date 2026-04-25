<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTutorial extends Model
{
    use HasFactory;

    // Tambahkan baris ini juga
    protected $fillable = [
        'master_tutorial_id',
        'text',
        'gambar',
        'code',
        'url',
        'order',
        'status'
    ];
}