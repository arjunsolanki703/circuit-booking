<?php

namespace Cb\TabtrackDaysProfile\Components;

use Flash;
use Lang;
use Validator;
use ValidationException;
use ApplicationException;
use RainLab\User\Components\Account as UserAccount;
use Cb\Trackdaybooking\Models\Trackday;
use cb\pgmware\models\VehicleType;
use Responsiv\Currency\Models\Currency;
use cb\userplus\models\Company;
use System\Models\File;

class TrackDaysProfile extends UserAccount
{
    public function componentDetails()
    {
        return [
            'name' => 'TrackDaysProfile Component',
            'description' => '',
        ];
    }

    public function onRun()
    {
        parent::onRun();

        $user = $this->user();
        if (isset($user) && isset($user->id)) {
            $this->reloadTable();
        }

        $this->page['tempPath'] = temp_path();
        $this->page['mode'] = "";
    }


    public function getBaseModel()
    {
        $user = $this->user();

        if (empty($user->company)) {
            return;
        }

        return Trackday::where('company_id', $user->company->id)->whereNull('deleted_at');
    }

    private function reloadTable()
    {
        $this->page['mode'] = "";

        $this->page['trackDaysProfile'] = $this->getBaseModel()->get();
    }

    /*
     * ajax update bookble
     */
    public function onUpdateBookable()
    {
        $trackday = $this->getBaseModel()->where('id', post('id'))->first();

        if (empty($trackday)) {
            return;
        }

        $trackday->bookable = !$trackday->bookable;

        $trackday->save();

        $this->reloadTable();
    }

    /**
     * Edit TrackDays
     */
    public function onEditOrCreateTrackDays()
    {
        $item = $this->getBaseModel()->where('id', post('id'))->first();

        $this->page['item'] = $item;

        $this->page['vehicleTypes'] = VehicleType::all();

        $this->page['currencys'] = Currency::all();

        $this->page['companys'] = Company::all();

        $this->page['user'] =  $this->user();;

        $this->page['mode'] = empty(post('id')) ? 'add' : 'edit';
    }

    /**
     * view TrackDays
     */
    public function onViewTrackDays()
    {
        $item = $this->getBaseModel()->where('id', post('id'))->first();

        $this->page['item'] = $item;

        $this->page['mode'] = 'view';
    }

    /**
     * save data
     *
     * @throws \October\Rain\Exception\ValidationException
     */
    public function onTrackDaysSave()
    {
        $data = request()->only([
            'vehicle_type_id',
            'title',
            'description',
            'price',
            'currency_id',
            'vat_value',
        ]);

        $validation = \Illuminate\Support\Facades\Validator::make($data, [
            'vat_value' => 'required|between:0,2',
            'price' => ['required']
        ]);

        if ($validation->fails()) {
            throw new \October\Rain\Exception\ValidationException($validation);
        }

        $data['company_id'] = $this->user()->company->id;

        $data['bookable'] = request()->get('bookable', 0);

        if (post('id') == null) {
            $data['bookable'] = request()->has('bookable') ? 1 : 0;
            $trackday = (new Trackday())->forceFill($data);
            $trackday->save();
        } else {
            $trackday = $this->getBaseModel()->where('id', post('id'))->first();
            $trackday->forceFill($data)->save();
        }

        if (request()->hasFile('image')) {

            $img = $trackday->image;

            if (empty($img)) {
                $img = new File();

            }else{
                $img->delete();
                $img = new File();
            }


            $img->attachment_type = Trackday::class;
            $img->attachment_id = $trackday->id;
            $img->field = 'image';
            $img->fromPost(request()->file('image'));
            $img->save();

        }

        $this->reloadTable();
    }

    /**
     * delete
     */
    public function onDeleteTrackDays()
    {
        $trackday = $this->getBaseModel()->where('id', post('id'))->first();

        $trackday->forceFill(['deleted_at' => now()])->save();

        $this->reloadTable();
    }
}
