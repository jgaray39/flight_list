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

    #[Route('/admin', name: 'admin_app_flight_index', methods: ['GET'])]
    public function indexAdmin(FlightRepository $flightRepository): Response
    {
        return $this->render('admin/flight/index.html.twig', [
            'flights' => $flightRepository->findAll(),
        ]);
    }

    #[Route('/admin/new', name: 'admin_app_flight_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FlightRepository $flightRepository): Response
    {
        $flight = new Flight();
        $form = $this->createForm(FlightType::class, $flight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $flightRepository->add($flight, true);

            return $this->redirectToRoute('admin_app_flight_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/flight/new.html.twig', [
            'flight' => $flight,
            'form' => $form,
        ]);
    }

    #[Route('/admin/{id}', name: 'admin_app_flight_show', methods: ['GET'])]
    public function show(Flight $flight): Response
    {
        return $this->render('admin/flight/show.html.twig', [
            'flight' => $flight,
        ]);
    }

    #[Route('/admin/{id}/edit', name: 'admin_app_flight_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Flight $flight, FlightRepository $flightRepository): Response
    {
        $form = $this->createForm(FlightType::class, $flight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $flightRepository->add($flight, true);

            return $this->redirectToRoute('admin_app_flight_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/flight/edit.html.twig', [
            'flight' => $flight,
            'form' => $form,
        ]);
    }

    #[Route('/admin/{id}', name: 'admin_app_flight_delete', methods: ['POST'])]
    public function delete(Request $request, Flight $flight, FlightRepository $flightRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$flight->getId(), $request->request->get('_token'))) {
            $flightRepository->remove($flight, true);
        }

        return $this->redirectToRoute('admin_app_flight_index', [], Response::HTTP_SEE_OTHER);
    }
}
