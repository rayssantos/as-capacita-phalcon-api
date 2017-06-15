<?php
return call_user_func(
    function () {
        $userCollection = new \Phalcon\Mvc\Micro\Collection();

        $userCollection
            ->setPrefix('/v1/bibliotecas')//rotas de api smp no plural
            ->setHandler('\App\Biblioteca\Controllers\BibliotecaController')
            ->setLazy(true);

        $userCollection->get('/', 'getBibliotecas');
        $userCollection->get('/{id:\d+}', 'getPhone');

        $userCollection->post('/', 'addBibliotecas');

        //$userCollection->put('/{id:\d+}', 'editEmprestimos');

        //$userCollection->delete('/{id:\d+}', 'deleteEmprestimos');

        return $userCollection;
    }
);
