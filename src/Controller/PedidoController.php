<?php

namespace App\Controller;

use App\Repository\UsuarioRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Document\Pedido;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function PHPUnit\Framework\isNull;

class PedidoController extends AbstractController
{
    /**
     * Retorna los pedidos de un usuario, o deberia
    */
    #[Route('/pedido/list/{email}', name: 'app_pedido', methods: ["GET"])]
    public function index(string $email, UsuarioRepository $usuarioRepository, DocumentManager $documentManager): JsonResponse
    {
        try{
            $user = $usuarioRepository->findOneBy(["email"=>$email]);
            if(!$user) return $this->json([ "message"=>"Usuario no registrado" ]);
            $pedidos = $documentManager->getRepository(Pedido::class)
                ->findBy(["user_id"=>$user->getId()]);
            return $this->json($pedidos);
        }catch(\Exception $error){
            return $this->json([
                "message"=>$error->getMessage()
            ]);
        }
    }

    #[Route("/pedido/new", name: "app_pedido_new", methods: ["POST"])]
    public function new(
        Request $request, DocumentManager $documentManager, UsuarioRepository $userRepository, ValidatorInterface $validator
    ): JsonResponse
    {
        try{
            ["producto"=>$product, "cantidad"=>$quantity, "email_usuario"=>$userMail, "precio_unitario"=>$unitaryPrice] = $request->toArray();
        }catch (\Exception $error){
            return $this->json([
                "message"=>"Todos los campos son requeridos"
            ]);
        }
        $user = $userRepository->findOneBy(["email"=>$userMail]);
        if(!$user) return $this->json([ "message"=>"Usuario no registrado" ]);

        $pedido = new Pedido();
        $pedido->setNombreProducto($product)
            ->setCantidad($quantity)
            ->setUserId($user->getId())
            ->setPrecioUnitario($unitaryPrice);

        $errors = $validator->validate($pedido);
        if(count($errors)>0){
            return $this->json($errors);
        }
        $documentManager->persist($pedido);
        $documentManager->flush();
        return $this->json($pedido);
    }

    #[Route("pedido/{id}", name:"app_find_pedido", methods: ["GET"])]
    public function find(string $id, DocumentManager $documentManager):JsonResponse
    {
        $pedido = $documentManager->getRepository(Pedido::class)
            ->findOneBy(["id"=>$id]);
        if(!$pedido) return $this->json(["message"=>"Pedido no encontrado"]);
        return $this->json($pedido);
    }

    #[Route("pedido/{id}/edit", name:"app_edit_pedido", methods: ["PUT"])]
    public function edit(string $id, Request $request, DocumentManager $documentManager):JsonResponse
    {
        try{
            ["producto"=>$product, "cantidad"=>$quantity, "precio_unitario"=>$unitaryPrice] = $request->toArray();
        }catch (\Exception $error){
            return $this->json([
                "message"=>"Todos los campos son requeridos"
            ]);
        }
        $pedido = $documentManager->getRepository(Pedido::class)
            ->find($id);
        if(!$pedido) return $this->json(["message"=>"Pedido no encontrado"]);
        $pedido->setNombreProducto($product)
            ->setCantidad($quantity)
            ->setPrecioUnitario($unitaryPrice);
        $documentManager->persist($pedido);
        $documentManager->flush();
        return $this->json([
            "message"=>"pedido Actualizado",
            "pedido"=>$pedido
        ]);
    }

    #[Route("pedido/{id}", name: "app_delete_pedido", methods: ["DELETE"])]
    public function delete(string $id, DocumentManager $documentManager):JsonResponse
    {
        $pedido = $documentManager->getRepository(Pedido::class)
            ->find($id);
        if(!$pedido) return $this->json(["message"=>"Pedido no encontrado"]);
        $documentManager->remove($pedido);
        $documentManager->flush();
        return $this->json([
            "message"=>"Pedido eliminado",
            "pedido"=>$pedido
        ]);
    }
}


