<?php

namespace Clientname\UserBundle\Controller;

use eZ\Bundle\EzPublishCoreBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Clientname\UserBundle\Entity\Login;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/auth")
 */
class AuthController extends Controller
{

    /**
     * @Route("/displayform", name="clientname_user_displayform")
     * @Template("ClientnameUserBundle::Default/form.html.twig")
     * @Cache(smaxage="600")
     */
    public function displayFormAction()
    {
        $form = $this->createForm('Clientname\UserBundle\Form\Type\LoginType', new Login());
        return array('form' => $form->createView());
    }

    /**
     * @Route("/login", name="clientname_user_dologin")
     */
    public function doLoginAction(Request $request)
    {
        $form = $this->createForm('Clientname\UserBundle\Form\Type\LoginType', new Login());
        $form->handleRequest($request);

        $loginEntity = $form->getData();

        $username = $loginEntity->username;

        $em = $this->getDoctrine()->getManager();

        var_dump($username);
        exit;
    }
}
