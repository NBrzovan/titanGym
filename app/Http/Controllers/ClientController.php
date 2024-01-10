<?php

namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clientsData = Client::getAllClients();

        return response()->json($clientsData);
    }

    public function show($id)
    {
        $client = Client::getClient($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        return response()->json($client);
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
}
