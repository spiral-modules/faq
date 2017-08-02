<?php

namespace Spiral\FAQ\Database\Sources;

use Spiral\ORM\Entities\RecordSource;
use Spiral\FAQ\Database\FAQ;

/**
 * Class FAQSource
 *
 * @package Spiral\FAQ\Database\Sources
 */
class FAQSource extends RecordSource
{
    const RECORD = FAQ::class;
}