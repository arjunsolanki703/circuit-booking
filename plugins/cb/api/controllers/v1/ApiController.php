<?php

namespace Cb\Api\Controllers\V1;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ApiController extends Controller
{
    protected $statusCode = Response::HTTP_OK;
    private $responseData = [];
    private $headers = [];

    public function limit($min = 3, $max = 50)
    {
        $limit = (int)request()->input('limit') ? : $min;

        if ($limit > $max) {
            $limit = $max;
        }

        if ($limit < $min) {
            $limit = $min;
        }

        return $limit;
    }

    /**
     * Gets the value of statusCode.
     *
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Sets the value of statusCode.
     *
     * @param mixed $statusCode the status code
     *
     * @return self
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param array $headers
     *
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setResponseData($key, $value)
    {
        $this->responseData[$key] = $value;

        return $this;
    }

    /**
     * @param string $message
     *
     * @return $this
     */
    public function setMessage($message)
    {
        $this->setResponseData('message', $message);

        return $this;
    }

    /**
     * @param string $message
     *
     * @return $this
     */
    public function setError($message)
    {
        $this->setResponseData('error', $message);

        return $this;
    }

    /**
     * @param array $message
     *
     * @return $this
     */
    public function setErrors($message)
    {
        $this->setResponseData('errors', $message);

        return $this;
    }

    /**
     *
     * @return $this
     */
    public function setItems($items)
    {
        $this->setResponseData('items', $items);

        return $this;
    }

    /**
     *
     * @return $this
     */
    public function setItem($items)
    {
        $this->setResponseData('item', $items);

        return $this;
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function responseNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)
            ->setError($message)
            ->respondAll();
    }

    /**
     * @param $data
     *
     * @return JsonResponse
     */
    public function responseOk($data)
    {
        return $this->setStatusCode(Response::HTTP_OK)
            ->setItem($data)
            ->respondAll();
    }

    /**
     * @param $message
     *
     * @return JsonResponse
     */
    public function respondWithError($message)
    {
        return $this->setErrors($message)->respondAll();
    }

    /**
     *
     * @return JsonResponse
     */
    public function respondItems($items)
    {
        return $this->setItems($items)->respondAll();
    }

    /**
     * @param $items
     *
     * @return JsonResponse
     */
    public function respondItem($items)
    {
        return $this->setItem($items)->respondAll();
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondInvalidRequest($message = 'Invalid Request!')
    {
        return $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)->setError($message)->respondAll();
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)->setError($message)->respondAll();
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondForbiddenError($message = 'Forbidden Error')
    {
        return $this->setStatusCode(Response::HTTP_FORBIDDEN)->setError($message)->respondAll();
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function responseCreated($message = '')
    {
        return $this->setStatusCode(Response::HTTP_CREATED)->setMessage($message)->respondAll();
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function responseUpdate($message = '')
    {
        return $this->setStatusCode(Response::HTTP_OK)->setMessage($message)->respondAll();
    }

    public function responseDeteted($message = '')
    {
        return $this->setStatusCode(Response::HTTP_NO_CONTENT)->setMessage($message)->respondAll();
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondWithMessage($message = 'All is well.')
    {
        return $this->setMessage($message)->respondAll();
    }

    /**
     * @param LengthAwarePaginator $dataPagination
     * @param          $data
     *
     * @return JsonResponse
     */
    public function respondWithPagination(LengthAwarePaginator $dataPagination, $data)
    {
        return $this->setItems($data->jsonSerialize())->setResponseData('paginator', [
            'total_count' => $dataPagination->total(),
            'total_pages' => ceil($dataPagination->total() / $dataPagination->perPage()),
            'current_page' => $dataPagination->currentPage(),
            'limit' => (int)$dataPagination->perPage(),
        ])->respondAll();
    }

    /**
     * @param       $data
     * @param array $headers
     *
     * @return JsonResponse
     */
    public function respond($data, $headers = [])
    {
        return response()->json(
            $data,
            $this->getStatusCode(),
            $headers
        );
    }

    /**
     * @return JsonResponse
     */
    public function respondAll()
    {
        $this->setResponseData('status_code', $this->getStatusCode());

        return $this->respond(
            $this->responseData,
            $this->headers
        );
    }
}
