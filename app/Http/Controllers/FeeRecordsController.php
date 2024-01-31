<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeeRecords;

class FeeRecordsController extends Controller
{
    public function recordClientMembershipFee(Request $request, $id){
        $addMembershipFee = FeeRecords::addMembershipFeeForClient($request, $id);

        return $addMembershipFee;
    }
}
