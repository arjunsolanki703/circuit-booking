<?php namespace Cb\Car2db\Components;

use Flash;
use Lang;
use Validator;
use ValidationException;
use ApplicationException;
use Cb\Car2db\Models\Make;
use Cb\Car2db\Models\Make as MakeModel;
use Cb\Car2db\Models\Model as CarModel;
use Cb\Car2db\Models\Serie;
use Cb\Car2db\Models\Trim;
use Cb\Car2db\Models\UserVehicle as UserVehicleModel;
use Cms\Classes\ComponentBase;
use RainLab\User\Components\Account as UserAccount;

class ProfilMyVehicle extends UserAccount
{
    public function componentDetails()
    {
        return [
            'name'        => 'ProfilMyVehicle Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function onRun()
    {
        parent::onRun();

        $user = $this->user();
        if(isset($user) && isset($user->id)) {
            $this->reloadVehicleTable();
        }

        $this->page['makeList'] = $this->getMyMakeModel();
        $this->page['modelList'] = null;
        $this->page['serieList'] = null;
        $this->page['tempPath'] = temp_path();
        $this->page['mode'] = "";
    }

    public function getMyMakeModel() {
        return MakeModel::where('cb_car2db_models.id_type', 1)
            ->join('cb_car2db_models', 'cb_car2db_makes.id', '=', 'cb_car2db_models.id_make')
            ->join('cb_car2db_series', 'cb_car2db_models.id', '=', 'cb_car2db_series.id_model')
            ->join('cb_car2db_trims', 'cb_car2db_series.id', '=', 'cb_car2db_trims.id_serie')
            ->orderBy('name')->groupBy('id')->select('cb_car2db_makes.*')->get();
    }

    public function onRefreshMake() {
        $item = new \stdClass();
        $post = post();
        if(isset($post["make"]))
        {
            $item->make = $post["make"];
            $carMo = CarModel::where('id_make', $item->make)
                ->join('cb_car2db_series', 'cb_car2db_models.id', '=', 'cb_car2db_series.id_model')
                ->join('cb_car2db_trims', 'cb_car2db_series.id', '=', 'cb_car2db_trims.id_serie')
                ->groupBy('id')
                ->select('cb_car2db_models.*')->get();
            $this->page['modelList'] = $carMo;
        }

        $this->page['car'] = $item;
    }

    public function onRefreshModel() {
        $item = new \stdClass();
        $post = post();
        if(isset($post["model"]))
        {
            $item->model = $post["model"];
            $serieList = Serie::where("cb_car2db_series.id_model", $item->model)
                ->leftjoin("cb_car2db_generations", "id_generation", "=", "cb_car2db_generations.id")
                ->select("cb_car2db_series.*", "cb_car2db_generations.name as gname")
                ->orderBy('name')
                ->get();
            $this->page['serieList'] = $serieList;
        }

        $this->page['car'] = $item;
    }

    public function onRefreshSerie() {
        $item = new \stdClass();
        $post = post();
        if(isset($post["serie"]))
        {
            $item->serie = $post["serie"];
            $List = Trim::where("id_serie", $item->serie)->get();
            $this->page['trimList'] = $List;
        }

        $this->page['car'] = $item;
    }

    public function onVehicleAdd() {
        $post = post();

        $item = new UserVehicleModel();
        $item->trim_id = $post["trim"];
        $item->licenseplate = $post["licenseplate"];
        $user = $this->user();
        $item->user_id = $user->id;
        $item->save();
        $this->reloadVehicleTable();
        $this->page['mode'] = "";
    }

    public function onDeleteVehicle() {
        //$this->page['userVehicles']
        $post = post();
        UserVehicleModel::find($post["id"])->delete();
        $this->reloadVehicleTable();
    }

    public function onStartTable() {
        $this->page['mode'] = "";
        $user = $this->user();
        if(isset($user) && isset($user->id)) {
            $this->reloadVehicleTable();
        }
    }

    //Starts the Add View
    public function onStartAddVehicle() {
        $this->page['makeList'] = MakeModel::where('id_type', 1)->get();//::lists('id', 'name');
        $this->page['modelList'] = null;
        $this->page['serieList'] = null;
        $this->page['mode'] = "add";
    }

    //Starts the Edit View
    public function onEditVehicle() {
        $user = $this->user();
        $post = post();
        $item = UserVehicleModel::where('id', $post['id'])->where('user_id', $user->id)->first();
        $this->page['item'] = $item;
        $this->page['mode'] = "edit";
    }

    //Saves the Edit
    public function onVehicleEdit() {
        $user = $this->user();
        $post = post();
        $item = UserVehicleModel::where('id', $post['id'])->where('user_id', $user->id)->first();
        $item->licenseplate = $post["licenseplate"];
        $item->save();

        $this->reloadVehicleTable();
    }

    private function reloadVehicleTable() {
        $this->page['mode'] = "";
        $user = $this->user();
        $vehicles = UserVehicleModel::where('user_id', $user->id)->get();
        $this->page['userVehicles'] = $vehicles;
    }
}
