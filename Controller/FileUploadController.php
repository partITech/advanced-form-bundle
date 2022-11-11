<?php

namespace Partitech\AdvancedFormBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Partitech\AdvancedFormBundle\Event\GetResponseRemoveFileEvent;
use Partitech\AdvancedFormBundle\Event\GetResponseUploadFileEvent;
use Partitech\AdvancedFormBundle\Form\Type\EntityMappingType;
use Partitech\AdvancedFormBundle\Form\Type\UploadFileType;
use Partitech\AdvancedFormBundle\Manager\MappingManager;
use Partitech\AdvancedFormBundle\Manager\UploadManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Form\FormFactoryInterface;

class FileUploadController extends AbstractController
{
    /**
     * @var UploadManager
     */
    private $uploadManager;

    /**
     * @var MappingManager
     */
    private $mappingManager;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    private $formFactory;

    /**
     * @param UploadManager            $uploadManager
     * @param MappingManager           $mappingManager
     * @param EntityManagerInterface   $em
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        UploadManager $uploadManager,
        MappingManager $mappingManager,
        EntityManagerInterface $em,
        EventDispatcherInterface $eventDispatcher,
        FormFactoryInterface $formFactory
    ) {
        $this->uploadManager = $uploadManager;
        $this->mappingManager = $mappingManager;
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
        $this->formFactory=$formFactory;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function uploadFileAction(Request $request)
    {
        $data = $request->get('afb_upload_file');
        $form=$this->formFactory->create(EntityMappingType::class, [], ['csrf_protection' => false]);
        $form->submit(['mapping' => $data['mapping'], 'entity' => $data['id']]);

        $mapping = $form->getData()['mapping'];
        $object = $form->getData()['entity'];

        $event = new GetResponseUploadFileEvent($mapping->id, $object);
        if (Kernel::VERSION_ID < 40300) {
            $this->eventDispatcher->dispatch(get_class($event), $event);
        } else {
            $this->eventDispatcher->dispatch($event);
        }
        if ($event->getResponse() !== null) {
            return $event->getResponse();
        }

        $form = $this->formFactory->create(UploadFileType::class, $object, ['csrf_protection' => false, 'mapping' => $mapping]);
        $form->submit([$mapping->fileProperty => $request->files->get('afb_upload_file')['file']]);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $uploadedFile = $form->get('fileContainer')->getData()->getImageFile();
                $fileContainer = $form->get('fileContainer')->getData();
                try {
                    $this->em->flush();

                    $data = [
                        'id' => $fileContainer->getId(),
                        'filename' => $uploadedFile->getClientOriginalName(),
                    ];
                    $routeInfo = $mapping->route;
                    if (null !== $routeInfo) {
                        $params = [];
                        foreach ($routeInfo['parameters'] as $key => $parameter) {
                            $params[$key] = $parameter === '{id}' ? $fileContainer->getId() : $parameter;
                        }

                        $data['path'] = $this->generateUrl($routeInfo['name'], $params);
                    }

                    return new JsonResponse($data);
                } catch (\Exception $e) {
                    return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
                }
            }

            return new JsonResponse(['error' => $form->getErrors(true)->__toString()], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param Request $request
     *
     * @throws \Exception
     *
     * @return JsonResponse
     */
    public function removeFileAction(Request $request)
    {
        $data = $request->get('afb_remove_file');
        $form = $this->formFactory->create(EntityMappingType::class, [], ['csrf_protection' => false]);
        $form->submit(['mapping' => $data['mapping'], 'fileEntity' => $data['id']]);

        $mapping = $form->getData()['mapping'];
        $object = $form->getData()['fileEntity'];

        $event = new GetResponseRemoveFileEvent($mapping->id, $object);
        if (Kernel::VERSION_ID < 40300) {
            $this->eventDispatcher->dispatch(get_class($event), $event);
        } else {
            $this->eventDispatcher->dispatch($event);
        }
        if ($event->getResponse() !== null) {
            return $event->getResponse();
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->uploadManager->remove(
                $mapping,
                $object
            );

            return new JsonResponse();
        }

        return new JsonResponse([], 401);
    }
}
