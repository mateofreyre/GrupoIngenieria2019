<?php
class Listar_usuarios extends TwigView {

  public function show($usuarios) {

      $templateDir="./templates";
      $loader = new Twig_Loader_Filesystem($templateDir);
      $twig = new Twig_Environment($loader);
      $template = $twig->loadTemplate("listar_usuarios.html.twig");
      $template->display(array('rol' => $_SESSION['rol'], 'usuarios' => $usuarios));
    }

}
?>
