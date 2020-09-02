<?php


namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class ConnectionController extends AbstractController
{
    /**
     * @Route("/connection", name="connection")
     */
    public function login(){

        return $this->render('connection/connection.html.twig');
    }

    /**
     * @Route("/logout",name="logout")
     */
    public function logout(){}
}