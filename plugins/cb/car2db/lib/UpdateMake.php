<?php


namespace Cb\Car2db\lib;
use Cb\Car2db\Models\Make;

class UpdateMake extends UpdateAbsModel
{
    public $modelName = "make";
    public $typeId = 1;

    protected function insertDataLine($headerIndex, $dataSplit) {

        Make::create([
            'id' => $dataSplit[$headerIndex["id_car_make"]],
            'name' => $dataSplit[$headerIndex["name"]],
            'created_at' => $dataSplit[$headerIndex["date_create"]],
            'updated_at' => $dataSplit[$headerIndex["date_update"]],
            'id_type' => $dataSplit[$headerIndex["id_car_type"]]
        ]);
    }
}