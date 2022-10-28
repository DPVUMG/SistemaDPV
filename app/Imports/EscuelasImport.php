<?php

namespace App\Imports;

use App\Models\Departamental;
use App\Models\Departamento;
use App\Models\Director;
use App\Models\Distrito;
use App\Models\Escuela;
use App\Models\EscuelaCodigo;
use App\Models\EscuelaCodigoAlumno;
use App\Models\EscuelaSupervisor;
use App\Models\EscuelaUsuario;
use App\Models\Municipio;
use App\Models\Nivel;
use App\Models\Supervisor;
use App\Models\Usuario;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class EscuelasImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $value) {
            if ($key > 1 && $key < 52) {
                $mensaje = "";
                if (!is_null($value[0])) {

                    $nombre = is_null($value[16]) ? "NA" : ucfirst($value[16]);

                    $departamental = Departamental::firstOrCreate(
                        ['nombre' => $nombre],
                        ['nombre' => $nombre]
                    );

                    $mensaje .= "Departamental: {$departamental->nombre}";

                    $codigo = is_null($value[1]) ? "01-" : $value[1];

                    $distrito = Distrito::firstOrCreate(
                        ['codigo' => $codigo],
                        ['codigo' => $codigo]
                    );

                    $mensaje .= " - Distrito: {$distrito->codigo}";

                    $escuela = Escuela::where('establecimiento', $value[4])
                        ->where('jornada', $value[14])
                        ->where('plan', $value[15])
                        ->first();

                    if (is_null($escuela)) {
                        $escuela = Escuela::firstOrCreate(
                            [
                                'establecimiento' => $value[4],
                                'direccion' => $value[5],
                                'telefono' => $value[6],
                                'sector' => $value[10],
                                'area' => $value[11],
                                'jornada' => $value[14],
                                'plan' => $value[15],
                                'distrito_id' => $distrito->id,
                                'departamental_id' => $departamental->id,
                                'departamento_id' => Departamento::where("nombre", $value[2])->first()->id,
                                'municipio_id' => Municipio::where("nombre", $value[3])->first()->id,
                                'usuario_id' => Usuario::all()->random()->first()->id,
                                'activo' => true
                            ],
                            ['establecimiento' => $value[4]]
                        );
                    }

                    $mensaje .= " - Escuela: {$escuela->establecimiento}";

                    $codigo = explode("-", $value[0]);
                    $nivel = Nivel::firstOrCreate(
                        ['nombre' => $value[9], 'codigo' => $codigo[3]],
                        ['codigo' => $codigo[3]]
                    );

                    $mensaje .= " - Nivel: {$nivel->nombre} | {$nivel->codigo}";

                    $escuela_codigo = EscuelaCodigo::create([
                        'codigo' => $value[0],
                        'escuela_id' => $escuela->id,
                        'nivel_id' => $nivel->id,
                        'usuario_id' => $escuela->usuario_id,
                    ]);

                    $mensaje .= " - Código: {$escuela_codigo->codigo}";

                    $eliminar_caracteres_director = str_replace("-", "", $value[8]);
                    if (!is_null($eliminar_caracteres_director) && $eliminar_caracteres_director != "") {
                        $director = Director::create([
                            'nombre' => $value[8],
                            'escuela_id' => $escuela->id,
                            'usuario_id' => $escuela->usuario_id,
                        ]);

                        $mensaje .= " - Director: {$director->nombre}";
                    }

                    EscuelaCodigoAlumno::create([
                        'cantidad_alumno' => 0,
                        'escuela_codigo_id' => $escuela_codigo->id,
                        'escuela_id' => $escuela->id,
                        'nivel_id' => $nivel->id,
                        'usuario_id' => $escuela->usuario_id,
                    ]);

                    if (!is_null($value[7])) {

                        $nombre = ucwords($value[7]);

                        $supervisor = Supervisor::firstOrCreate(
                            ['nombre' => $nombre, 'distrito_id' => $distrito->id],
                            ['nombre' => $nombre]
                        );

                        EscuelaSupervisor::create([
                            'escuela_id' => $escuela->id,
                            'distrito_id' => $distrito->id,
                            'supervisor_id' => $supervisor->id,
                            'usuario_id' => $escuela->usuario_id
                        ]);

                        $mensaje .= " - Supervisor: {$supervisor->nombre}";
                    }

                    EscuelaUsuario::create([
                        'password' => 'admin',
                        'usuario' => $escuela_codigo->codigo,
                        'persona_id' => random_int(1, 25),
                        'escuela_id' => $escuela->id,
                        'usuario_id' => $escuela->usuario_id
                    ]);

                    echo $mensaje . PHP_EOL;
                }
            }
        }
    }
}
