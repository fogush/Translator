<?php

namespace App\Controller;

use App\Exception\StorageException;
use App\Form\Handler\TranslatorHandler;
use App\Form\Type\TranslatorType;
use App\Translator\StorageInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TranslatorController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(Request $request, TranslatorHandler $translatorHandler, StorageInterface $storage): Response
    {
        $form = $this->createForm(TranslatorType::class);

        try {
            $form->setData($storage->get());

            if ($translatorHandler->handle($form, $request)) {
                $this->addFlash('success', 'Data were saved');
                return $this->redirectToRoute('app_translator_index');
            }
        } catch (StorageException $exception) {
            $this->addFlash('danger', 'An error occurred: ' . $exception->getMessage());
        }

        return $this->render('translator/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
