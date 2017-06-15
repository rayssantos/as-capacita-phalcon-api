<?php
return call_user_func(
    function () {
        $userCollection = new \Phalcon\Mvc\Micro\Collection();

        $userCollection
            ->setPrefix('/v1/alunos')
            ->setHandler('\App\Biblioteca\Controllers\AlunosController')
            ->setLazy(true);

        $userCollection->get('/', 'getAlunos');
        $userCollection->get('/{id:\d+}', 'getAluno');

        $userCollection->post('/', 'addAlunos');

        $userCollection->put('/{id:\d+}', 'editAlunos');

        $userCollection->delete('/{id:\d+}', 'deleteAlunos');

        return $userCollection;
    }
);
