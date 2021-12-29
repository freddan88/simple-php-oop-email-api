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

        echo json_encode($response);
        exit;
    }

    protected function customResponse($httpCode, $message, $status)
    {
        $json = [
            'code' => $httpCode,
            'message' => $message,
            'success' => $status,
        ];

        echo json_encode($json);
        exit;
    }

    protected function addFieldError($message, $field)
    {
        $this->fieldErrors[$field] = $message;
    }

    protected function getFieldErrors($httpStatus)
    {
        $json = [
            'code' => $httpStatus['code'],
            'message' => $httpStatus['message'],
            'fieldErrors' => $this->fieldErrors,
            'success' => false,
        ];

        echo json_encode($json);
    }
}