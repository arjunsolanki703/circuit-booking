<?php

namespace Cb\Api\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Cb\Api\Transformers\V1\Variant as VariantCollection;
use Illuminate\Validation\ValidationException;
use Cb\Pgmware\Models\Variant;

class VariantController extends ApiController
{
    /**
     * @var Variant
     */
    private $variant;

    /**
     * variantController constructor.
     *
     * @param Variant $variant
     */
    public function __construct(Variant $variant)
    {
        $this->variant = $variant;

        unset($this->variant->rules['location']);
    }

    /**
     * get all variant
     *
     * @return JsonResponse
     */
    public function index()
    {
        $variant = $this->variant->paginate(
            $this->limit()
        );

        return $this->respondWithPagination(
            $variant,
            VariantCollection::collection($variant)
        );
    }

    /**
     * store Variant
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'location_id' => ['required', 'integer'],
                'variant_type_id' => ['integer', 'required'],
                'name' => ['required', 'max:191'],
                'cost_type' => ['max:45'],
                'cost_center' => ['max:45'],
                'color' => ['max:64'],
                'description' => ['required'],
                'sort_order' => ['integer', 'required'],
                'length' => ['integer'],
                'bookable' => [],
                'grade_deprecated' => [],
                'fia_grade_valid_before_date' => ['date_format:Y-m-d H:i:s'],
                'grade_id' => ['integer'],
            ]);
        } catch (ValidationException $exception) {
            return $this->respondWithError($exception->errors());
        }

        $variant = $this->variant->forceFill($data);

        $variant->save();

        return $this->setItem(
            VariantCollection::make($variant)
        )->responseUpdate('Variant added');
    }

    /**
     * update Variant
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $variant = $this->variant->find($id);

        if (empty($variant)) {
            return $this->responseNotFound('Not Found Variant');
        }

        try {
            $data = $request->validate([
                'location_id' => ['integer'],
                'variant_type_id' => ['integer'],
                'name' => ['max:191'],
                'cost_type' => ['max:45'],
                'cost_center' => ['max:45'],
                'color' => ['max:64'],
                'description' => [],
                'sort_order' => ['integer'],
                'length' => ['integer'],
                'bookable' => [],
                'grade_deprecated' => [],
                'fia_grade_valid_before_date' => ['date_format:Y-m-d H:i:s'],
                'grade_id' => ['integer'],
            ]);
        } catch (ValidationException $exception) {
            return $this->respondWithError($exception->errors());
        }

        $variant = $variant->forceFill($data);

        $variant->save();

        return $this->setItem(
            VariantCollection::make($variant)
        )->responseUpdate('Variant updated');
    }

    /**
     * show Variant
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show($id)
    {
        $variant = $this->variant->find($id);

        if (empty($variant)) {
            return $this->responseNotFound('Not Found Variant');
        }

        return $this->setItem(
            VariantCollection::make($variant)
        )->respondAll();
    }

    /**
     * destroy Variant
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $variant = $this->variant->find($id);

        if (empty($variant)) {
            return $this->responseNotFound('Not Found variant');
        }

        $variant->deleted_at = now();

        $variant->save();

        return $this->responseDeteted('Variant deleted');
    }
}
