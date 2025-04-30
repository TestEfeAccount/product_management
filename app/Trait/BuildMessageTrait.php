<?php

namespace App\Trait;

use App\Models\Batch;

trait BuildMessageTrait
{

    private function buildSuccessResponse($data, $message): array
    {
      return  $this->buildResponseData($data, $message, true);
    }

    private function buildCustomMessageResponse($message): array
    {
        return $this->buildResponseData(null,$message);
    }

    private function buildResponseData($data= null, $message =null, $type = false): array
    {
        return [
            'success' => $type,
            'message' => $message,
            'data' => $data,
        ];
    }
}
