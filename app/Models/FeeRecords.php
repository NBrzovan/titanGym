<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeRecords extends Model
{
    use HasFactory;

    protected $table = 'feerecords';
    
    protected $fillable = [
        'clientID',
        'dateOfPayment',
        'dateExpiry',
        'membershipFee',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'clientID');
    }

    public static function addMembershipFeeForClient($request, $id)
    {
        $currentMembershipFeeRecord = FeeRecords::where('clientID', $id)->latest('created_at')->first();
        $currentDate = Carbon::now();

        if ($currentMembershipFeeRecord && $currentDate->between($currentMembershipFeeRecord->dateOfPayment, $currentMembershipFeeRecord->dateExpiry, true)) {
            FeeRecords::create([
                'clientID' => $currentMembershipFeeRecord->clientID,
                'dateOfPayment' => $currentMembershipFeeRecord->dateExpiry, 
                'dateExpiry' => Carbon::parse($currentMembershipFeeRecord->dateExpiry)->addMonth()->toDateString(), 
                'membershipFee' => $request->membershipFeeRecord,
            ]);

            $message = 'Članarina evidentirana';
        } else {
            FeeRecords::create([
                'clientID' => $id,
                'dateOfPayment' => $currentDate->toDateString(), 
                'dateExpiry' => $currentDate->copy()->addMonth()->toDateString(), 
                'membershipFee' => $request->membershipFeeRecord,
            ]);

            $message = 'Članarina produžena';
        }

        return response()->json(['message' => $message]);
    }
}
