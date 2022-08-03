<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\CityType;
use App\Entity\City;
use Doctrine\Persistence\ManagerRegistry;

class CityController extends AbstractController
{
    #[Route('/city', name: 'app_city')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        //on recupère la liste des villes
        $cities = $entityManager
            ->getRepository(City::class)
            ->findAll();
        return $this->render('city/index.html.twig', [
            'cities' => $cities,
        ]);
    }
    
    //création d'une ville
    #[Route('/city/admin/create', name: 'admin_app_city_create', methods: ['GET', 'POST'])]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $city = new City();

        $form = $this->createForm(CityType::class, $city);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //on récupère les données
            $city = $form->getData();
            //on enregistre la ville
            $entityManager = $doctrine->getManager();
            $entityManager->persist($city);
            $entityManager->flush();
            //on redirige vers la liste des villes
            return $this->redirectToRoute('app_city');
        }
        //on crée le formulaire de création de ville
        $form = $this->createForm(CityType::class);
        return $this->render('city/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
