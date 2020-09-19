<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class AnimationController extends AbstractController
{
    /**
     * @Route("/animation", name="animation")
     */
    public function accueuilAnim()
    {
        return $this->render('Animation/accueil.animation.html.twig',
            []);
    }
    /**
     * @Route("/animation_play", name="animation_play")
     */
    public function animPlay()
    {

        return $this->render('Animation/play.animation.html.twig',
            []);
    }
    /**
     * @Route("/teste", name="teste")
     */
    public function teste()
    {

        return $this->render('Animation/test.animation.html.twig',
            []);
    }
}
