    <?php
    return call_user_func(
    function () {
        $userCollection = new \Phalcon\Mvc\Micro\Collection();

        $userCollection
            ->setPrefix('/v1/livros')//rotas de api smp no plural
            ->setHandler('\App\Biblioteca\Controllers\LivrosController')
            ->setLazy(true);

        $userCollection->get('/', 'getLivros');

        $userCollection->get('/{id:\d+}', 'getLivro');

        $userCollection->post('/', 'addLivro');

        $userCollection->put('/{id:\d+}', 'editLivros');

        $userCollection->delete('/{id:\d+}', 'deleteLivros');

        return $userCollection;
    }
    );
