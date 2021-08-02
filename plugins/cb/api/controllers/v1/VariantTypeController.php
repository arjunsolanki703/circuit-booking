<?php

namespace Cb\Api\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Cb\Api\Transformers\V1\VariantType as VariantTypeCollection;
use Illuminate\Validation\ValidationException;
use Cb\Pgmware\Models\VariantType;

class VariantTypeController extends ApiController
{
    /**
     * @var VariantType
     */
    private $variantType;

    /**
     * variantTypeController constructor.
     *
     * @param VariantType $variantType
     */
    public function __construct(VariantType $variantType)
    {
        $this->variantType = $variantType;
    }

    /**
     * get all variantType
     *
     * @return JsonResponse
     */
    public function index()
    {
        $variantType = $this->variantType->paginate(
            $this->limit()
        );

        return $this->respondWithPagination(
            $variantType,
            VariantTypeCollection::collection($variantType)
        );
    }

    /**
     * store VariantType
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'description' => ['required', 'between:1,191'],
            ]);
        } catch (ValidationException $exception) {
            return $this->respondWithError($exception->errors());
        }

        $variantType = $this->variantType->forceFill($data);

        $variantType->save();

        return $this->setItem(
            VariantTypeCollection::make($variantType)
        )->responseUpdate('VariantType added');
    }

    /**
     * update VariantType
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $variantType = $this->variantType->find($id);

        if (empty($variantType)) {
            return $this->responseNotFound('Not Found VariantType');
        }

        try {
            $data = $request->validate([
                'description' => ['between:1,191'],
            ]);
        } catch (ValidationException $exception) {
            return $this->respondWithError($exception->errors());
        }

        $variantType = $variantType->forceFill($data);

        $variantType->save();

        return $this->setItem(
            VariantTypeCollection::make($variantType)
        )->responseUpdate('VariantType updated');
    }

    /**
     * show VariantType
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show($id)
    {
        $variantType = $this->variantType->find($id);

        if (empty($variantType)) {
            return $this->responseNotFound('Not Found VariantType');
        }

        return $this->setItem(
            VariantTypeCollection::make($variantType)
        )->respondAll();
    }

    /**
     * destroy VariantType
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $variantType = $this->variantType->find($id);

        if (empty($variantType)) {
            return $this->responseNotFound('Not Found variantType');
        }

        $variantType = $variantType->forceFill([
            'deleted_at' => now(),
        ]);

        $variantType->save();

        return $this->responseDeteted('VariantType deleted');
    }
}
