<?php

namespace App\Controller;

use App\Exception\BoundariesException;
use App\Form\ChallengeType;
use App\Service\ChallengeService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Exception\InvalidArgumentException;

class ChallengeController extends AbstractController
{
    /**
     * @Route("/", name="app_challenge")
     *
     * @param Request          $request
     * @param ChallengeService $challengeService
     *
     * @return Response
     */
    public function index(Request $request, ChallengeService $challengeService): Response
    {
        $form = $this->createForm(ChallengeType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            try {
                $input = $form->getData();
                $plateauCoordinates = explode(' ', $input['plateauCoordinates']);
                $roverPositions = $input['roverPositions'];
                $finalPositions = [];

                foreach ($roverPositions as $roverPosition) {
                    $finalPositions[] = $challengeService->navigate(
                        $roverPosition['roverPosition'],
                        $roverPosition['instructions'],
                        $plateauCoordinates[0],
                        $plateauCoordinates[1],
                    );
                }

                return $this->renderForm('challenge/index.html.twig', [
                    'form'    => $form,
                    'results' => $finalPositions
                ]);
            } catch (InvalidArgumentException $e) {
                return $this->renderForm('challenge/index.html.twig', [
                    'form'  => $form,
                    'error' => $e->getMessage()
                ]);
            } catch (BoundariesException $e) {
                return $this->renderForm('challenge/index.html.twig', [
                    'form'  => $form,
                    'error' => $e->getMessage()
                ]);
            } catch (Exception $e) {
                return $this->renderForm('challenge/index.html.twig', [
                    'form'  => $form,
                    'error' => 'An error occurred! Please check your input data.'
                ]);
            }
        }

        return $this->renderForm('challenge/index.html.twig', [
            'form' => $form,
        ]);
    }
}
