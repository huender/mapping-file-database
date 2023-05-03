<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class ObjectsController extends AbstractController
{
    /**
     * @param RequestStack $requestStack
     * @return Response
     */
    public function list(RequestStack $requestStack): Response
    {
        try {
            return new Response($requestStack->getSession()->get("objects"));
        } catch (\Exception $exception) {
            return new JsonResponse(
                ['message' => $exception->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
