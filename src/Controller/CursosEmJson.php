<?php

namespace Alura\Cursos\Controller;

use Nyholm\Psr7\Response;
use Alura\Cursos\Entity\Curso;
use Psr\Http\Message\ResponseInterface;
use Doctrine\ORM\EntityManagerInterface;
use Alura\Cursos\Helper\FlashMessageTrait;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Alura\Cursos\Helper\RenderizadorDeHtmlTrait;


class CursosEmJson implements RequestHandlerInterface
{
    private $repositorioDeUsuarios;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $entityManager = $entityManager;
        $this->repositorioDeUsuarios = $entityManager->getRepository(Curso::class);
    }
     
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $cursos =  $this->repositorioDeUsuarios->findAll();

        return new Response(200, ['Content-type' => 'application/json'], json_encode($cursos));
    }
}