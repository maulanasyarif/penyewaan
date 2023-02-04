<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'transaksi';
    protected $guarded = [];

    public function  user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaksi_details()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
