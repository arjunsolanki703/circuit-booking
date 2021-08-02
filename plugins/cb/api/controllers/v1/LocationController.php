<?php

namespace Cb\Api\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Cb\Pgmware\Models\Location;
use Cb\Api\Transformers\V1\Location as LocationCollection;

class LocationController extends ApiController
{
    /**
     * @var Location
     */
    private $location;

    /**
     * LocationController constructor.
     *
     * @param Location $location
     */
    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    /**
     * get all location
     *
     * @return JsonResponse
     */
    public function index()
    {
        $location = $this->location->paginate(
            $this->limit()
        );

        return $this->respondWithPagination(
            $location,
            LocationCollection::collection($location)
        );
    }

    /**
     * create new location
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'country_id' => ['integer', 'required'],
                'company_id' => ['integer'],
                'timezone_id' => ['integer'],
                'user_id' => ['integer'],
                'address_id' => ['integer'],
                'name_short' => [],
                'name' => ['required','between:2,191'],
                'youtube_video_url' => [],
                'slug' => ['required','between:2,191'],
                'open_from' => [],
                'open_to' => [],
                'lunch_from' => [],
                'lunch_to' => [],
                'description' => [],
                'equipment' => [],
                'specials' => [],
                'gtc' => ['integer'],
                'dataprotection_info' => ['integer'],
                'module_file' => ['integer'],
                'facility_overview' => ['integer'],
                'facility_file' => ['integer'],
                'logo' => ['integer'],
                'noise' => ['integer'],
                'restaurant' => ['boolean'],
                'medical' => ['boolean'],
                'fuel' => ['boolean'],
                'featured' => ['boolean'],
            ]);
        } catch (ValidationException $exception) {
            return $this->respondWithError($exception->errors());
        }

        $location = $this->location->forceFill($data);

        $location->save();

        return $this->setItem(
            LocationCollection::make($location)
        )->responseCreated('location added');
    }

    /**
     * update location
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $location = $this->location->find($id);

        if (empty($location)) {
            return $this->responseNotFound('Not Found location');
        }

        try {
            $data = $request->validate([
                'country_id' => ['integer'],
                'company_id' => ['integer'],
                'timezone_id' => ['integer'],
                'user_id' => ['integer'],
                'address_id' => ['integer'],
                'name_short' => [],
                'name' => ['between:2,191'],
                'youtube_video_url' => [],
                'slug' => ['between:2,191'],
                'open_from' => [],
                'open_to' => [],
                'lunch_from' => [],
                'lunch_to' => [],
                'description' => [],
                'equipment' => [],
                'specials' => [],
                'gtc' => ['integer'],
                'dataprotection_info' => ['integer'],
                'module_file' => ['integer'],
                'facility_overview' => ['integer'],
                'facility_file' => ['integer'],
                'logo' => ['integer'],
                'noise' => ['integer'],
                'restaurant' => ['boolean'],
                'medical' => ['boolean'],
                'fuel' => ['boolean'],
                'featured' => ['boolean'],
            ]);
        } catch (ValidationException $exception) {
            return $this->respondWithError($exception->errors());
        }

        $location = $location->forceFill($data);

        $location->save();

        return $this->setItem(
            LocationCollection::make($location)
        )->responseUpdate('location updated');
    }

    /**
     * show location
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show($id)
    {
        $location = $this->location->find($id);

        if (empty($location)) {
            return $this->responseNotFound('Not Found location');
        }

        return $this->setItem(
            LocationCollection::make($location)
        )->respondAll();
    }

    /**
     * destroy location
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $location = $this->location->find($id);

        if (empty($location)) {
            return $this->responseNotFound('Not Found location');
        }

        $location->deleted_at = now();

        $location->save();

        return $this->responseDeteted('location deleted');
    }
}
