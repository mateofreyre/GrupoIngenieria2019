<?php
class Mostrar_precios extends TwigView {

  public function show($suscripcion, $usuario) {

      $templateDir="./templates";
      $loader = new Twig_Loader_Filesystem($templateDir);
      $twig = new Twig_Environment($loader);
      $template = $twig->loadTemplate("mostrar_precios.html.twig");
      $template->display(array('rol' => $_SESSION['rol'], 'suscripcion' => $suscripcion, 'usuario' => $usuario));
    }

}
?>
