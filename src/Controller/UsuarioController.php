<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function PHPUnit\Framework\isNull;

#[Route('/usuario')]
class UsuarioController extends AbstractController
{
    #[Route('/', name: 'app_usuario_index', methods: ['GET'])]
    public function index(UsuarioRepository $usuarioRepository): JsonResponse
    {
        $users = $usuarioRepository->findAll();
        return $this->json($users);
    }

    #[Route('/new', name: 'app_usuario_new', methods: ['POST'])]
    public function new(
        Request $request, UsuarioRepository $userRepository, ValidatorInterface $validator
    ): JsonResponse
    {
        try{
            ["nombre"=>$nombre, "apellido"=>$apellido, "email"=>$email, "sexo"=>$sexo] = $request->toArray();
        }catch (\Exception $error){
            return $this->json([
                "message"=>"Todos los campos son requeridos"
            ])->setStatusCode(400);
        }
        $user = new Usuario();
        $user->setNombre($nombre)
            ->setApellido($apellido)
            ->setEmail($email)
            ->setSexo($sexo);
        //Validations
        $errors = $validator->validate($user);
        if(count($errors)>0){
            return $this->json($errors);
        }
        //Save and Response User
        $userRepository->add($user, true);
        return $this->json($user);
    }

    #[Route('/{id}', name: 'app_usuario_show', methods: ['GET'])]
    public function show(Request $request,UsuarioRepository $userRepository): JsonResponse
    {
        $id = $request->attributes->get("id");
        $user = $userRepository->findOneBy(["id"=>$id]);
        if(!$user) return $this->json(["message"=>"Usuario no encontrado"]);
        return $this->json($user);
    }

    #[Route('/{id}/edit', name: 'app_usuario_edit', methods: ['PUT'])]
    public function edit(
        Request $request, UsuarioRepository $userRepository, ValidatorInterface $validator
    ): JsonResponse
    {
        $id = $request->attributes->get("id");
        try{
            ["nombre"=>$nombre, "apellido"=>$apellido, "email"=>$email, "sexo"=>$sexo] = $request->toArray();
        }catch (\Exception $error){
            return $this->json([
                "message"=>"Todos los campos son requeridos"
            ])->setStatusCode(400);
        }
        $user = $userRepository->findOneBy(["id"=>$id]);
        if(!$user) return $this->json(["message"=>"Usuario no encontrado"]);
        $user->setNombre($nombre)
            ->setApellido($apellido)
            ->setEmail($email)
            ->setSexo($sexo);
        //Validations
        $errors = $validator->validate($user);
        if(count($errors)>0){
            return $this->json($errors);
        }
        //Save and Return user
        $userRepository->add($user, true);
        return $this->json($user);
    }

    #[Route('/{id}', name: 'app_usuario_delete', methods: ['DELETE'])]
    public function delete(Request $request, Usuario $usuario, UsuarioRepository $usuarioRepository): JsonResponse
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
