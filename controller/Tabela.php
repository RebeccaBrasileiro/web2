<?php
class Tabela
{
  private $message = "";
  public function __construct()
  {
    Transaction::open();
  }
  public function controller()
  {
    Transaction::get();
    $mural = new Crud("mural");
    $resultado = $mural->select();
    $tabela = new Template("view/tabela.html");

    if (is_array($resultado)) {
      $tabela->set("linha", $resultado);
      $this->message = $tabela->saida();
    }
  }
  public function remover()
  {
    try {
      $conexao = Transaction::get();
      $id = $conexao->quote($_GET["id"]);
      $mural = new Crud("mural");
      $resultado = $mural->delete("id = $id");
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }
  public function getMessage()
  {
    return $this->message;
  }
  public function __destruct()
  {
    Transaction::close();
  }
}