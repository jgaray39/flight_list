<?php

namespace App\Controller;

use App\Entity\Flight;
use App\Form\Type\FlightType;
use App\Repository\FlightRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/flight')]
class FlightController extends AbstractController
{
    #[Route('/', name: 'app_flight_index', methods: ['GET'])]
    public function index(FlightRepository $flightRepository): Response
    {
        return $this->render('flight/index.html.twig', [
            'flights' => $flightRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_flight_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FlightRepository $flightRepository): Response
    {
        $flight = new Flight();
        $form = $this->createForm(FlightType::class, $flight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $flightRepository->add($flight, true);

            return $this->redirectToRoute('app_flight_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('flight/new.html.twig', [
            'flight' => $flight,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_flight_show', methods: ['GET'])]
    public function show(Flight $flight): Response
    {
        return $this->render('flight/show.html.twig', [
            'flight' => $flight,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_flight_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Flight $flight, FlightRepository $flightRepository): Response
    {
        $form = $this->createForm(FlightType::class, $flight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $flightRepository->add($flight, true);

            return $this->redirectToRoute('app_flight_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('flight/edit.html.twig', [
            'flight' => $flight,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_flight_delete', methods: ['POST'])]
    public function delete(Request $request, Flight $flight, FlightRepository $flightRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$flight->getId(), $request->request->get('_token'))) {
            $flightRepository->remove($flight, true);
        }

        return $this->redirectToRoute('app_flight_index', [], Response::HTTP_SEE_OTHER);
    }
}
