<?php


namespace Cb\Car2db\lib;
use Cb\Car2db\Models\Trim;

class UpdateTrim extends UpdateAbsModel
{
    public $modelName = "trim";
    public $typeId = 1;

    protected function insertDataLine($headerIndex, $dataSplit) {

        Trim::create([
            'id' => $dataSplit[$headerIndex["id_car_trim"]],
            'id_serie' => $dataSplit[$headerIndex["id_car_serie"]],
            'id_model' => $dataSplit[$headerIndex["id_car_model"]],
            'name' => $dataSplit[$headerIndex["name"]],
            'start_production_year' => $dataSplit[$headerIndex["start_production_year"]],
            'end_production_year' => $dataSplit[$headerIndex["end_production_year"]],
            'created_at' => $dataSplit[$headerIndex["date_create"]],
            'updated_at' => $dataSplit[$headerIndex["date_update"]],
            'id_type' => $dataSplit[$headerIndex["id_car_type"]]
        ]);
    }
}