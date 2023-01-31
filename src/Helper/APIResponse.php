<?php

namespace Detikcom\Helper;

class APIResponse
{
    public static function badRequest($errors = [])
    {
        $response = [
            'status'   => false,
            'messsage' => "Bad Request",
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        APIResponse::json($response, 400);
    }

    public static function serverError(string $message = "Internal Server Error", int $code = 500)
    {
        $response = [
            'status'   => false,
            'messsage' => $message,
        ];

        APIResponse::json($response, $code);
    }

    public static function success(array $data, string $message = "successfully")
    {
        $response = [
            'status'   => true,
            'messsage' => $message,
            'data'     => $data
        ];
        APIResponse::json($response, 200);
    }

    public static function notFound(string $message = "failed, data not found")
    {
        $response = [
            'status'   => false,
            'messsage' => $message,
        ];
        APIResponse::json($response, 404);
    }

    private static function json(array $response, int $statusCode)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
        http_response_code($statusCode);
        die;
    }

    public static function pageNotFound(string $message = "page not found")
    {
        $response = [
            'status'  => false,
            'message' => $message
        ];
        APIResponse::json($response, 404);
    }

    public static function unauthorized()
    {
        $response = [
            'status'  => false,
            'message' => "Access denied. Check your username or password"
        ];
        APIResponse::json($response, 401);
    }
}
