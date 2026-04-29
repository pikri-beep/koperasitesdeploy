<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbmodal extends Model
{
    protected $table = 'tbmodals';
    
    protected $fillable = [
        'simpanan_pokok',
        'simpanan_wajib', 
        'simpanan_sementara'
    ];
}