<?php

require_once '../../vendor/autoload.php';

use App\Page;

$page = new Page();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si toutes les données nécessaires sont fournies
    if (isset($_POST['email'], $_POST['password'], $_POST['first_name'], $_POST['last_name'], $_POST['postal_nb'], $_POST['role'])) {
        // Préparer les données pour l'insertion dans la base de données
        $data = [
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'postal_nb' => $_POST['postal_nb'],
            'role' => $_POST['role']
        ];

        // Insérer les données dans la base de données
        $page->insert('users', $data);

        // Rediriger vers la page des utilisateurs après l'ajout
        header("Location: users.php");
        exit;
    } else {
        // Gérer le cas où des données sont manquantes
        echo "Veuillez fournir toutes les informations nécessaires.";
    }
}
// Vous devez fournir des données à afficher dans le modèle Twig
echo $page->render('admin/users/list_ajout.html.twig', []);
?>