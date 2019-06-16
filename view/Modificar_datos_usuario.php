<?php
class Modificar_datos_usuario extends TwigView {

  public function show($usuarios) {

      $templateDir="./templates";
      $loader = new Twig_Loader_Filesystem($templateDir);
      $twig = new Twig_Environment($loader);
      $template = $twig->loadTemplate("modificar_datos_usuario.html.twig");
      $template->display(array('rol' => $_SESSION['rol'], 'usuario' => $usuarios));
    }

}
?>
