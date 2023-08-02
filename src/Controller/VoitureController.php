<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoitureController extends AbstractController
{
    #[Route('/voiture', name: 'voiture')]
    public function index(VoitureRepository $repo): Response
    {
        $voitures = $repo->findAll();
        return $this->render('voiture/index.html.twig', [
            'items'=> $voitures,
        ]);
    }

    

    #[Route('/voiture/ajout', name: 'voiture_ajout')]
    public function ajout(Request $request, EntityManagerInterface $manager): Response
    {
        $voiture = new Voiture;
        // je crée une variable dans lequel je stock mon formulaire créée grace a createForm( et à son formBuilder (VoitureType))
        $form = $this->createForm(VoitureType::class, $voiture);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($voiture);
            $manager->flush();
            return $this->redirectToRoute('voiture');
        }

        return $this->render('voiture/ajout.html.twig', [
            'formVoiture' => $form,
        ]);
    }

    
}
