<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class CVController extends AbstractController
{
    /**
     * @Route("/CV", name="cv")
     */
    public function CvAfficher()
    {
        return $this->render('CV/cv.html.twig',
            []);
    }
}
