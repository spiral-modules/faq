<?php

namespace Spiral\FAQ\Requests;

use Spiral\FAQ\Database\Types\FAQStatus;
use Spiral\Http\Request\RequestFilter;

/**
 * Class FAQRequest
 *
 * @package Spiral\FAQ\Requests
 */
class FAQRequest extends RequestFilter
{
    /**
     * {@inheritdoc}
     */
    const SCHEMA = [
        'question' => 'data:question',
        'answer'   => 'data:answer',
        'status'   => 'data:status',
    ];

    const VALIDATES = [
        'question' => [
            'notEmpty',
            [
                'string::shorter',
                255,
                'message' => "[[Question must be less than {0} characters long.]]"
            ],
        ],
        'answer'   => [
            'notEmpty',
        ],
        'status'   => [
            ['in_array', FAQStatus::ALLOWED_VALUES, '[[Invalid status.]]']
        ],
    ];

    const SETTERS = [
        'question' => 'trim',
        'answer'   => 'trim',
    ];
}