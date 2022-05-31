<?php
class Form
{
  private $message = "";
  private $error = "";
  public function __construct()
  {
    Transaction::open();
  }
  public function controller()
  {
    $form = new Template("restrict/view/form.html");
    $form->set("id", "");
    $form->set("nome", "");
    $form->set("mensagem", "");
    $form->set("datahora", "");
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
        if (empty($_POST["id"])) {
          $mural->insert(
            "nome, mensagem, datahora",
            "$nome, $mensagem, $datahora"
          );
        } else {
          $id = $conexao->quote($_POST["id"]);
          $mural->update(
            "nome = $nome, mensagem = $mensagem, datahora = $datahora",
            "id = $id"
          );
        }
        $this->message = $mural->getMessage();
        $this->error = $mural->getError();
      } catch (Exception $e) {
        $this->message = $e->getMessage();
        $this->error = true;
      }
    } else {
      $this->message = "Campos não informados!";
      $this->error = true;
    }
  }
  public function editar(){
    if(isset($_GET["id"])){
      try{
        $conexao= Transaction::get();
        $id = $conexao->quote($_GET["id"]);
        $mural = new Crud("mural");
        $resultado = $mural->select("*", "id = $id");
        if (!$mural->getError()) {
        $form = new Template("restrict/view/form.html");
        foreach ($resultado[0] as $cod => $valor) {
          $form->set($cod, $valor);
        }
        $this->message = $form->saida();
      } else {
        $this->message = $mural->getMessage();
        $this->error = true;
      }
    } catch (Exception $e) {
      $this->message = $e->getMessage();
      $this->error = true;
    }
  }
}
public function getMessage()
{
  if (is_string($this->error)) {
    return $this->message;
  } else {
    $msg = new Template("shared/view/msg.html");
    if ($this->error) {
      $msg->set("cor", "danger");
    } else {
      $msg->set("cor", "success");
    }
    $msg->set("msg", $this->message);
    $msg->set("uri", "?class=Tabela");
    return $msg->saida();
  }
}
public function __destruct()
{
  Transaction::close();
}
}