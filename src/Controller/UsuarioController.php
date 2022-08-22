<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route('/usuario')]
class UsuarioController extends AbstractController
{
    #[Route('/', name: 'app_usuario_index', methods: ['GET'])]
    public function index(UsuarioRepository $usuarioRepository): Response
    {
//        $encoders = [new XmlEncoder(), new JsonEncoder()];
//        $normalizers = [new ObjectNormalizer()];
//
//        $serializer = new Serializer($normalizers, $encoders);

        $users = $usuarioRepository->findAll();
//
//        $jsonContent = $serializer->serialize($users, 'json');
        return $this->json($users);
    }

    #[Route('/new', name: 'app_usuario_new', methods: ['POST'])]
    public function new(Request $request, UsuarioRepository $usuarioRepository): Response
    {
        $requestData = $request->toArray();
        $usuario = new Usuario();
        $usuario->setNombre($requestData["nombre"])
                ->setApellido($requestData["apellido"])
                ->setEmail($requestData["email"])
                ->setSexo($requestData["sexo"]);
        $usuarioRepository->add($usuario, true);
        return $this->json($usuario);
    }

    #[Route('/{id}', name: 'app_usuario_show', methods: ['GET'])]
    public function show(Request $request,UsuarioRepository $usuarioRepository): Response
    {
        $id = $request->attributes->get("id");
        $user = $usuarioRepository->findOneBy(["id"=>$id]);
        if(!$user) return $this->json(["message"=>"Usuario no encontrado"]);
        return $this->json($user);
    }

    #[Route('/{id}/edit', name: 'app_usuario_edit', methods: ['PUT'])]
    public function edit(Request $request, UsuarioRepository $usuarioRepository): Response
    {
        $id = $request->attributes->get("id");
        $requestData = $request->toArray();

        $user = $usuarioRepository->findOneBy(["id"=>$id]);
        if(!$user) return $this->json(["message"=>"Usuario no encontrado"]);
        $user->setNombre($requestData["nombre"])
            ->setApellido($requestData["apellido"])
            ->setEmail($requestData["email"])
            ->setSexo($requestData["sexo"]);
        $usuarioRepository->add($user, true);
        return $this->json($user);
    }

    #[Route('/{id}', name: 'app_usuario_delete', methods: ['DELETE'])]
    public function delete(Request $request, Usuario $usuario, UsuarioRepository $usuarioRepository): Response
    {
        $id = $request->attributes->get("id");
        $user = $usuarioRepository->findOneBy(["id"=>$id]);
        if(!$user) return $this->json(["message"=>"Usuario no encontrado"]);
        $usuarioRepository->remove($user, true);
        return $this->json([
            "message"=>"Usuario $id Eliminado"
        ]);
    }
}
