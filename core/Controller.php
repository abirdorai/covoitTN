<?php
/**
 * Classe Controller - Classe mere de tous les controleurs
 * Fournit la methode render() pour afficher une vue avec un layout commun.
 */
abstract class Controller
{
    /**
     * Charge un fichier de vue avec des variables.
     * @param string $view Chemin de la vue (ex: 'home/index')
     * @param array  $data Tableau associatif passe a la vue
     * @param bool   $withLayout Inclure le header / footer ?
     */
    protected function render($view, $data = [], $withLayout = true)
    {
        // Extraction du tableau en variables locales accessibles dans la vue
        extract($data);

        $viewFile = __DIR__ . '/../views/' . $view . '.php';
        if (!file_exists($viewFile)) {
            die("Vue introuvable : $view");
        }

        if ($withLayout) {
            require __DIR__ . '/../views/layouts/header.php';
            require $viewFile;
            require __DIR__ . '/../views/layouts/footer.php';
        } else {
            require $viewFile;
        }
    }

    /**
     * Redirige vers une URL relative.
     */
    protected function redirect($url)
    {
        header('Location: ' . BASE_URL . $url);
        exit;
    }

    /**
     * Verifie qu'un utilisateur est connecte. Sinon, redirection vers login.
     */
    protected function requireLogin()
    {
        if (!isset($_SESSION['user'])) {
            $_SESSION['flash_error'] = "Vous devez etre connecte pour acceder a cette page.";
            $this->redirect('?controller=auth&action=login');
        }
    }

    /**
     * Verifie qu'un utilisateur a un role specifique.
     */
    protected function requireRole($role)
    {
        $this->requireLogin();
        if ($_SESSION['user']['role'] !== $role) {
            $_SESSION['flash_error'] = "Acces refuse. Role requis : $role.";
            $this->redirect('');
        }
    }
}
