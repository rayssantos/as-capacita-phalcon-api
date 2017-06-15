<?php
return call_user_func(
    function () {
        $userCollection = new \Phalcon\Mvc\Micro\Collection();

        $userCollection
            ->setPrefix('/v1/emprestimos')//rotas de api smp no plural
            ->setHandler('\App\Biblioteca\Controllers\EmprestimosController')
            ->setLazy(true);

        $userCollection->get('/', 'getEmprestimos');
        $userCollection->get('/{id:\d+}', 'getEmprestimo');

        $userCollection->post('/', 'addEmprestimos');

        $userCollection->put('/{id:\d+}', 'editEmprestimos');

        $userCollection->delete('/{id:\d+}', 'deleteEmprestimos');

        return $userCollection;
    }
);
