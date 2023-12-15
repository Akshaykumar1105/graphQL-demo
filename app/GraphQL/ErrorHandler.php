<?php

namespace App\GraphQL;

use GraphQL\Error\Error;
use Rebing\GraphQL\Error\ValidationError;

class ErrorHandler
{
    public static function formatError(Error $e)
    {
        $error['message'] = $e->getMessage();

        $previous = $e->getPrevious();
        if ($previous && $previous instanceof ValidationError) {
            $errorMessage = $previous->getValidatorMessages()->toArray();
            foreach ($errorMessage as $key => $message) {
                if (str_starts_with($key, 'input.')) {
                    $key = str_replace('input.', '', $key);
                }
                $message = str_replace('input.', '', $message);
                $error['fields'][$key] = $message;
                $error['extensions'][$key] = $message;
            }
        }

        return $error;
    }
}