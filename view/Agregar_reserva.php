<?php
class Agregar_reserva extends TwigView {

  public function show($propiedades) {

      $templateDir="./templates";
      $loader = new Twig_Loader_Filesystem($templateDir);
      $twig = new Twig_Environment($loader);
      $template = $twig->loadTemplate("agregar_reserva.html.twig");
      $template->display(array('rol' => $_SESSION['rol'], 'propiedad' => $propiedades));
    }

}
?>
