<?php
namespace App\Biblioteca\Models;

class Emprestimos extends \App\Models\BaseModel
{
    public $idEmprestimo;

    public $Aluno_idAluno;

    public $dataEmprestimo;

    public $Livro_idLivro;

    public $id_funcionario;
}
