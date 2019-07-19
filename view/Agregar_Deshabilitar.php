<?php
class Agregar_Deshabilitar extends TwigView {

  public function show($propiedades) {

      $templateDir="./templates";
      $loader = new Twig_Loader_Filesystem($templateDir);
      $twig = new Twig_Environment($loader);
      $template = $twig->loadTemplate("agregar_deshabilitacion.html.twig");
      $template->display(array('rol' => $_SESSION['rol'], 'propiedad' => $propiedades));
    }

}
?>
