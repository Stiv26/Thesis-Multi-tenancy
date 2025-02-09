<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Renter extends Model
{
    protected $table = 'renter';

    protected $fillable = [
        'no_telp',
        'password',
        'email',
        'nama',
        'alamat',
        'keterangan',
        'domains_id',
        'users_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, '');
    }

    public function domain()
    {
        return $this->belongsTo(Domain::class, 'domains_id');
    }
}
