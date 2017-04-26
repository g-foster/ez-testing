<?php

namespace Clientname\SearchBundle\Controller;

use eZ\Bundle\EzPublishCoreBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Clientname\SearchBundle\Entity\SimpleSearch;
use JMS\DiExtraBundle\Annotation as DI;

class DefaultController extends Controller
{
    /** @DI\Inject("ez.articlerepository") */
    private $articleRepository;

    /**
     * @Route("/", name="clientname_search_index")
     * @Template("ClientnameSearchBundle::Default/index.html.twig")
     */
    public function indexAction()
    {
    }

    /**
     * @Route("/category/{category}", name="clientname_search_category", requirements={"category": "\d+"})
     * @Template("ClientnameSearchBundle::Default/category.html.twig")
     */
    public function categoryAction($category)
    {
        return array('category' => $category);
    }

    /**
     * @Template("ClientnameSearchBundle::Default/article-list.html.twig")
     */
    public function getArticlesByCategoryAction($category)
    {
        return $this->articleRepository->getArticlesByFieldValue('category', $category);
    }

    /**
     * @Template("ClientnameSearchBundle::Default/article-list.html.twig")
     */
    public function getArticlesAction($parentLocationId)
    {
        return $this->articleRepository->getArticlesByParentLocation($parentLocationId);
    }

    /**
     * @Template("ClientnameSearchBundle::Default/searchbox.html.twig")
     */
    public function showSearchBoxAction()
    {
        $form = $this->createForm('Clientname\SearchBundle\Form\Type\SimpleSearchType', new SimpleSearch());
        return array('form' => $form->createView());
    }

    /**
     * @Route("/", name="clientname_search_dosearch")
     */
    public function doSearch()
    {

    }
}
