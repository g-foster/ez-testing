<?php

namespace AppBundle\Controller;

use eZ\Bundle\EzPublishCoreBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class SearchController extends Controller
{
    /** @DI\Inject("inviqa.ez.articlerepository") */
    private $articleRepository;

    /**
     * @Route("/", name="app_search_index")
     * @Template("AppBundle::Search/index.html.twig")
     * @Cache(smaxage="000")
     */
    public function indexAction(Request $request)
    {
        $scienceHide = false;
        $cookies = $request->cookies;
        if ($cookies->has('science_hide') && $cookies->get('science_hide')) {
            $scienceHide = true;
        }
        return array('scienceHide' => $scienceHide);
    }

    /**
     * @Template("AppBundle::Search/article-list.html.twig")
     * @Cache(smaxage="600")
     */
    public function getArticlesAction($parentLocationId)
    {
        return $this->articleRepository->getArticlesByParentLocation($parentLocationId);
    }

    /**
     * @Route("/category/{category}", name="app_search_category", requirements={"category": "\d+"})
     * @Template("AppBundle::Search/category.html.twig")
     * @Cache(smaxage="0")
     */
    public function categoryAction($category)
    {
        return array('category' => $category);
    }

    /**
     * @Template("AppBundle::Search/article-list.html.twig")
     * @Cache(smaxage="600")
     */
    public function getArticlesByCategoryAction($category)
    {
        return $this->articleRepository->getArticlesByFieldValue('category', $category);
    }
}
