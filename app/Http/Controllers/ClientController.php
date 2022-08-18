<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Traits\ApiResponser;
use League\Csv\Reader;
use Illuminate\Support\Facades\Validator;

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
            $clientsToAdd[] = [
                'id' => $csvRow['id'],
                'first_name' => $csvRow['first_name'],
                'last_name' => $csvRow['last_name'],
                'email' => $csvRow['email'],
                'gender' => $csvRow['gender'],
                'ip_address' => $csvRow['ip_address'],
                'company' => $csvRow['company'],
                'city' => $csvRow['city'],
                'title' => $csvRow['title'],
                'website' => ($csvRow['website;'] == ';') ? "" : $csvRow['website;']
            ];

            if (count($clientsToAdd) == 500) {
                Client::insert($clientsToAdd);
                $clientsToAdd = [];
            }
        }

        return $this->success("Clients added with success!");
    }

    public function getClientsInfo()
    {
        $withoutLastName = count(Client::where('last_name', '=', '')->get());
        $withoutGender = count(Client::where('gender', '=', '')->get());
        $emails = Client::pluck('email');
        $invalidEmails = 0;
        $validEmails = count($emails);

        foreach ($emails as $email) {
            $data = ['email' => $email];
            $rules = ['email' => 'required|email'];
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                $invalidEmails++;
                $validEmails--;
            }
        }
        return ([
            'Without last name' => $withoutLastName,
            'Without gender' => $withoutGender,
            'Valid emails' => $validEmails,
            'Invalid emails' => $invalidEmails
        ]);
    }
}
