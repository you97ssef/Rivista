<?php

namespace App\Http;

class Response
{
    public static function Ok($result, $message = 'Success')
    {
        return response()->json(['data' => $result, 'message' => $message]);
    }

    public static function Created($result, $message = 'Created')
    {
        return response()->json(['data' => $result, 'message' => $message], 201);
    }

    public static function NoContent()
    {
        return response()->json(null, 204);
    }

    public static function BadRequest($message = 'Bad Request', $errors = [])
    {
        return response()->json(['message' => $message, 'errors' => $errors], 400);
    }

    public static function Unauthorized($message = 'You are not authorized to access this.')
    {
        return response()->json(['message' => $message], 401);
    }

    public static function NotFound($message = 'Not Found')
    {
        return response()->json(['message' => $message], 404);
    }
}
