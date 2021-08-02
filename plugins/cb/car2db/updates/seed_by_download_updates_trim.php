<?php namespace Cb\Car2db\Updates;

use Seeder;
use Cb\Car2db\lib\UpdateTrim;
use cb\car2db\basebuyAutoApi\BasebuyAutoApi;
use cb\car2db\basebuyAutoApi\connectors\CurlGetConnector;
use cb\car2db\basebuyAutoApi\exceptions\EmptyResponseException;


class SeedByDownloadUpdatesTrim extends Seeder
{
    public function run() {
        $uTrim = new UpdateTrim();
        $uTrim->initialInsert();
    }
}