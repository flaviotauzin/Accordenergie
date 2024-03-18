<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    $page = new Page();

    $msg = null;

    if (isset($_GET['logout']) && $_GET['logout'] == true) {
        // Détruire la session ou effectuer toute autre logique de déconnexion
        session_destroy();
        // Rediriger vers la page d'accueil ou une autre page après la déconnexion
        header('Location: index.php');
        exit();
    }

    if(isset($_POST['send'])) {

        $user = $page->getUserByEmail($_POST['email']);

        if(!$user) {
            $msg = "Email ou mot de passe incorrect !";
        }
        else {
            if( !password_verify($_POST['password'], $user['password']) ) {
                $msg = "Email ou mot de passe incorrect !";
            }
            else {
                $msg = "Connecté !";
                $page->session->add('user', $user);
                if ($page->hasRole('admin')) {
                    header('Location: admin.php');
                } elseif ($page->hasRole('client')) {
                    header('Location: client.php');
                } elseif ($page->hasRole('intervenant')) {
                    header('Location: intervenant.php');
                } elseif ($page->hasRole('standardiste')) {
                    header('Location: standardiste.php');
                } else {
                    // Redirection par défaut ou message d'erreur
                }
                $_SESSION['user'] = $user;
              //  header('Location: profil.php');
            }
        }

    }

    echo $page->render('index.html.twig', [
        "msg" => $msg

    ]);