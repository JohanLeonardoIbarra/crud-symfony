<?php

namespace App\Controller;

use App\Repository\UsuarioRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Document\Pedido;

class PedidoController extends AbstractController
{
    /**
     * Retorna los pedidos de un usuario, o deberia
    */
    #[Route('/pedido/{email}', name: 'app_pedido', methods: ["GET"])]
    public function index(Request $request, UsuarioRepository $usuarioRepository, DocumentManager $documentManager): JsonResponse
    {
        $email = $request->attributes->get("email");
        $usuario = $usuarioRepository->findOneBy(["email"=>$email]);
        $pedidos = $documentManager->getDocumentCollection(Pedido::class)
            ->find(["user_id"=>$usuario->getId()]);
        return $this->json($pedidos);
    }
}
