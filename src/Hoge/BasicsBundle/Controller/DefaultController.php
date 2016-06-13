<?php

namespace Hoge\BasicsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('HogeBasicsBundle:Default:index.html.twig', array('name' => $name));
    }
}
