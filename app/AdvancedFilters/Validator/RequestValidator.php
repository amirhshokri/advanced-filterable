<?php

namespace App\AdvancedFilters\Validator;

use Exception;
use Illuminate\Support\Facades\Validator;

class RequestValidator
{
    /**
     * @param array $requestParameters
     * @return void
     * @throws Exception
     */
    public static function validate(array $requestParameters): void
    {
        $rules = [
            'filters' => 'array',
            'filters.*' => 'required|array',
            'filters.*.name' => 'required|string',
            'filters.*.operand' => 'required|string|in:isEqualTo,isNotEqualTo,greaterThan,lessThan,greaterThanOrEqualTo,lessThanOrEqualTo,between,in,contains',
            'filters.*.value' => 'required'
        ];

        $validator = Validator::make($requestParameters, $rules);

        if ($validator->fails() === true) {
            throw new Exception('Invalid request parameters.');
        }
    }
}