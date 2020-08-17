<?php

namespace App\Imports;

use App\Group;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;


class DataImportGroup implements ToCollection
{

    public function collection(Collection $rows)
    {
        // dd($rows);
        foreach ($rows as $row)
        {
            $company = Group::create([
                'announcement_group_status' => $row[0],
                'announcement_group' => $row[1],
                'status' => $row[2],
                'currency_code' => $row[3],
                'max_price_per_view' => $row[4],
                'views' => $row[5],
                'currency_code2' => $row[6],
                'average_price_per_viewer' => $row[7],
                'ad_group_type' => $row[8],
                'shows' => $row[9],
                'coff_views' => $row[10],
                'cost' => $row[11],
                'additional_views' => $row[12],
                'conversions' => $row[13],
                'cost_conversion' => $row[14],
                'conversion_coeff' => $row[15]
            ]);
        }
    }
}
