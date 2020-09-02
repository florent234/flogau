<?php

namespace App\Controller;

use App\Entity\User;
use Cassandra\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;



class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }
    private function createCreateForm(User $user)
    {
        $form = $this->createForm(UserType::class, $user, array(
            'action' => $this->generateUrl('user_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    private function createEditForm(User $user)
    {
        // Note the change of the first parameter of createForm
        $form = $this->createForm(UserType::class, $user, array(
            'action' => $this->generateUrl('projects_update', array('id' => $user->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
}
