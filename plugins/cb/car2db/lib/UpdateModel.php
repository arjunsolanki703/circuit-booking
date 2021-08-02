<?php


namespace Cb\Car2db\lib;
use Cb\Car2db\Models\Model;

class UpdateModel extends UpdateAbsModel
{
    public $modelName = "model";
    public $typeId = 1;

    protected function insertDataLine($headerIndex, $dataSplit) {

        Model::create([
            'id' => $dataSplit[$headerIndex["id_car_model"]],
            'id_make' => $dataSplit[$headerIndex["id_car_make"]],
            'name' => $dataSplit[$headerIndex["name"]],
            'created_at' => $dataSplit[$headerIndex["date_create"]],
            'updated_at' => $dataSplit[$headerIndex["date_update"]],
            'id_type' => $dataSplit[$headerIndex["id_car_type"]]
        ]);
    }
}