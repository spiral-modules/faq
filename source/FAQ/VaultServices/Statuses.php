<?php

namespace Spiral\FAQ\VaultServices;

use Spiral\Core\Service;
use Spiral\FAQ\Database\Types\FAQStatus;
use Spiral\Translator\Traits\TranslatorTrait;

class Statuses extends Service
{
    use TranslatorTrait;

    const ICONS = [
        FAQStatus::ACTIVE  => 'done',
        FAQStatus::DRAFT   => 'clear',
        FAQStatus::DELETED => 'delete',
    ];

    /**
     * @param bool $placeholder
     *
     * @return array
     */
    public function labels(bool $placeholder = false): array
    {
        $labels = [];
        foreach (FAQStatus::ALLOWED_VALUES as $label) {
            $labels[$label] = $this->makeLabel($label);
        }

        if (!empty($placeholder)) {
            $labels = [null => $this->say('All FAQ records')] + $labels;
        }

        return $labels;
    }

    /**
     * @return array
     */
    public function icons(): array
    {
        return self::ICONS;
    }

    /**
     * @param string $status
     *
     * @return string
     */
    public function icon(string $status): string
    {
        return self::ICONS[$status];
    }

    /**
     * @param string $label
     *
     * @return string
     */
    private function makeLabel(string $label): string
    {
        return $this->say(ucwords(str_replace('-', ' ', $label)));
    }

    /**
     * Get label for status.
     *
     * @param string $status
     *
     * @return string
     */
    public function label(string $status): string
    {
        return $this->makeLabel($status);
    }

    /**
     * If status is listed
     *
     * @param string $status
     *
     * @return bool
     */
    public function isListed(string $status): bool
    {
        return array_key_exists($status, $this->labels);
    }
}