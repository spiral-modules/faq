<?php

namespace Spiral\FAQ\Controllers;

use Spiral\Core\Controller;
use Spiral\FAQ\Database\FAQ;
use Spiral\FAQ\Database\Sources\FAQSource;
use Spiral\FAQ\Requests\FAQRequest;
use Spiral\FAQ\VaultServices\Listings;
use Spiral\FAQ\VaultServices\Statuses;
use Spiral\Http\Exceptions\ClientExceptions\NotFoundException;
use Spiral\Security\Traits\GuardedTrait;
use Spiral\Translator\Traits\TranslatorTrait;

/**
 * Class FAQController
 *
 * @package Spiral\FAQ\Controllers
 */
class FAQController extends Controller
{
    use GuardedTrait, TranslatorTrait;

    const GUARD_NAMESPACE = 'vault.faq';

    /** @var FaqSource */
    private $source;

    /**
     * UsersController constructor.
     *
     * @param FAQSource $source
     */
    public function __construct(FAQSource $source)
    {
        $this->source = $source;
    }

    /**
     * @param Listings $listings
     * @param Statuses $statuses
     *
     * @return string
     */
    public function indexAction(Listings $listings, Statuses $statuses): string
    {
        return $this->views->render('faq:list', [
            'listing'  => $listings->getFAQ($this->source->find()),
            'statuses' => $statuses
        ]);
    }

    /**
     * @param Statuses $statuses
     *
     * @return string
     */
    public function addAction(Statuses $statuses): string
    {
        $this->allows('add');

        return $this->views->render('faq:add', compact('statuses'));
    }

    /**
     * @param int      $id
     * @param Statuses $statuses
     *
     * @return string
     */
    public function editAction($id, Statuses $statuses): string
    {
        /** @var FAQ $faq */
        $faq = $this->source->findByPK($id);
        if (empty($faq)) {
            throw new NotFoundException();
        }
        $this->allows('view', ['entity' => $faq]);

        return $this->views->render('keeper:faq/edit', [
            'entity'   => $faq,
            'statuses' => $statuses
        ]);
    }

    /**
     * @param FAQRequest $request
     *
     * @return array
     */
    public function createAction(FAQRequest $request): array
    {
        $this->allows('add');

        if (!$request->isValid()) {
            return [
                'status' => 400,
                'errors' => $request->getErrors()
            ];
        }

        /** @var FAQ $faq */
        $faq = $this->source->create();
        $faq->setFields($request->getFields());
        $faq->setStatus($request->status);
        $faq->save();

        return [
            'status'  => 200,
            'message' => $this->say('FAQ item has been created.'),
            'action'  => [
                'delay'    => 500,
                'redirect' => $this->vault->uri('faq'),
            ]
        ];
    }

    /**
     * @param int             $id
     * @param FAQRequest      $request
     * @param \Spiral\FAQ\FAQ $service
     *
     * @return array
     */
    public function updateAction($id, FAQRequest $request, \Spiral\FAQ\FAQ $service): array
    {
        /** @var FAQ $faq */
        $faq = $this->source->findByPK($id);
        if (empty($faq)) {
            throw new NotFoundException();
        }

        $this->allows('update', ['entity' => $faq]);

        if (!$request->isValid()) {
            return [
                'status' => 400,
                'errors' => $request->getErrors()
            ];
        }

        $faq->setFields($request->getFields());
        $faq->setStatus($request->status);
        $faq->save();

        $service->reset(true);

        return [
            'status'  => 200,
            'message' => $this->say('FAQ item has been updated.'),
            'action'  => 'reload'
        ];
    }
}