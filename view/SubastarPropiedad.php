<?php
class Subastarpropiedad extends TwigView {

  public function show($propiedad) {

      $templateDir="./templates";
      $loader = new Twig_Loader_Filesystem($templateDir);
      $twig = new Twig_Environment($loader);
      $template = $twig->loadTemplate("agregar_subasta.html.twig");
      $template->display(array('rol' => $_SESSION['rol'], 'propiedad' => $propiedad));
    }

}
?>
