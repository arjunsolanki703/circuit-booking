<?php namespace Cb\Trackdaybooking\Components;

use Cb\Booking\Models\BookingParticipant;
use Cb\Booking\Models\BookingParticipantBooking;
use Cb\Pgmware\Components\StripeBinding;
use Cb\Trackdaybooking\Models\ParticipantDetails;
use Tinify\Exception;
use Validator;
use Flash;
use ValidationException;
use Request;
use DB;
use App;
use Cb\Car2db\Models\Make as MakeModel;
use Cb\Car2db\Models\Model as CarModel;
use Cb\Car2db\Models\Serie;
use Cb\Car2db\Models\Trim;
use Cb\Trackdaybooking\Models\Trackday;
use Cb\Trackdaybooking\Models\OrderTrackday;
use Cms\Classes\ComponentBase;
use Cb\Car2db\Components\ProfilMyVehicle;
use Cb\userplus\Models\Company;
use RainLab\Location\Models\Country;


class BookingProzess extends ProfilMyVehicle
{
    private static $TYPEQUEST = "guest";
    private static $TYPEUSER = "user";

    private $user;

    protected $contectInfoRules = [
        'gender' => 'required|in:female,male,unknown',
        'email' => 'required|email|between:6,255',
        'name' => 'required|between:2,255',
        'surname' => 'required|between:2,100',
        'street' => 'required|between:2,200',
        'zip' => 'required|between:3,100',
        'city' => 'required|between:2,200',
        'phone' => 'required|between:2,100',
        'country_id' => 'required|between:1,100',
    ];

    protected $vehiclesRules = [
        'make' => 'required|between:1,255',
        'model' => 'required|between:1,255',
        'serie' => 'required|between:1,255',
        'trim' => 'required|between:1,255',
        'licenseplate' => 'required|between:1,255',
    ];

    protected $agbRules = [
        'agreetcb' => 'required|accepted',
        'agreetdo' => 'required|accepted',
    ];

    public function componentDetails()
    {
        return [
            'name'        => 'bookingProzess Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function onRun()
    {
        parent::onRun();

        $this->page['makeList'] = parent::getMyMakeModel();
        $this->page['modelList'] = null;
        $this->page['serieList'] = null;
        $this->page['tempPath'] = temp_path();
        $this->page['mode'] = "";
        $this->page['countriesList'] = Country::getNameList();

        $user = parent::user();
        $this->user = $user;

        if(isset($user) && isset($user->id)) {
            $this->page['profiltype'] = self::$TYPEUSER;
            $this->page['company'] = Company::where("user_id", $user->id)->first();
        }
        else {
            $this->page['profiltype'] = self::$TYPEQUEST;
            $this->page['company'] = new \stdClass();
        }

        $this->page['user'] = $user;

        $slug = $this->property('slug');
        $this->getOrderTrackday($slug);
        $this->page['slug'] = $slug;
    }

    public function onSelectProfilType () {
        $post = post();
        if(isset($post["profiltype"])) {
            $this->page['profiltype'] = $post["profiltype"];

            $user = parent::user();
            if(isset($user) && $post["profiltype"] == self::$TYPEUSER) {
                $this->page['preuserdata'] = $user;
                $this->page['company'] = Company::where("user_id", $user->id)->first();
            }
            else {
                $this->page['preuserdata'] = new \stdClass();
                $this->page['company'] = new \stdClass();
            }
        }
        else {
            $this->page['profiltype'] = self::$TYPEQUEST;
        }
        $this->page['countriesList'] = Country::getNameList();
    }

    public function saveContactInfo() {
        $post = post();
        $this->page['makeList'] = parent::getMyMakeModel();

        $userdata = new \stdClass();
        $userdata->gender = isset($post["gender"]) ? $post["gender"] : "k.a.";
        $userdata->email = isset($post["email"]) ? $post["email"] : "k.a.";
        $userdata->name = isset($post["name"]) ? $post["name"] : "k.a.";
        $userdata->surname = isset($post["surname"]) ? $post["surname"] : "k.a.";
        $userdata->street = isset($post["street"]) ? $post["street"] : "k.a.";
        $userdata->zip = isset($post["zip"]) ? $post["zip"] : "k.a.";
        $userdata->city = isset($post["city"]) ? $post["city"] : "k.a.";
        $userdata->phone = isset($post["phone"]) ? $post["phone"] : "k.a.";
        $userdata->country_id = isset($post["country_id"]) ? $post["country_id"] : "k.a.";
        if(isset($post["country_id"])) {
            $userdata->country_id = $post["country_id"];
            $c = Country::find($post["country_id"]);
            $userdata->countryname = isset($c->name) ? $c->name : "k.a.";
        }
        else {
            $userdata->country_id = 0;
            $userdata->countryname = "k.a.";
        }
        $this->page['userdata'] = $userdata;
    }

    public function onSaveContactInfo()
    {
        try {
            $data = post();
            $rules = $this->contectInfoRules;
            $validation = Validator::make($data, $rules);
            if ($validation->fails()) {
                throw new ValidationException($validation);
            }
            $this->saveContactInfo();
        }
        catch (Exception $ex) {
            if (Request::ajax()) throw $ex;
            else Flash::error($ex->getMessage());
        }
    }

    public function onSaveVehilceInfo() {
        try {
            $data = post();
            $rules = $this->vehiclesRules;
            $validation = Validator::make($data, $rules);
            if ($validation->fails()) {
                throw new ValidationException($validation);
            }
            $this->saveVehilceInfo();
        }
        catch (Exception $ex) {
            if (Request::ajax()) throw $ex;
            else Flash::error($ex->getMessage());
        }
    }

    public function saveVehilceInfo() {
        $this->saveContactInfo();
        $post = post();
        $vehicledata = new \stdClass();
        $vehicledata->licenseplate = isset($post["licenseplate"]) ? $post["licenseplate"] : "k.a.";

        if(isset($post["make"])) {
            $vehicledata->make = $post["make"];
            $model = MakeModel::find($post["make"]);
            $vehicledata->makename = isset($model->name) ? $model->name : "k.a.";
        }
        else {
            $vehicledata->make = 0;
            $vehicledata->makename = "k.a.";
        }

        if(isset($post["model"])) {
            $vehicledata->model = $post["model"];
            $model = CarModel::find($post["model"]);
            $vehicledata->modelname = isset($model->name) ? $model->name : "k.a.";
        }
        else {
            $vehicledata->model = 0;
            $vehicledata->modelname = "k.a.";
        }

        if(isset($post["trim"])) {
            $vehicledata->trim = $post["trim"];
        }


        $this->page['vehicledata'] = $vehicledata;
    }

    public function getOrderTrackday($id) {
        $item = OrderTrackday::where('id', $id)->first();
        $this->page['trackday'] = $item;

        $td = Trackday::where('id', $item->trackday_id)->first();
        $this->page['trackdaytrackday'] = $td;
    }

    public function onSaveDataComplete() {

        $slug = $this->property('slug');

        try {
            $data = post();
            $data["address"] = isset($data["street"]) ? $data["street"] : $data["address"];
            $data["trim_id"] = isset($data["trim"]) ? $data["trim"] : $data["trim_id"];

            //throws Exceptions if bad inserts
            $this->feldValidationDataComplete($data);

            Db::beginTransaction();

            $participant = BookingParticipant::create($data);
            $partData = array();
            $partData["trim_id"] = $data["trim_id"];
            $partData["licenseplate"] = $data["licenseplate"];
            $partData["id"] = $participant->id;
            $particiDatail = ParticipantDetails::create($partData);

            //TODO SONDERFALL MVP One booking to one ordertrackday
            $booking = DB::select('select cb_booking_bookings.id FROM cb_booking_bookings INNER JOIN cb_trackdaybooking_order_trackdays ON cb_booking_bookings.id = cb_trackdaybooking_order_trackdays.booking_id WHERE cb_trackdaybooking_order_trackdays.id = :slug;', ['slug' => $slug]);
            $participant_types = DB::select('select id FROM cb_booking_participant_types where name = "cb_trackdaybooking_trackdayteilnehmer"');

            $bpb = array();
            $bpb["booking_id"] = $booking[0]->id;;
            $bpb["booking_participant_id"] = $participant->id;
            $bpb["participant_type_id"] = $participant_types[0]->id;
            //TODO SONDERFALL MVP hier muss ein neuer status her
            $bpb["booking_status_id"] = 1;

            if($this->checkIfBookingIsFree($slug, $booking[0]->id)) {
                $bpbmodel = BookingParticipantBooking::create($bpb);

                if(isset($bpbmodel) && isset($bpbmodel->id)) {
                    Db::commit();
                    return $this->onBookWithStripe($slug);
                }
                else {
                    Db::rollBack();
                    App::abort(423);
                }
            }
            else {
                //HTTP-Code Locked for there are no free space anymore
                Db::rollBack();
                App::abort(423);
            }
        }
        catch (Exception $ex) {
            if (Request::ajax()) throw $ex;
            else Flash::error($ex->getMessage());
        }
    }

    protected function feldValidationDataComplete($data)  {
        $rules = (new BookingParticipant())->modelRules;
        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            throw new ValidationException($validation);
        }

        $detailRules = (new ParticipantDetails())->modelRules;
        $detailValidation = Validator::make($data, $detailRules);
        if ($detailValidation->fails()) {
            throw new ValidationException($detailValidation);
        }

        $validationAgb = Validator::make($data, $this->agbRules);
        if ($validationAgb->fails()) {
            throw new ValidationException($validationAgb);
        }
    }

    protected function checkIfBookingIsFree($orderTrackayId, $bookingId) {
        //TODO SONDERFALL MVP One booking to one ordertrackday hier muss die Berechung vereiheitlicht werden
        $rawCapa = DB::select("SELECT * FROM cb_trackdaybooking_trackday_capacities WHERE order_trackday_id = :id ORDER BY updated_at DESC", ["id" => $orderTrackayId]);

        if(!isset($rawCapa) || !isset($rawCapa[0]) || !isset($rawCapa[0]->amount)) {
            return false;
        }

        $rawCount = DB::select("SELECT COUNT(id) AS anz from cb_booking_booking_participant_bookings WHERE booking_id = :id;", ["id" => $bookingId]);

        if(!isset($rawCount) || !isset($rawCount[0]) || !isset($rawCount[0]->anz)) {
            return false;
        }

        if($rawCapa[0]->amount > $rawCount[0]->anz) {
            return true;
        }
        return false;
    }

    protected function onBookWithStripe($orderTrackdayId) {
        $orderTrackday = OrderTrackday::where('id', $orderTrackdayId)->first();
        // TODO UserId abgleich machen!
        $dummyUserId = 4;
        return StripeBinding::onBookStripeWithUser($orderTrackday->title, $orderTrackday->description, $orderTrackday->price*100, $dummyUserId);
    }
}
