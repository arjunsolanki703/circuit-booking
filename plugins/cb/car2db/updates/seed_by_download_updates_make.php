<?php namespace Cb\Car2db\Updates;

use Seeder;
use Cb\Car2db\lib\UpdateMake;
use cb\car2db\basebuyAutoApi\BasebuyAutoApi;
use cb\car2db\basebuyAutoApi\connectors\CurlGetConnector;
use cb\car2db\basebuyAutoApi\exceptions\EmptyResponseException;


class SeedByDownloadUpdatesMake extends Seeder
{
    public function run() {

        $uMake = new UpdateMake();
        $uMake->initialInsert();
    }
}