<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obatalkes_m';
    protected $primaryKey = 'obatalkes_id';
    public $incrementing = false;
    protected $keyType = 'unsignedBigInteger';
    public $timestamps = false;

    protected $guarded = [];
}
