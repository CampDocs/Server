<?php

namespace App\Traits\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponse
{
    /** Generate Response Data Array **/
    private function generateData(mixed $data, ?string $message, int $statusCode): array
    {
        if (is_null($message)) {
            $message = trans(Response::$statusTexts[$statusCode]);
        }

        return ['message' => $message, 'data' => $data];
    }

    /** Generic message for all Responses **/
    private function genericResponse(mixed $data = [], string $message = null, int $statusCode = null): JsonResponse
    {
        $data = $this->generateData($data, $message, $statusCode);

        return new JsonResponse($data, $statusCode);
    }

    /*
    |--------------------------------------------------------------------------
    | Success Responses
    |--------------------------------------------------------------------------
    */

    /** Status 200 **/
    public function ok(string $message = null, mixed $data = []): JsonResponse
    {
        return $this->genericResponse($data, $message, Response::HTTP_OK);
    }

    /** Status 201 **/
    public function created(string $message = null, mixed $data = []): JsonResponse
    {
        return $this->genericResponse($data, $message, Response::HTTP_CREATED);
    }

    /** Status 204 **/
    public function noContent(string $message = null, mixed $data = []): JsonResponse
    {
        return $this->genericResponse($data, $message, Response::HTTP_NO_CONTENT);
    }

    /*
    |--------------------------------------------------------------------------
    | Client Error Responses
    |--------------------------------------------------------------------------
    */

    /** Status 302 **/
    public function found(string $message = null, mixed $data = []): JsonResponse
    {
        return $this->genericResponse($data, $message, Response::HTTP_FOUND);
    }

    /*
    |--------------------------------------------------------------------------
    | Client Error Responses
    |--------------------------------------------------------------------------
    */

    /** Status 400 **/
    public function badRequest(string $message = null, mixed $data = []): JsonResponse
    {
        return $this->genericResponse($data, $message, Response::HTTP_BAD_REQUEST);
    }

    /** Status 401 **/
    public function unauthorized(string $message = null, mixed $data = []): JsonResponse
    {
        return $this->genericResponse($data, $message, Response::HTTP_UNAUTHORIZED);
    }

    /** Status 403 **/
    public function forbidden(string $message = null, mixed $data = []): JsonResponse
    {
        return $this->genericResponse($data, $message, Response::HTTP_FORBIDDEN);
    }

    /** Status 404 **/
    public function notFound(string $message = null, mixed $data = []): JsonResponse
    {
        return $this->genericResponse($data, $message, Response::HTTP_NOT_FOUND);
    }

    /** Status 405 **/
    public function methodNotAllowed(string $message = null, mixed $data = []): JsonResponse
    {
        return $this->genericResponse($data, $message, Response::HTTP_METHOD_NOT_ALLOWED);
    }

    /** Status 409 **/
    public function conflict(string $message = null, mixed $data = []): JsonResponse
    {
        return $this->genericResponse($data, $message, Response::HTTP_CONFLICT);
    }

    /** Status 422 **/
    public function unprocessableEntity(string $message = null, mixed $data = []): JsonResponse
    {
        return $this->genericResponse($data, $message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /*
    |--------------------------------------------------------------------------
    | Server Error Responses
    |--------------------------------------------------------------------------
    */

    /** Status 500 **/
    public function internalServerError(string $message = null, mixed $data = []): JsonResponse
    {
        return $this->genericResponse($data, $message, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
