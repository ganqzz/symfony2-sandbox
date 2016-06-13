<?php

namespace Hoge\BasicsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BasicsController extends Controller
{

    public function helloAction()
    {
        return $this->render('HogeBasicsBundle:Basics:hello.html.twig');
    }
}
