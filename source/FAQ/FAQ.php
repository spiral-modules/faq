<?php

namespace Spiral\FAQ;

use Psr\SimpleCache\CacheInterface;
use Spiral\FAQ\Database\Sources\FAQSource;

/**
 * Class FAQ
 *
 * @package Spiral\FAQ
 */
class FAQ
{
    /** @var FAQSource */
    protected $source;

    /** @var CacheInterface */
    protected $cache;

    const CACHE_KEY = 'faqs';

    /**
     * FAQ constructor.
     *
     * @param FAQSource      $source
     * @param CacheInterface $cache
     */
    public function __construct(FAQSource $source, CacheInterface $cache)
    {
        $this->source = $source;
        $this->cache = $cache;
    }

    /**
     * @param bool $withCache
     *
     * @return array|\Spiral\ORM\RecordInterface[]
     */
    public function getAll($withCache = true): array
    {
        if ($withCache) {
            if (!$this->cache->has(self::CACHE_KEY)) {
                $faqs = $this->getList();
                $this->cache->set(self::CACHE_KEY, $faqs);
            } else {
                $faqs = $this->cache->get(self::CACHE_KEY);
            }
        } else {
            $faqs = $this->getList();
        }

        return $faqs;
    }

    /**
     * Reset a module cache
     *
     * @param bool $rebuild
     */
    public function reset(bool $rebuild = false)
    {
        if ($this->cache->has(self::CACHE_KEY)) {
            $this->cache->delete(self::CACHE_KEY);
        }

        if (!empty($rebuild)) {
            $faqs = $this->getList();
            $this->cache->set(self::CACHE_KEY, $faqs);
        }
    }

    /**
     * Array of faq records.
     *
     * @return array|\Spiral\ORM\RecordInterface[]
     */
    protected function getList(): array
    {
        $records = $this->source->find()->orderBy('id', 'ASC')->fetchAll();

        $output = \array_map(function (\Spiral\FAQ\Database\FAQ $faq) {
            return $faq->packFields();
        }, $records);

        return $output;
    }
}