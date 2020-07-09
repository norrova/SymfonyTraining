<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class PinController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index() : Response
    {
        return $this->render('pin/index.html.twig');
    }

    /**
     * @Route("/add")
     */
    public function add(EntityManagerInterface $em)
    {
        $pin = new Pin;
        $pin->setTitle('Title 3');
        $pin->setDescription('Description 3');
        // $em = $this->getDoctrine()->getManager();
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($pin);
        //  actually executes the queries
        $em->flush();
        die;
    }
    /**
     * @Route("/showClassic")
     */
    public function RepoClassic(EntityManagerInterface $em)
    {
        // Manière classique
        $repo = $em->getRepository(Pin::class);
        $pins = $repo->findAll();
        return $this->render('pin/index.html.twig',compact('pins'));
        /**
         compact('pins') => ['pins' => $pins]
         */
    }

    /**
     * @Route("/showModern")
     */
    public function RepoModern(PinRepository $repo)
    {
        // Injection de dépendance
        return $this->render('pin/index.html.twig', ['pins' => $repo->findAll()]);
    }
}