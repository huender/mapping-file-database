<?php

namespace App\Controller;

use App\Model\MappingPostRequestDTO;
use App\Service\DataModelConverter;
use App\Service\FileManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiController extends AbstractController
{
    /**
     * Returns the file path and the file headers to map
     *
     * @param Request $request
     * @param FileManagerInterface $fileManager
     *
     * @return JsonResponse
     */
    public function uploadFile(Request $request, FileManagerInterface $fileManager): JsonResponse
    {
        try {
            $file = $request->files->get('file');

            if (!$file) {
                throw new NotFoundHttpException("File is required.");
            }

            $tmpFilePath = $fileManager->uploadFile($file);

            return new JsonResponse([
                'file_path' => $tmpFilePath,
                'file_headers' => $fileManager->getFileHeaders($tmpFilePath),
                'user_fields' => [] //TODO
            ]);
        } catch (\Exception $exception) {
            return new JsonResponse(
                ['message' => $exception->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Import the data matching the file data with the mapping json
     *
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param DataModelConverter $dataModelConverter
     * @param ValidatorInterface $validator
     *
     * @return Response
     */
    public function mapping(
        Request $request,
        SerializerInterface $serializer,
        DataModelConverter $dataModelConverter,
        ValidatorInterface $validator
    ): Response {
        try {
            /** @var MappingPostRequestDTO $mappingPostRequest */
            $mappingPostRequest = $serializer->deserialize(
                $request->getContent(),
                MappingPostRequestDTO::class,
                'json'
            );

            $errors = $validator->validate($mappingPostRequest);

            if (count($errors) > 0) {
                //@TODO Handle the ConstraintViolationList errors
                return new JsonResponse(
                    ['errors' => (string) $errors],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $feedback = $dataModelConverter->saveMapping($mappingPostRequest);

            //@TODO save it properly
            $serializedData = $serializer->serialize($feedback, 'json', ['groups' => ["mapping"]]);

            $request->getSession()->set("objects", $serializedData);

            return new Response($serializedData);
        //@TODO Handle the serializer exceptions properly
        } catch (\Exception $exception) {
            return new Response(
                $serializer->serialize(['message' => $exception->getMessage()], 'json'),
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
