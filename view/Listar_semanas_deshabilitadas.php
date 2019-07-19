<?php
class listar_semanas_deshabilitadas extends TwigView {

    public function show($reservas, $usuario) {

	    $templateDir="./templates";
	    $loader = new Twig_Loader_Filesystem($templateDir);
	    $twig = new Twig_Environment($loader);
    	$template = $twig->loadTemplate("listar_semanas_deshabilitadas.html.twig");
    	$template->display(array('rol' => $_SESSION['rol'], 'reservas' => $reservas, 'usuario' => $usuario));
    }
}
?>
