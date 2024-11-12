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
        Carbon::createFromFormat('d.m.Y.', $request->dateOfPayment)->format('Y-m-d');
        if ($currentMembershipFeeRecord && $currentDate->between($currentMembershipFeeRecord->dateOfPayment, $currentMembershipFeeRecord->dateExpiry, true)) {
            FeeRecords::create([
                'clientID' => $currentMembershipFeeRecord->clientID,
                'dateOfPayment' => Carbon::createFromFormat('d.m.Y.', $request->dateOfPayment)->format('Y-m-d'),
                'dateExpiry' => Carbon::createFromFormat('d.m.Y.', $request->dateExpiry)->format('Y-m-d'),
                'membershipFee' => $request->membershipFeeRecord,
            ]);

            $message = 'Članarina evidentirana';
        } else {
            
            FeeRecords::create([
                'clientID' => $id,
                'dateOfPayment' => Carbon::createFromFormat('d.m.Y.', $request->dateOfPayment)->format('Y-m-d'),
                'dateExpiry' => Carbon::createFromFormat('d.m.Y.', $request->dateExpiry)->format('Y-m-d'),
                'membershipFee' => $request->membershipFeeRecord,
            ]);

            $message = 'Članarina produžena';
        }

        return response()->json(['message' => $message]);
    }
}
