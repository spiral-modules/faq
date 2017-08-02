<?php

namespace Spiral\FAQ\VaultServices;

use Spiral\Core\FactoryInterface;
use Spiral\Listing\Filters\SearchFilter;
use Spiral\Listing\Filters\ValueFilter;
use Spiral\Listing\Listing;
use Spiral\Listing\Sorters\BinarySorter;
use Spiral\Listing\StaticState;
use Spiral\ORM\Entities\RecordSelector;
use Spiral\FAQ\Database\Types\FAQStatus;

class Listings
{
    /** @var FactoryInterface */
    protected $factory;

    /**
     * ListingService constructor.
     *
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param RecordSelector $selector
     *
     * @return Listing
     */
    public function getFAQ(RecordSelector $selector): Listing
    {
        /** @var Listing $listing */
        $listing = $this->factory->make(Listing::class, [
            'selector' => $selector->distinct()
        ]);

        $listing->addSorter('id', new BinarySorter('id'));
        $listing->addSorter('question', new BinarySorter('question'));

        $listing->addFilter(
            'status',
            new ValueFilter('status')
        );

        $listing->addFilter('search', new SearchFilter([
            'question' => SearchFilter::LIKE_STRING,
            'answer'   => SearchFilter::LIKE_STRING,
        ]));


        $defaultState = new StaticState('id', ['status' => FAQStatus::ACTIVE]);

        return $listing->setDefaultState($defaultState)->setNamespace('faq');
    }
}