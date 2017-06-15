<?php
return call_user_func(
    function () {
        $userCollection = new \Phalcon\Mvc\Micro\Collection();

        $userCollection
            ->setPrefix('/v1/funcionarios')//rotas de api smp no plural
            ->setHandler('\App\Biblioteca\Controllers\FuncionarioController')
            ->setLazy(true);

        $userCollection->get('/', 'getFuncionarios');
        //$userCollection->get('/{id:\d+}', 'getPhone');

        $userCollection->post('/', 'addFuncionarios');

        $userCollection->put('/{id:\d+}', 'editFuncionarios');

        $userCollection->delete('/{id:\d+}', 'deleteFuncionarios');

        return $userCollection;
    }
);
