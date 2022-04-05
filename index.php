<?php
   //auto load
   spl_autoload_extensions('.php');
   function classLoader($class)
    {
       $nomeArquivo = $class . '.php';
       $pastas = array('controller','model');
       foreach ($pastas as $pastas){
           $arquivo = "{$pastas}/{$nomeArquivo}";
           if (file_exists($arquivo)) {
               require_once($arquivo);
           }
           
       }
    }
    spl_autoload_register('classLoader');

    //Front Controller

    class Aplicacao
    {
        public static function run ()
        {
            $layout = new Template('view/layout.html');
            $class = "Inicio";
            if(class_exists($class)){
                $pagina = new $class();
                $conteudo = $pagina->controller();
                $layout->set('conteudo', $conteudo);
            }
            echo $layout->saida();
        }
    }
    Aplicacao::run();

?>