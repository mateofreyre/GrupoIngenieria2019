<?php
class Agregar_propiedad extends TwigView {

  public function show() {

      $templateDir="./templates";
      $loader = new Twig_Loader_Filesystem($templateDir);
      $twig = new Twig_Environment($loader);
      $template = $twig->loadTemplate("agregar_propiedad.html.twig");
      $template->display(array('rol' => $_SESSION['rol']));
    }

}
?>
