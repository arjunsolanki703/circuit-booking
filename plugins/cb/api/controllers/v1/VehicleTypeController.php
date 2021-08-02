<?php

namespace Cb\Api\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Cb\Api\Transformers\V1\VehicleType as VehicleTypeCollection;
use Illuminate\Validation\ValidationException;
use Cb\Pgmware\Models\VehicleType;

class VehicleTypeController extends ApiController
{
    /**
     * @var VehicleType
     */
    private $vehicleType;

    /**
     * vehicleTypeController constructor.
     *
     * @param VehicleType $vehicleType
     */
    public function __construct(VehicleType $vehicleType)
    {
        $this->vehicleType = $vehicleType;
    }

    /**
     * get all vehicleType
     *
     * @return JsonResponse
     */
    public function index()
    {
        $vehicleType = $this->vehicleType->paginate(
            $this->limit()
        );

        return $this->respondWithPagination(
            $vehicleType,
            VehicleTypeCollection::collection($vehicleType)
        );
    }

    /**
     * store VehicleType
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => ['required','between:2,191'],
                'icon' => ['max:64'],
                'order' => ['integer', 'max:64'],
            ]);
        } catch (ValidationException $exception) {
            return $this->respondWithError($exception->errors());
        }

        $vehicleType = $this->vehicleType->create($data);

        return $this->setItem(
            VehicleTypeCollection::make($vehicleType)
        )->responseUpdate('VehicleType added');
    }

    /**
     * update VehicleType
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $vehicleType = $this->vehicleType->find($id);

        if (empty($vehicleType)) {
            return $this->responseNotFound('Not Found VehicleType');
        }

        try {
            $data = $request->validate([
                'name' => ['between:2,191'],
                'icon' => ['max:64'],
                'order' => ['integer', 'max:64'],
            ]);
        } catch (ValidationException $exception) {
            return $this->respondWithError($exception->errors());
        }

        $vehicleType->update($data);

        return $this->setItem(
            VehicleTypeCollection::make($vehicleType)
        )->responseUpdate('VehicleType updated');
    }

    /**
     * show VehicleType
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show($id)
    {
        $vehicleType = $this->vehicleType->find($id);

        if (empty($vehicleType)) {
            return $this->responseNotFound('Not Found VehicleType');
        }

        return $this->setItem(
            VehicleTypeCollection::make($vehicleType)
        )->respondAll();
    }

    /**
     * destroy VehicleType
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $vehicleType = $this->vehicleType->find($id);

        if (empty($vehicleType)) {
            return $this->responseNotFound('Not Found vehicleType');
        }

        $vehicleType->deleted_at = now();

        $vehicleType->save();

        return $this->responseDeteted('VehicleType deleted');
    }
}
