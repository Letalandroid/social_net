<?php

require_once '../controller/Usuario.php';

use Letalandroid\controllers\Usuario;

$error = false;
$message = '';
$user;

if (
    isset($_POST['correo']) &&
    isset($_POST['password'])
) {

    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $allUsers = Usuario::getAll();

    foreach ($allUsers as $u) {
        if ($u->getCorreo() == $correo) {
            $error = true;
            $message = 'Correo electrónico ya registrado, intenta con otro.';
            break;
        }
    }

    if (!$error) {
        Usuario::add($correo, $password);
        $user = Usuario::getLastId();
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/logo.png" type="image/x-icon">
    <title>Social Net | Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        background: '#332B27',
                        dark: '#1F1A17',
                        inline: '#584940'
                    }
                }
            }
        }
    </script>
    <script>
        if (localStorage.getItem('id_user') !== null) {
            location.href = '/social_net';
        }

        <?php if (!$error && isset($user)) { ?>
            localStorage.setItem('id_user', <?php echo $user[0]->getId() ?>);
            location.href = '/social_net';
        <?php } ?>
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body class="bg-background">
    <?php if ($error) { ?>
        <div class="alert alert-danger m-3" role="alert">
            <?php echo $message ?>
        </div>
    <?php } ?>
    <main class="w-full h-screen flex flex-col justify-center items-center gap-3">
        <h1 class="text-white font-bold text-center text-3xl">Register</h1>
        <form action="/social_net/register/index.php" method="post" class="flex flex-col w-96 gap-3">
            <input required class="bg-transparent outline-0 border-4 border-inline p-2 rounded text-white" type="email" placeholder="Correo" name='correo'>
            <input required class="bg-transparent outline-0 border-4 border-inline p-2 rounded text-white" type="password" placeholder="Contraseña" name='password'>
            <input class="bg-inline text-white font-bold py-3 rounded hover:bg-[#6f6159] transition" type="submit" value="Registrarse">
        </form>
        <p class='text-white'>¿Ya estás registrado? <a class="font-bold underline text-[#6f6159]" href="../login/">Logueate</a></p>
    </main>
</body>

</html>