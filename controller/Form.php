<?php
class Form
{
  public function __construct()
  {
    Transaction::open();
  }
  public function controller()
  {
    $form = new Template("view/form.html");
    $retorno["msg"] = $form->saida();
    return $retorno;
  }

  public function salvar()
  {
    if (isset($_POST["referente"]) && isset($_POST["empresa"]) && isset($_POST["vencimento"])) {
      try {
        $conexao = Transaction::get();
        $referente = $conexao->quote($_POST["referente"]);
        $empresa = $conexao->quote($_POST["empresa"]);
        $vencimento = $conexao->quote($_POST["vencimento"]);
        $crud = new Crud();
        if (empty($_POST["id"])) {
          $retorno = $crud->insert(
            "contas",
            "referente,empresa,vencimento",
            "{$referente},{$empresa},{$vencimento}"
          );
        } else {
          $id = $conexao->quote($_POST["id"]);
          $retorno = $crud->update(
            "contas",
            "referente={$referente}, empresa={$empresa}, vencimento={$vencimento}",
            "id={$id}"
          );
        }
      } catch (Exception $e) {
        $retorno["msg"] = "Ocorreu um erro! " . $e->getMessage();
        $retorno["erro"] = TRUE;
      }
    } else {
      $retorno["msg"] = "Preencha todos os campos! ";
      $retorno["erro"] = TRUE;
    }
    return $retorno;
  }
  public function __destruct()
  {
    Transaction::close();
  }
}
