<?php
class agregar_tarjeta extends TwigView {

  public function show() {

      $templateDir="./templates";
      $loader = new Twig_Loader_Filesystem($templateDir);
      $twig = new Twig_Environment($loader);
      $template = $twig->loadTemplate("agregar_tarjeta.html.twig");
      $template->display(array('rol' => $_SESSION['rol'], 'usuario' => $_SESSION['usuario']));
    }

}
?>
