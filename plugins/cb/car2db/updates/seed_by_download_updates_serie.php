<?php namespace Cb\Car2db\Updates;

use Seeder;
use Cb\Car2db\lib\UpdateSerie;
use cb\car2db\basebuyAutoApi\BasebuyAutoApi;
use cb\car2db\basebuyAutoApi\connectors\CurlGetConnector;
use cb\car2db\basebuyAutoApi\exceptions\EmptyResponseException;


class SeedByDownloadUpdatesSerie extends Seeder
{
    public function run() {
        $uSerie = new UpdateSerie();
        $uSerie->initialInsert();
    }
}