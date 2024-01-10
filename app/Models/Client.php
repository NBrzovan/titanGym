<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstName',
        'lastName',
        'gender',
        'email',
        'phone',
        'dateOfBirth',
        'status'
    ];

    protected $table = 'client';

    public static function getAllClients()
    {        
        return self::all();
    }

    public static function getClient($id)
    {        
        return self::find($id);
    }

    public function updateClient($id, $data)
    {
        $client = self::find($id);

        if (!$client) {
            return null; // Klijent nije pronađen
        }

        $client->update($data);

        return $client;
    }

    public function deleteClient($id)
    {
        $client = self::find($id);

        if (!$client) {
            return false; // Klijent nije pronađen
        }

        return $client->delete();
    }
}
