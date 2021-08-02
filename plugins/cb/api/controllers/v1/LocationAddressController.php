<?php

namespace Cb\Api\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Cb\Api\Transformers\V1\LocationAddress as LocationAddressCollection;
use Cb\Pgmware\Models\LocationAddress;

class LocationAddressController extends ApiController
{
    /**
     * @var LocationAddress
     */
    private $locationAddress;

    /**
     * LocationAddressController constructor.
     *
     * @param LocationAddress $locationAddress
     */
    public function __construct(LocationAddress $locationAddress)
    {
        $this->locationAddress = $locationAddress;
    }

    /**
     * get all locationAddress
     *
     * @return JsonResponse
     */
    public function index()
    {
        $locationAddress = $this->locationAddress->paginate(
            $this->limit()
        );

        return $this->respondWithPagination(
            $locationAddress,
            LocationAddressCollection::collection($locationAddress)
        );
    }

    /**
     * create new locationAddress
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'between:2,191'],
                'street' => ['required', 'between:1,191'],
                'additional' => ['required', 'between:0,191'],
                'zip' => ['required', 'max:20'],
                'city' => ['required', 'between:2,191'],
                'phone' => ['required', 'between:2,20'],
                'fax' => ['max:20'],
                'email' => ['email', 'max:191'],
                'web' => ['url', 'max:191'],
                'gps_lat' => ['required', 'numeric'],
                'gps_lon' => ['required', 'numeric'],
            ]);
        } catch (ValidationException $exception) {
            return $this->respondWithError($exception->errors());
        }

        $locationAddress = $this->locationAddress->forceFill($data);

        $locationAddress->save();

        return $this->setItem(
            LocationAddressCollection::make($locationAddress)
        )->responseCreated('location Address added');
    }

    /**
     * update locationAddress
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $locationAddress = $this->locationAddress->find($id);

        if (empty($locationAddress)) {
            return $this->responseNotFound('Not Found location Address');
        }

        try {
            $data = $request->validate([
                'name' => ['between:2,191'],
                'street' => ['between:1,191'],
                'additional' => ['between:0,191'],
                'zip' => ['max:20'],
                'city' => ['between:2,191'],
                'phone' => ['between:2,20'],
                'fax' => ['max:20'],
                'email' => ['email', 'max:191'],
                'web' => ['url', 'max:191'],
                'gps_lat' => ['numeric'],
                'gps_lon' => ['numeric'],
            ]);
        } catch (ValidationException $exception) {
            return $this->respondWithError($exception->errors());
        }

        if (!isset($data['email'])) {
            $data['email'] = '';
        }

        $locationAddress = $locationAddress->forceFill($data);

        $locationAddress->save();

        return $this->setItem(
            LocationAddressCollection::make($locationAddress)
        )->responseUpdate('location Address updated');
    }

    /**
     * show locationAddress
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show($id)
    {
        $locationAddress = $this->locationAddress->find($id);

        if (empty($locationAddress)) {
            return $this->responseNotFound('Not Found location Address');
        }

        return $this->setItem(
            LocationAddressCollection::make($locationAddress)
        )->respondAll();
    }

    /**
     * destroy locationAddress
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $locationAddress = $this->locationAddress->find($id);

        if (empty($locationAddress)) {
            return $this->responseNotFound('Not Found location Address');
        }

        $locationAddress = $locationAddress->forceFill([
            'deleted_at' => now(),
        ]);

        $locationAddress->save();

        return $this->responseDeteted('location Address deleted');
    }
}
