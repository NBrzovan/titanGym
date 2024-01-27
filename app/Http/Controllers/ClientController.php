<?php

namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {   
        $searchQuery = $request->input('search');
        $clientsData = Client::getAllClients($searchQuery);
        
        return response()->json($clientsData);
    }

    public function show($id)
    {
        $client = Client::getClient($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        return response()->json($client->toArray());
    }

    public function update(Request $request, $id)
    {
    
        $client = Client::updateClient($id, $request->all());

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        return response()->json($client);
    }

    public function destroy($id)
    {
        $result = Client::deleteClient($id);

        if (!$result) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        return response()->json(['message' => 'Client successfully deleted']);
    }

    public function store(Request $request)
    {
        $client = Client::addClient($request);
    }

    public function clientMembershipFee(Request $request, $id) {
        
        $membershipFee = Client::setMembershipFeeForClient($request, $id);
        
    }
}
