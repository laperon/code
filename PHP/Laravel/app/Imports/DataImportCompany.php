<?php

namespace App\Imports;

use App\Company;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;


class DataImportCompany implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $company = Company::create([
                'company' => 'test',
                'budget' => $row[1],
                'status' => $row[2],
                'views' => $row[3],
                'interactions' => $row[4],
                'views_interactions' => $row[5],
                'average_cost' => $row[6],
                'price' => $row[7],
                'average_cost_for_view' => $row[8],
                'average_cost_for_thousand_views' => $row[9],
                'average_cost_views_displays' => $row[10],
                'company_type' => $row[11],
                'average_price_for_click' => $row[12],
            ]);
        }
    }
}
