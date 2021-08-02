<?php


namespace Cb\Car2db\lib;
use Cb\Car2db\Models\Serie;

class UpdateSerie extends UpdateAbsModel
{
    public $modelName = "serie";
    public $typeId = 1;

    protected function insertDataLine($headerIndex, $dataSplit) {

        $generation = (($dataSplit[$headerIndex["id_car_generation"]] == null
            || $dataSplit[$headerIndex["id_car_generation"]] == 'NULL'
            || $dataSplit[$headerIndex["id_car_generation"]] == 'null')
            ? null :
            $dataSplit[$headerIndex["id_car_generation"]]);

        Serie::create([
            'id' => $dataSplit[$headerIndex["id_car_serie"]],
            'id_model' => $dataSplit[$headerIndex["id_car_model"]],
            'id_generation' => $generation,
            'name' => $dataSplit[$headerIndex["name"]],
            'created_at' => $dataSplit[$headerIndex["date_create"]],
            'updated_at' => $dataSplit[$headerIndex["date_update"]],
            'id_type' => $dataSplit[$headerIndex["id_car_type"]]
        ]);
    }
}