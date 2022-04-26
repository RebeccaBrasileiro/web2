<?php
class Form
{
  private $message = "";
  public function __construct()
  {
    Transaction::open();
  }
  public function controller()
  {
    $form = new Template("view/form.html");
    $this->message = $form->saida();
  }
  public function salvar()
  {
    if (isset($_POST["nome"]) && isset($_POST["mensagem"]) && isset($_POST["datahora"])) {
      try {
        $conexao = Transaction::get();
        $mural = new Crud("mural");
        $nome = $conexao->quote($_POST["nome"]);
        $mensagem = $conexao->quote($_POST["mensagem"]);
        $datahora = $conexao->quote($_POST["datahora"]);
        $resultado = $mural->insert("nome, mensagem, datahora", "$nome, $mensagem, $datahora");
      } catch (Exception $e) {
        echo $e->getMessage();
      }
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