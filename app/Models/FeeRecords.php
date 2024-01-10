<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeRecords extends Model
{
    use HasFactory;

    protected $table = 'feeRecords';

    public function client()
    {
        return $this->belongsTo(Client::class, 'clientID');
    }
}
