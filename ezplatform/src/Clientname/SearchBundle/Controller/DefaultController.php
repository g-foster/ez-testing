<?php

namespace Clientname\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route(service="clientname.search.controller.default")
 */
class DefaultController extends Controller
{
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
    public function getArticlesAction()
    {
    }
}
