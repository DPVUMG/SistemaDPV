<?php

namespace App\Imports;

use App\Models\Municipio;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MunicipioImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $value) {
            if (!is_null($value)) {
                $municipality = new Municipio();
                $municipality->nombre = $value[1];
                $municipality->departamento_id = $value[2];
                $municipality->save();
                echo "{$municipality->nombre}" . PHP_EOL;
            }
        }
    }
}
