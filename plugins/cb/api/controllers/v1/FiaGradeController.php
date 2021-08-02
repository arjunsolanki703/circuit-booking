<?php

namespace Cb\Api\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Cb\Api\Transformers\V1\FiaGrade as FiaGradeCollection;
use Illuminate\Validation\ValidationException;
use Cb\Pgmware\Models\Grade;

class FiaGradeController extends ApiController
{
    /**
     * @var Grade
     */
    private $fiaGrade;

    /**
     * fiaGradeController constructor.
     *
     * @param Grade $fiaGrade
     */
    public function __construct(Grade $fiaGrade)
    {
        $this->fiaGrade = $fiaGrade;
    }

    /**
     * get all fiaGrade
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fiaGrade = $this->fiaGrade->paginate(
            $this->limit()
        );

        return $this->respondWithPagination(
            $fiaGrade,
            FiaGradeCollection::collection($fiaGrade)
        );
    }

    /**
     * store FiaGrade
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => ['required','between:1,191'],
            ]);
        } catch (ValidationException $exception) {
            return $this->respondWithError($exception->errors());
        }

        $fiaGrade = $this->fiaGrade->forceFill($data);

        $fiaGrade->save();

        return $this->setItem(
            FiaGradeCollection::make($fiaGrade)
        )->responseUpdate('FiaGrade added');
    }

    /**
     * update FiaGrade
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $fiaGrade = $this->fiaGrade->find($id);

        if (empty($fiaGrade)) {
            return $this->responseNotFound('Not Found FiaGrade');
        }

        try {
            $data = $request->validate([
                'name' => ['between:1,191'],
            ]);
        } catch (ValidationException $exception) {
            return $this->respondWithError($exception->errors());
        }

        $fiaGrade = $fiaGrade->forceFill($data);

        $fiaGrade->save();

        return $this->setItem(
            FiaGradeCollection::make($fiaGrade)
        )->responseUpdate('FiaGrade updated');
    }

    /**
     * show FiaGrade
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show($id)
    {
        $fiaGrade = $this->fiaGrade->find($id);

        if (empty($fiaGrade)) {
            return $this->responseNotFound('Not Found FiaGrade');
        }

        return $this->setItem(
            FiaGradeCollection::make($fiaGrade)
        )->respondAll();
    }

    /**
     * destroy FiaGrade
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $fiaGrade = $this->fiaGrade->find($id);

        if (empty($fiaGrade)) {
            return $this->responseNotFound('Not Found fiaGrade');
        }

        $fiaGrade = $fiaGrade->forceFill([
            'deleted_at' => now()
        ]);

        $fiaGrade->save();

        return $this->responseDeteted('FiaGrade deleted');
    }
}
