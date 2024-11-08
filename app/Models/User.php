<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'points' => 0,
    ];
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getAdmin($id){
        $user = User::select('firstName', 'lastName', 'email')->where('id', $id)->first();

        return $user;
    }
    
    public static function updateAdmin($data, $id){
        $validator = Validator::make($data, [
            'adminName' => 'required|string|max:255',
            'adminLastName' => 'required|string|max:255',
            'adminEmail' => 'required|email|max:255'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        $user = self::find($id);
        
        if ($user) {
            $user->firstName = $data['adminName'];
            $user->lastName = $data['adminLastName'];
            $user->email = $data['adminEmail'];
            
            $user->save();
            
            return $user;
        } else {
            return "Korisnik nije pronađen.";
        }
    }


    protected $table = 'user';
}