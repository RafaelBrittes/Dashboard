<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use League\Csv\Reader;

class ClientController extends Controller
{
    use ApiResponser;

    public function showClients()
    {
        return Client::all();
    }

    public function importClients()
    {
        $csv = Reader::createFromPath('../resources/customers.csv');
        $csv->setHeaderOffset(0);

        foreach ($csv as $csvRow) {
            //dd($csvRow);
            Client::create([
                'id' => $csvRow['id'],
                'first_name' => $csvRow['first_name'],
                'last_name' => $csvRow['last_name'],
                'email' => $csvRow['email'],
                'gender' => $csvRow['gender'],
                'ip_address' => $csvRow['ip_address'],
                'company' => $csvRow['company'],
                'city' => $csvRow['city'],
                'title' => $csvRow['title'],
                'website' => $csvRow['website;']
            ]);
        }
    }
}
