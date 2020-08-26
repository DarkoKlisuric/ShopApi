<?php

namespace App\Controller;

use App\Serializer\RequestSerializerInterface;
use App\Serializer\ResponseSerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiController
 * @package App\Controller
 */
class ApiController extends AbstractController
{
    /**
     * @var RequestSerializerInterface
     */
    private RequestSerializerInterface $requestSerializer;

    /**
     * @var ResponseSerializerInterface
     */
    private ResponseSerializerInterface $responseSerializer;

    public function __construct(RequestSerializerInterface $requestSerializer, ResponseSerializerInterface $responseSerializer)
    {
        $this->requestSerializer = $requestSerializer;
        $this->responseSerializer = $responseSerializer;
    }

    /**
     * @return RequestSerializerInterface
     */
    public function getRequestSerializer(): RequestSerializerInterface
    {
        return $this->requestSerializer;
    }

    /**
     * @return ResponseSerializerInterface
     */
    public function getResponseSerializer(): ResponseSerializerInterface
    {
        return $this->responseSerializer;
    }

    /**
     * @var int
     */
    private int $statusCode = Response::HTTP_OK;

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param $data
     * @param array $headers
     * @return Response
     */
    public function response($data, $headers = ['Content-Type' => 'application/json'])
    {
        return new Response($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param $errors
     * @param array $headers
     * @return JsonResponse
     */
    public function respondWithErrors($errors, $headers = [])
    {
        $data = [
            'status' => $this->getStatusCode(),
            'errors' => $errors,
        ];

        return new JsonResponse($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param $success
     * @param array $headers
     * @return JsonResponse
     */
    public function respondWithSuccess($success, $headers = [])
    {
        $data = [
            'status' => $this->getStatusCode(),
            'success' => $success,
        ];

        return new JsonResponse($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function respondCreated($data = [])
    {
        return $this->setStatusCode(Response::HTTP_CREATED)->respondWithSuccess($data);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    public function respondUnauthorized($message = 'Not authorized!')
    {
        return $this->setStatusCode(Response::HTTP_UNAUTHORIZED)->respondWithErrors($message);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    public function respondValidationError($message = 'Validation errors')
    {
        return $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)->respondWithErrors($message);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    public function respondNotFound($message = 'Not found!')
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondWithErrors($message);
    }
}