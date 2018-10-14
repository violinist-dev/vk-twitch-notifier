<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

class ApiProblemType extends Enum
{
    public const INTERNAL_SERVER_ERROR = 'internal_server_error';
    public const INVALID_JSON = 'invalid_json';
    public const METHOD_NOT_ALLOWED = 'method_not_allowed';
    public const NOT_FOUND = 'not_found';
    public const SERVICE_UNAVAILABLE = 'service_unavailable';
    public const VALIDATION_ERROR = 'validation_error';
}
