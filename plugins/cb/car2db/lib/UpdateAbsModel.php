<?php


namespace Cb\Car2db\lib;


use cb\car2db\basebuyAutoApi\exceptions\EmptyResponseException;
use Cb\Car2db\Models\LastUpdate;
use Curl\Curl;

define ("API_KEY", "s.herke@circuit-booking.com794990e32c0a2d7b1b2a087d7635b2c7");
define ("API_URL", "https://api.car2db.com/api/auto/v1/");
define ("DOWNLOAD_PATH", "/cb/car2db/");

abstract class UpdateAbsModel
{
    public $modelName = "make";
    public $typeId = 1;

    public function initialInsert()
    {
        $tempFolder = temp_path();
        $downloadFolder = $tempFolder . DOWNLOAD_PATH;

        if(!is_dir($downloadFolder)) {
            mkdir($downloadFolder, 0775, true);
        }

        $data = $this->getData($this->modelName, "getAll", "csv", "en", $this->typeId, API_KEY);
        $dataLine = explode("\n", $data);

        $header = $this->getHeaderIndex($dataLine[0]);
        $skip = true;
        foreach($dataLine as $line) {
            if($skip) {
                $skip = false;
                continue;
            }
            if(strlen($line) > 5) {

                $line = str_replace(",NULL,", ",'NULL',", $line);
                $line = str_replace(",NULL,", ",'NULL',", $line);
                $line = str_replace(",null,", ",'NULL',", $line);

                $dataSplit = explode("','", $line);

                foreach($dataSplit as &$item) {
                    $item = str_replace("'", "", $item);
                }

                $this->insertDataLine($header, $dataSplit);
            }
        }

        $date = $this->getData($this->modelName, "getDateUpdate", "timestamp", "en", $this->typeId, API_KEY);
        $this->setLastUpdate($date);

        // $downloadedFilePath = $downloadFolder . $this->modelName.".csv";
        // file_put_contents($downloadedFilePath, $data);
    }

    private function getHeaderIndex($headerLine) {
        $headerExp = explode(",", $headerLine);

        $arrHeader = array();
        $index = 0;
        foreach($headerExp as $h) {
            $h = str_replace("'", "", $h);
            $h = str_replace("\r", "", $h);
            $arrHeader[$h] = $index;
            $index++;
        }
        return $arrHeader;
    }

    protected abstract function insertDataLine($headerIndex, $dataLine);

    protected function setLastUpdate($timestamp) {

        LastUpdate::where('name', $this->modelName)
            ->update(['lastupdate' => $timestamp]);
    }

    protected function getData($entityName, $actionName, $format, $language, $id, $api_key,$timeout = 0) {
        $result = null;
        $curl = new Curl();
        $curl->setOpt(CURLOPT_TIMEOUT, $timeout);
        $buildUrl = "".API_URL.$entityName.".".$actionName.".".$format.".".$language."?id_type=".$id."&api_key=".$api_key;
        $curl->get($buildUrl);
        if ($curl->error) {
            echo "URL : " . $buildUrl;
            throw new EmptyResponseException( $curl->errorMessage,  $curl->errorCode );
        }
        else {
            $result = $curl->response;
        }

        $curl->close();
        return $result;
    }
}

/**
 * @author Mathias Kohs CB-2019
 */