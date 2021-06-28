<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Form\EquipementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EquipementController extends AbstractController
{
    /**
     * @Route("/equipement", name="equipement")
     */
    public function index(): Response
    {
        return $this->render('equipement/index.html.twig', [
            'controller_name' => 'EquipementController',
        ]);
    }

    /**
     * @Route("/ajouter_un_equipement", name="ajouter")
     */
    public function ajouter(Request $request): Response
    {
        $equipement = new Equipement();
        $form = $this->createForm(EquipementType::class, $equipement);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $equipement->setUpdatedAt(new \DateTime());
            $equipement->setCreatedAt(new \DateTime());

           /* if($equipement->getIsPublished()) {
                $equipement->setCreatedAt(new \DateTime());
            }*/

            $em = $this->getDoctrine()->getManager();
            $em->persist($equipement);
            $em->flush();

            return new Response('Equipement ajouté avec succès');
        }

        return $this->render('equipement/ajouter.html.twig', [
            //'controller_name' => 'EquipementController',
            'form' => $form->createView()
        ]);
    }
}
;