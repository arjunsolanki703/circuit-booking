<?php namespace Cb\Car2db\Updates;

use Seeder;
use Cb\Car2db\lib\UpdateGeneration;
use cb\car2db\basebuyAutoApi\BasebuyAutoApi;
use cb\car2db\basebuyAutoApi\connectors\CurlGetConnector;
use cb\car2db\basebuyAutoApi\exceptions\EmptyResponseException;


class SeedByDownloadUpdatesGeneration extends Seeder
{
    public function run() {

        $uGern = new UpdateGeneration();
        $uGern->initialInsert();
    }
}