<?php
class Agregar_usuario extends TwigView {

  public function show() {

      $templateDir="./templates";
      $loader = new Twig_Loader_Filesystem($templateDir);
      $twig = new Twig_Environment($loader);
      $template = $twig->loadTemplate("agregar_usuario.html.twig");
      $template->display(array('rol' => $_SESSION['rol']));
    }

}
?>
