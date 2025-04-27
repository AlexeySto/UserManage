<?php

namespace Alexey\MyProdject\Application;

use Exception;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Render {

    private string $viewFolder = '/Domain/Views/';
    private FilesystemLoader $loader;
    private Environment $environment;


    public function __construct(){

        $this->loader = new FilesystemLoader(dirname(__DIR__) . $this->viewFolder);
        $this->environment = new Environment($this->loader, [
        'cache' => $_SERVER['DOCUMENT_ROOT'].'/cache/',
        ]);
    }

    public function renderPage(string $contentTemplateName = 'page-index.twig', array $templateVariables = []): string {
        $template = $this->environment->load('main.twig');
        
        $templateVariables['style_name'] = 'Styles/style.css';
        $templateVariables['user_name'] = (isset($_SESSION['user_name']) && !empty($_SESSION['user_name'])) ? $_SESSION['user_name'] : '';
        $templateVariables['header_name'] = 'header.twig';
        $templateVariables['nav_name'] = 'nav.twig';
        $templateVariables['content_template_name'] = $contentTemplateName;
        $templateVariables['sidebar_name'] = 'sidebar.twig';
        $templateVariables['footer_name'] = 'footer.twig';

        return $template->render($templateVariables);
    }

    public function renderError(string $viewName) : string {
        $template = $this->environment->load($viewName);
        return $template->render();
    }
}
