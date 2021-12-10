<?php

namespace App\Exports;

use App\Models\import;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

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
        return new Collection([
            [1, 2, 3],
            [4, 5, 6]
        ]);
    }
    // public function collection()
    // {
    //     return import::all();
    //     // return collect(import::getImport());
    // }
}
