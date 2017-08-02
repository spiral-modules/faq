<?php

namespace Spiral\FAQ\Database\Types;

use Spiral\ORM\Columns\EnumColumn;

class FAQStatus extends EnumColumn
{
    /**
     * Statuses.
     */
    const ACTIVE  = 'active';
    const DRAFT   = 'draft';
    const DELETED = 'deleted';

    /**
     * {@inheritdoc}
     */
    const VALUES         = [self::ACTIVE, self::DRAFT, self::DELETED];
    const ALLOWED_VALUES = [self::ACTIVE, self::DRAFT];

    /**
     * {@inheritdoc}
     */
    const DEFAULT        = self::DRAFT;

    /**
     * If status is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->packValue() == self::ACTIVE;
    }

    /**
     * If status is draft.
     *
     * @return bool
     */
    public function isDraft(): bool
    {
        return $this->packValue() == self::DRAFT;
    }

    /**
     * If status is deleted.
     *
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->packValue() == self::DELETED;
    }

    /**
     * Set active status.
     */
    public function setActive()
    {
        $this->setValue(self::ACTIVE);
    }

    /**
     * Set draft status.
     */
    public function setDraft()
    {
        $this->setValue(self::DRAFT);
    }

    /**
     * Set deleted status.
     */
    public function setDeleted()
    {
        $this->setValue(self::DELETED);
    }
}