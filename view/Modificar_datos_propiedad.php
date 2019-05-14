<?php
class Listar_propiedades extends TwigView {

  public function show($propiedades) {

      $templateDir="./templates";
      $loader = new Twig_Loader_Filesystem($templateDir);
      $twig = new Twig_Environment($loader);
      $template = $twig->loadTemplate("modificar_datos_propiedad.html.twig");
      $template->display(array('rol' => $_SESSION['rol'], 'propiedades' => $propiedades));
    }

}
?>
