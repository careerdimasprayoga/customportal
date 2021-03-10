<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customer';
    public $timestamps = true;

    protected $fillable = [
        'kode',
        'nama',
        'email',
        'password',
        'harga_lama',
        'jtempo',
        'whatsapp2',
        'wakonf',
        'wakonf2',
        'online',
        'ktp',
        'telepon',
        'whatsapp',
        'npwp',
        'perusahaan',
        'alamat',
        'rekening',
        'rekomendasi',
        'username'
    ];
}
