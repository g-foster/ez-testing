<?php

namespace AppBundle\Controller;

use eZ\Bundle\EzPublishCoreBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    /** @DI\Inject("inviqa.ez.articlerepository") */
    private $articleRepository;

    /**
     * @Route("/", name="app_search_index")
     * @Template("AppBundle::Search/index.html.twig")
     */
    public function indexAction(Request $request)
    {
    }

    /**
     * @Template("AppBundle::Search/article-list.html.twig")
     */
    public function getArticlesAction($parentLocationId)
    {
        return $this->articleRepository->getArticlesByParentLocation($parentLocationId);
    }

    /**
     * @Route("/category/{category}", name="app_search_category", requirements={"category": "\d+"})
     * @Template("AppBundle::Search/category.html.twig")
     */
    public function categoryAction($category)
    {
        return array('category' => $category);
    }

    /**
     * @Template("AppBundle::Search/article-list.html.twig")
     */
    public function getArticlesByCategoryAction($category)
    {
        return $this->articleRepository->getArticlesByFieldValue('category', $category);
    }
}
