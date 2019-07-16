<?php
class Modificar_datos_propiedad extends TwigView {

  public function show($propiedades, $fotos) {

      $templateDir="./templates";
      $loader = new Twig_Loader_Filesystem($templateDir);
      $twig = new Twig_Environment($loader);
      $template = $twig->loadTemplate("modificar_datos_propiedad.html.twig");
      $template->display(array('rol' => $_SESSION['rol'], 'propiedad' => $propiedades, 'fotos' => $fotos));
    }

}
?>
