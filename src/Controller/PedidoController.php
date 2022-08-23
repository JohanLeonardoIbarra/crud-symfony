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
    #[Route('/pedido/{email}', name: 'app_pedido', methods: ["GET"])]
    public function index(Request $request, UsuarioRepository $usuarioRepository, DocumentManager $documentManager): JsonResponse
    {
        try{
            $email = $request->attributes->get("email");
            $user = $usuarioRepository->findOneBy(["email"=>$email]);
            $pedidos = $documentManager->getDocumentCollection(Pedido::class)
                ->find(["user_id"=>$user->getId()]);
            return $this->json($pedidos);
        }catch(\Exception $error){
            return $this->json([
                "message"=>$error->getMessage()
            ]);
        }
    }

    #[Route("/pedido/new", name: "app_pedido_new")]
    public function new(
        Request $request, DocumentManager $documentManager, UsuarioRepository $userRepository, ValidatorInterface $validator
    ){
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
}
