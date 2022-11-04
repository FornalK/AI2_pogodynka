<?php

namespace App\Controller;

use App\Entity\Measurment;
use App\Form\MeasurmentType;
use App\Repository\MeasurmentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/measurment')]
class MeasurmentController extends AbstractController
{
    #[Route('/', name: 'app_measurment_index', methods: ['GET'])]
    public function index(MeasurmentRepository $measurmentRepository): Response
    {
        return $this->render('measurment/index.html.twig', [
            'measurments' => $measurmentRepository->findAll(),
        ]);
    }

    /**
     * @IsGranted("ROLE_MEASUREMENT_CREATE")
     */
    #[Route('/new', name: 'app_measurment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MeasurmentRepository $measurmentRepository): Response
    {
        $measurment = new Measurment();
        $form = $this->createForm(MeasurmentType::class, $measurment, [
            'validation_groups' => ['create']
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $measurmentRepository->save($measurment, true);

            return $this->redirectToRoute('app_measurment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('measurment/new.html.twig', [
            'measurment' => $measurment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_measurment_show', methods: ['GET'])]
    public function show(Measurment $measurment): Response
    {
        return $this->render('measurment/show.html.twig', [
            'measurment' => $measurment,
        ]);
    }

    /**
     * @IsGranted("ROLE_MEASUREMENT_EDIT")
     */
    #[Route('/{id}/edit', name: 'app_measurment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Measurment $measurment, MeasurmentRepository $measurmentRepository): Response
    {
        $form = $this->createForm(MeasurmentType::class, $measurment, [
            'validation_groups' => ['edit']
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $measurmentRepository->save($measurment, true);

            return $this->redirectToRoute('app_measurment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('measurment/edit.html.twig', [
            'measurment' => $measurment,
            'form' => $form,
        ]);
    }

    /**
     * @IsGranted("ROLE_MEASUREMENT_DELETE")
     */
    #[Route('/{id}', name: 'app_measurment_delete', methods: ['POST'])]
    public function delete(Request $request, Measurment $measurment, MeasurmentRepository $measurmentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$measurment->getId(), $request->request->get('_token'))) {
            $measurmentRepository->remove($measurment, true);
        }

        return $this->redirectToRoute('app_measurment_index', [], Response::HTTP_SEE_OTHER);
    }
}
