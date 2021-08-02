<?php


namespace Cb\Car2db\lib;
use Cb\Car2db\Models\Generation;

class UpdateGeneration extends UpdateAbsModel
{
    public $modelName = "generation";
    public $typeId = 1;

    protected function insertDataLine($headerIndex, $dataSplit) {

        Generation::create([
            'id' => $dataSplit[$headerIndex["id_car_generation"]],
            'id_model' => $dataSplit[$headerIndex["id_car_model"]],
            'name' => $dataSplit[$headerIndex["name"]],
            'year_begin' => $dataSplit[$headerIndex["year_begin"]],
            'year_end' => $dataSplit[$headerIndex["year_end"]],
            'created_at' => $dataSplit[$headerIndex["date_create"]],
            'updated_at' => $dataSplit[$headerIndex["date_update"]],
            'id_type' => $dataSplit[$headerIndex["id_car_type"]]
        ]);
    }
}