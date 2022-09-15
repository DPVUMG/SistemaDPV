<?php

namespace App\Imports;

use App\Models\Departamento;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DepartamentoImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $value) {
            if (!is_null($value)) {
                $deparamento = new Departamento();
                $deparamento->nombre = $value[0];
                $deparamento->save();
                echo "{$deparamento->nombre}" . PHP_EOL;
            }
        }
    }
}
