<?php
class Detalle_Subasta extends TwigView {

  public function show($subasta, $mejor_oferta,$usuario) {

      $templateDir="./templates";
      $loader = new Twig_Loader_Filesystem($templateDir);
      $twig = new Twig_Environment($loader);
      $template = $twig->loadTemplate("detalle_subasta.html.twig");
      $template->display(array('rol' => $_SESSION['rol'], 'subasta' => $subasta, 'mejor_oferta' => $mejor_oferta, 'usuario' => $usuario));
    }

}
?>
