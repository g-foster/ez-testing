<?php

namespace Clientname\SearchBundle\Controller;

use eZ\Bundle\EzPublishCoreBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /** @DI\Inject("inviqa.ez.articlerepository") */
    private $articleRepository;

    /**
     * @Route("/", name="clientname_search_index")
     * @Template("ClientnameSearchBundle::Default/index.html.twig")
     * @Cache(smaxage="0")
     */
    public function indexAction(Request $request)
    {
    }

    /**
     * @Template("ClientnameSearchBundle::Default/article-list.html.twig")
     * @Cache(smaxage="600")
     */
    public function getArticlesAction($parentLocationId)
    {
        return $this->articleRepository->getArticlesByParentLocation($parentLocationId);
    }

    /**
     * @Route("/category/{category}", name="clientname_search_category", requirements={"category": "\d+"})
     * @Template("ClientnameSearchBundle::Default/category.html.twig")
     * @Cache(smaxage="0")
     */
    public function categoryAction($category)
    {
        return array('category' => $category);
    }

    /**
     * @Template("ClientnameSearchBundle::Default/article-list.html.twig")
     * @Cache(smaxage="600")
     */
    public function getArticlesByCategoryAction($category)
    {
        return $this->articleRepository->getArticlesByFieldValue('category', $category);
    }
}
