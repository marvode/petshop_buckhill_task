<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponser
{
    private function successResponse(array $data, int $code): Response
    {
        return response()->json($data, $code);
    }

    protected function errorResponse(array $messages, int $code): Response
    {
        return response()->json(
            ['errors' => $messages],
            $code
        );
    }
    protected function showAll(array|Collection $collection, int $code = 200): Response
    {
        return $this->successResponse(['data' => $collection], $code);
    }

    protected function showOne(Model $model, int $code = 200): Response
    {
        return $this->successResponse(['data' => $model], $code);
    }
}
