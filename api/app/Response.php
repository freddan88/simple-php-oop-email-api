<?php

declare(strict_types=1);

class Response {

    protected $fieldErrors = [];
    
    static function error($httpStatus, $origin = null)
    {
        $response = [
            'code' => $httpStatus['code'],
            'message' => $httpStatus['message'],
            'success' => false,
        ];

        if (!empty($origin)) {
            $response['origin'] = $origin;
        }

        http_response_code((int)$httpStatus['code']);
        echo json_encode($response);
        exit;
    }

    protected function customResponse($httpCode, $message, $status)
    {
        $response = [
            'code' => $httpCode,
            'message' => $message,
            'success' => $status,
        ];

        http_response_code((int)$httpCode);
        echo json_encode($response);
        exit;
    }

    protected function addFieldError($message, $field)
    {
        $this->fieldErrors[$field] = $message;
    }

    protected function getFieldErrors($httpStatus)
    {
        $response = [
            'code' => $httpStatus['code'],
            'message' => $httpStatus['message'],
            'fieldErrors' => $this->fieldErrors,
            'success' => false,
        ];

        http_response_code((int)$httpStatus['code']);
        echo json_encode($response);
    }
}