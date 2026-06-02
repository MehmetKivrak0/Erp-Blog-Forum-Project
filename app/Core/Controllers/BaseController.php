<?php

namespace App\Core\Controllers;

use App\Http\Controllers\Controller;

abstract class BaseController extends Controller
{
    /**
     * Başarılı işlemlerde standart JSON formatı döner.
     */
    public function sendSuccess(mixed $data, string $message = 'İşlem başarılı.', int $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Hatalı işlemlerde standart JSON formatı döner.
     */
    public function sendError(string $error, array $errorMessages = [], int $code = 400)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        // Eğer form doğrulama (validation) hataları gibi detaylı hatalar varsa ekle
        if (!empty($errorMessages)) {
            $response['errors'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}