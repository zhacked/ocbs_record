<?php

namespace App\Exports;

use App\Models\import;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class importExport implements FromCollection,withHeadings
{

    public function headings():array {
        return [
            'id',
            'Name',
            'Amount'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return import::all();
        return collect(import::getImport());
    }
}
