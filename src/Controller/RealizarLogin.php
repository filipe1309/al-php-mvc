<?php

namespace Alura\Cursos\Controller;

use Nyholm\Psr7\Response;
use Alura\Cursos\Entity\Usuario;
use Psr\Http\Message\ResponseInterface;
use Doctrine\ORM\EntityManagerInterface;
use Alura\Cursos\Helper\FlashMessageTrait;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Alura\Cursos\Helper\RenderizadorDeHtmlTrait;

class RealizarLogin implements RequestHandlerInterface
{
    use RenderizadorDeHtmlTrait, FlashMessageTrait;
 
    private $repositorioDeUsuarios;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $entityManager = $entityManager;
        $this->repositorioDeUsuarios = $entityManager->getRepository(Usuario::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $post = $request->getParsedBody();
        $email = filter_var($post['email'], FILTER_VALIDATE_EMAIL);

        if (is_null($email) || $email === false) {
            $this->defineMessagem('danger', 'E-mail inválido');
            return new Response(302, ['Location' => '/login']);
        }

        $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
        $usuario = $this->repositorioDeUsuarios->findOneBy(['email' => $email]);
        if (is_null($usuario) || !$usuario->senhaEstaCorreta($senha)) {
            $this->defineMessagem('danger', 'E-mail/Senha inválidos');
            return new Response(302, ['Location' => '/login']);
        }

        $_SESSION['logado'] = true;

        return new Response(302, ['Location' => '/listar-cursos']);
    }
}