<?php namespace Cb\Car2db\Updates;

use Seeder;
use Cb\Car2db\lib\UpdateModel;
use cb\car2db\basebuyAutoApi\BasebuyAutoApi;
use cb\car2db\basebuyAutoApi\connectors\CurlGetConnector;
use cb\car2db\basebuyAutoApi\exceptions\EmptyResponseException;


class SeedByDownloadUpdatesModel extends Seeder
{
    public function run() {

        $uModel = new UpdateModel();
        $uModel->initialInsert();
    }
}