<?php
return call_user_func(
    function () {
        $userCollection = new \Phalcon\Mvc\Micro\Collection();

        $userCollection
            ->setPrefix('/v1/autores')//rotas de api smp no plural
            ->setHandler('\App\Biblioteca\Controllers\AutorController')
            ->setLazy(true);

        $userCollection->get('/', 'getAutores');
        //$userCollection->get('/{id:\d+}', 'getPhone');

        $userCollection->post('/', 'addAutores');

        $userCollection->put('/{id:\d+}', 'editAutores');

        $userCollection->delete('/{id:\d+}', 'deleteAutores');

        return $userCollection;
    }
);
