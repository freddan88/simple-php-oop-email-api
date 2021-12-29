<?php

declare(strict_types=1);

class Response {

    protected $fieldErrors = [];
    
    static function error($httpStatus, $origin = null)
    {
        $response = [
            'http_code' => $httpStatus['code'],
            'http_message' => $httpStatus['message'],
            'success' => false,
        ];
        if (!empty($origin)) {
            $response['origin'] = $origin;
        }
        echo json_encode($response);
        exit;
    }

    protected function customResponse($message, $status)
    {
        $json = [
            "message" => $message,
            "success" => $status
        ];
        echo json_encode($json);
        exit;
    }

    protected function addFieldError($message, $field)
    {
        $this->fieldErrors[$field] = $message;
    }

    protected function getFieldErrors()
    {
        $json = [
            'fieldErrors' => $this->fieldErrors
        ];
        echo json_encode($json);
    }
}