<?php
class listar_tarjetas extends TwigView {

    public function show($tarjetas) {

	    $templateDir="./templates";
	    $loader = new Twig_Loader_Filesystem($templateDir);
	    $twig = new Twig_Environment($loader);
    	$template = $twig->loadTemplate("listar_tarjetas.html.twig");
    	$template->display(array('rol' => $_SESSION['rol'], 'tarjetas' => $tarjetas));
    }
}
?>
