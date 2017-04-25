<?php

namespace Clientname\SearchBundle\Controller;

use eZ\Bundle\EzPublishCoreBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\Core\SignalSlot\LocationService;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;

/**
 * @Route(service="clientname.search.controller.default")
 */
class DefaultController extends Controller
{
    /**
     * @var SearchService
     */
    private $searchService;

    /**
     * @var LocationService
     */
    private $locationService;

    /**
     * @param SearchService $searchService
     * @param SearchLocation $searchLocation
     */
    public function __construct(
        SearchService $searchService,
        LocationService $locationService
    ) {
        $this->searchService = $searchService;
        $this->locationService = $locationService;
    }

    /**
     * @Route("/", name="index")
     * @Template("SearchBundle::Default/index.html.twig")
     */
    public function indexAction()
    {
    }

    /**
     * @Template("SearchBundle::Default/article-list.html.twig")
     */
    public function getArticlesAction($parentLocationId)
    {
        $query = new LocationQuery();
        $query->filter = new Criterion\LogicalAnd([
            new Criterion\Visibility(Criterion\Visibility::VISIBLE),
            new Criterion\ParentLocationId($parentLocationId)
        ]);

        $searchResult = $this->searchService->findContent($query);
        if (null === $searchResult) {
            /// ... throw exception ...
        }

        return array('searchHits' => $searchResult->searchHits);
    }
}
