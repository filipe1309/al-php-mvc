<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Usuario;
use Alura\Cursos\Infra\EntityManagerCreator;

class RealizarLogin extends ControllerComHtml implements InterfaceControladorRequisicao
{
    private $repositorioDeUsuarios;

    public function __construct()
    {
        $entityManager = (new EntityManagerCreator())->getEntityManager();
        $this->repositorioDeUsuarios = $entityManager->getRepository(Usuario::class);
    }

    public function processaRequisicao(): void
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        
        if (is_null($email) || $email === false) {
            Echo 'E-mail inválido';
            return;
        }

        $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
        $usuario = $this->repositorioDeUsuarios->findOneBy(['email' => $email]);
        if (is_null($usuario) || !$usuario->senhaEstaCorreta($senha)) {
            Echo 'E-mail/Senha inválidos';
            return;
        }

        $_SESSION['logado'] = true;

        header('Location: /listar-cursos');
    }
}