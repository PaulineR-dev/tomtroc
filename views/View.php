<?php

/**
 * Cette classe génère les vues en fonction de ce que chaque contrôleur lui passe en paramètre.
 */
class View 
{
    /**
     * Le titre de la page.
     */
    private string $title;
    
    /**
     * Constructeur.
     */
    public function __construct(string $title) 
    {
        $this->title = $title;
    }
    
    /**
     * Cette méthode retourne une page complète.
     */
    public function render(string $viewFileName, array $parameters = []) : void 
    {
        // On construit le chemin vers la vue demandée
        $viewFilePath = $this->buildViewFilePath($viewFileName);
        
        // Ces deux variables sont utilisées dans le layout principal
        $content = $this->renderViewFromTemplate($viewFilePath, $parameters);
        $title   = $this->title;

        ob_start();
        require MAIN_VIEW_PATH;
        echo ob_get_clean();
    }
    
    /**
     * Génère le contenu de la vue demandée.
     */
    private function renderViewFromTemplate(string $viewFilePath, array $parameters = []) : string
    {  
        if (file_exists($viewFilePath)) {
            extract($parameters);
            ob_start();
            require $viewFilePath;
            return ob_get_clean();
        } else {
            throw new Exception("La vue '$viewFilePath' est introuvable.");
        }
    }

    /**
     * Construit le chemin vers la vue demandée.
     */
    private function buildViewFilePath(string $viewFileName) : string
    {
        return TEMPLATE_VIEW_PATH . $viewFileName . '.php';
    }
}