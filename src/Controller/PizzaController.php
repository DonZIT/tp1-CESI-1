<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Pizza;
use App\Form\PizzaType;
use App\Dto\PizzaBaseDto;
use App\Service\PizzaManager;
use App\Repository\PizzaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PizzaController extends AbstractController
{

    private $pizzaManager;

    public function __construct(PizzaManager $pizzaManager)
    {
        $this->pizzaManager = $pizzaManager;
    }

    #[Route('/pizza', name: 'app_pizza_list', methods: ['GET', 'POST'])]
    public function list(PizzaRepository $pizzaRepository): Response
    {
        $pizzas = $pizzaRepository->findAll();

        return $this->render('pizza/index.html.twig', [
            'pizzas' => $pizzas,
        ]);
    }

    #[Route('/pizza-new', name: 'app_pizza_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $pizzaDto = new PizzaBaseDto();
        $form = $this->createForm(PizzaType::class, $pizzaDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->pizzaManager->createPizza($pizzaDto->name, $pizzaDto->price);

            return $this->redirectToRoute('app_pizza_list');
        }

        return $this->render('pizza/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/pizza-edit/{id}', name: 'app_pizza_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pizza $pizza): Response
    {
        $pizzaDto = new PizzaBaseDto();
        $pizzaDto->name = $pizza->getName();
        $pizzaDto->price = $pizza->getPrice();

        $form = $this->createForm(PizzaType::class, $pizzaDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->pizzaManager->updatePizza($pizza, $pizzaDto->name, $pizzaDto->price);

            return $this->redirectToRoute('app_pizza_list');
        }

        return $this->render('pizza/edit.html.twig', [
            'pizza' => $pizza,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/pizza-delete/{id}', name: 'app_pizza_delete', methods: ['POST'])]
    public function delete(Request $request, Pizza $pizza): Response
    {
        if ($this->isCsrfTokenValid('delete' . $pizza->getId(), $request->request->get('_token'))) {
            $this->pizzaManager->deletePizza($pizza);
        }

        return $this->redirectToRoute('app_pizza_list');
    }
}
