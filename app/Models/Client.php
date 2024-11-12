<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FeeRecords;
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

    public static function getAllClients($searchQuery = null){     
        $query = self::query();

        if ($searchQuery) {
            $query->where(function ($query) use ($searchQuery) {
                $query->where('firstName', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('lastName', 'LIKE', '%' . $searchQuery . '%');
            });
        }

        $query->select('client.*', 'feerecords.membershipFee as membershipFee', 'feerecords.dateOfPayment as dateOfPayment', 'feerecords.dateExpiry as dateExpiry')
            ->leftJoin('feerecords', function ($join) {
                $join->on('client.id', '=', 'feerecords.clientID')
                    ->whereRaw('feerecords.id = (SELECT MAX(id) FROM feerecords WHERE clientID = client.id)');
            })->orderBy('firstName', 'asc');

        return $query->get();
    }

    public static function getClient($id){        
        $clientData = self::leftJoin('feerecords', 'client.id', '=', 'feerecords.clientID')
        ->where('client.id', $id)
        ->latest('feerecords.created_at')  
        ->select('client.*', 'feerecords.membershipFee as membershipFee', 'feerecords.dateOfPayment', 'feerecords.dateExpiry')
        ->first();

        return $clientData;
    }

    public static function updateClient($id, $data){
        $client = self::find($id);
        
        if($data['email'] != ""){
            $existingClientEmail = Client::where('email', $data['email'])
                                    ->where('id', '!=', $id)
                                    ->first();
        
            if ($existingClientEmail) {
                return response()->json(['message' => 'E-mail već postoji'], 422);
            }
        }

        if($data['phone'] == null){
            $data['phone'] = "";
        }

        if($data['dateOfBirth'] != ""){
            $convertedDateOfBirth = Carbon::createFromFormat('d.m.Y.', $data['dateOfBirth'])->format('Y-m-d');
            $data['dateOfBirth'] = $convertedDateOfBirth;
        }else{
            $convertedDateOfBirth = null;
        }

        if($data['dateOfPayment'] != ""){
            $convertedDateOfPayment = Carbon::createFromFormat('d.m.Y.', $data['dateOfPayment'])->format('Y-m-d');
            $data['dateOfPayment'] = $convertedDateOfPayment;
        }else{
            $convertedDateOfPayment = null;
        }

        if($data['dateExpiry'] != ""){
            $convertedDateExpiry = Carbon::createFromFormat('d.m.Y.', $data['dateExpiry'])->format('Y-m-d');
            $data['dateExpiry'] = $convertedDateExpiry;
        }else{
            $convertedDateExpiry = null;
        }
  
        if (!$client) {
            return null; 
        }
        
        $client->update($data);
    
        if (isset($data['membershipFee'])) {
            // Dobijanje poslednjeg zapisa za određenog klijenta
            $latestFeeRecord = FeeRecords::where('clientID', $id)
                ->latest('created_at')
                ->first();
    
            if ($latestFeeRecord) {
                // Ažuriranje poslednjeg zapisa u FeeRecords tabeli
                $latestFeeRecord->update(['membershipFee' => $data['membershipFee']]);
            }
        }
    
        return $client;
    }

    public static function deleteClient($id){
        $client = self::find($id);

        if (!$client) {
            return false; 
        }

        $feeRecords = FeeRecords::where('clientID', $client->id)->get();

        foreach ($feeRecords as $feeRecord) {
            $feeRecord->delete();
        }

        return $client->delete();
    }

    public static function addClient($request){

        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            //'email' => 'required|email|max:255',
            'gender' => 'required|string|max:255',
            //'phone' => 'required|string|max:20',
            //'dateOfBirth' => 'required|date',
        ]);
        
        if($request->input('email') != "" || $request->input('email') != null){
            dd(1);
            $existingClientEmail = Client::where('email', $request->input('email'))->first();
            
            if ($existingClientEmail) {
                return response()->json(['message' => 'E-mail već postoji'], 422);
            }
        }
        
        if($request->input('dateOfBirth') != ""){
            $dateOfBirth = $request->input('dateOfBirth');
            $convertedDateOfBirth = Carbon::createFromFormat('d.m.Y.', $dateOfBirth)->format('Y-m-d');
        }else{
            $convertedDateOfBirth = null;
        }

        if($request->input('dateOfPayment') != ""){
            $dateOfPayment = $request->input('dateOfPayment');
            $convertedDateOfPayment = Carbon::createFromFormat('d.m.Y.', $dateOfPayment)->format('Y-m-d');
        }else{
            $convertedDateOfPayment = null;
        }

        if($request->input('dateExpiry') != ""){
            $dateExpiry = $request->input('dateExpiry');
            $convertedDateExpiry = Carbon::createFromFormat('d.m.Y.', $dateExpiry)->format('Y-m-d');
        }else{
            $convertedDateExpiry = null;
        }
        
        $client = Client::create([
            'firstName' => $request->input('firstName'),
            'lastName' => $request->input('lastName'),
            'email' => $request->input('email') ?? null,
            'gender' => $request->input('gender'),
            'phone' => $request->input('phone') ?? "",
            'dateOfBirth' => $convertedDateOfBirth,
            'status' => 'Aktivan'
        ]);
    
        if ($client) {
            $clientId = $client->id;
    
            $feeRecord = FeeRecords::create([
                'clientID' => $clientId,
                'dateOfPayment' => $convertedDateOfPayment,
                'dateExpiry' => $convertedDateExpiry,
                'membershipFee' => $request->input('membershipFee')
            ]);
    
            return response()->json(['message' => 'Klijent uspešno dodat'], 201);
        } else {
            return response()->json(['message' => 'Greška prilikom kreiranja klijenta'], 500);
        }
    }

    public function setMembershipFeeForClient($request, $id){
        
        $feeRecord = FeeRecords::where('clientID', $id)->first();

        if ($feeRecord) {
            $feeRecord->membershipFee = $request->membershipFeeRecord;
            $feeRecord->dateOfPayment = now();
            $feeRecord->dateExpiry = now()->addMonth();
            $feeRecord->save();

            return response()->json(['message' => 'Uspješno evidentirano'], 200);
        }else{
            return response()->json(['message' => 'Greška'], 500);
        }
    }

    public static function getClientReview($id){
        $clientData = self::leftJoin('feerecords', 'client.id', '=', 'feerecords.clientID')
        ->where('client.id', $id)
        ->select('client.*', 'feerecords.membershipFee as membershipFee', 'feerecords.dateOfPayment as dateOfPayment', 'feerecords.dateExpiry as dateExpiry')
        ->get();

        return $clientData;
    }
}
