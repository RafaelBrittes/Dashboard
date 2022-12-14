<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    use ApiResponser;

    public function showClients(Request $request)
    {
        $pageSize = $request->page_size ?? 6;
        return Client::query()->paginate($pageSize);
    }

    public function importClients(Request $request)
    {
        $csv = Reader::createFromPath($request->file('csv_file')->getRealPath());
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
            'without_last_name' => $withoutLastName,
            'without_gender' => $withoutGender,
            'valid_emails' => $validEmails,
            'invalid_emails' => $invalidEmails
        ]);
    }

    public function donwloadCsvFile()
    {
        $path = Storage::disk('public')->path("customers.csv");
        $content = file_get_contents($path);
        return response($content)->withHeaders([
            'Content-Type' => mime_content_type($path)
        ]);
    }
}
