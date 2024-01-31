<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeRecords extends Model
{
    use HasFactory;

    protected $table = 'feeRecords';
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

    public function addMembershipFeeForClient($request, $id){
        $currentMembershipFeeRecord = FeeRecords::where('clientID', $id)->latest('created_at')->first();
        $currentDate = Carbon::now();
            
        if ($currentDate->between($currentMembershipFeeRecord->dateOfPayment, $currentMembershipFeeRecord->dateExpiry, true)) {
            FeeRecords::create([
                'clientID' => $currentMembershipFeeRecord->clientID,
                'dateOfPayment' => $currentMembershipFeeRecord->dateExpiry,
                'dateExpiry' => $currentDate->addMonth()->toDateString(),
                'membershipFee' => $request->membershipFeeRecord,
            ]);

            $message = 'Članarina evidentirana';
        } else {
            FeeRecords::create([
                'clientID' => $currentMembershipFeeRecord->clientID,
                'dateOfPayment' => $currentDate->toDateString(),
                'dateExpiry' => $currentDate->addMonth()->toDateString(),
                'membershipFee' => $request->membershipFeeRecord,
            ]);

            $message = 'Članarina produžena';
        }

        return response()->json(['message' => $message]); 
        
    }
}
