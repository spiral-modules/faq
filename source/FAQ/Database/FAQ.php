<?php

namespace Spiral\FAQ\Database;

use Spiral\FAQ\Database\Types\FAQStatus;
use Spiral\Models\Accessors\SqlTimestamp;
use Spiral\Models\Traits\TimestampsTrait;
use Spiral\ORM\Record;

/**
 * Class FAQ
 *
 * @package Database\FAQ
 *
 * @property SqlTimestamp $time_created
 * @property SqlTimestamp $time_updated
 * @property FAQStatus    $status
 */
class FAQ extends Record
{
    use TimestampsTrait;

    const SCHEMA = [
        'id'       => 'primary',
        'status'   => FAQStatus::class,
        'question' => 'string(255)',
        'answer'   => 'text',
        'order'    => 'float',
    ];

    /**
     * {@inheritdoc}
     */
    const TABLE = 'faqs';

    const DATABASE = 'faq';

    /**
     * {@inheritdoc}
     */
    const FILLABLE = [
        'question',
        'answer',
        'order'
    ];

    const DEFAULTS = [];

    const INDEXES = [];

    /**
     * @param string $status
     *
     * @return bool
     */
    public function setStatus(string $status): bool
    {
        if (in_array($status, FAQStatus::ALLOWED_VALUES)) {
            $this->status = $status;

            return true;
        }

        return false;
    }
}