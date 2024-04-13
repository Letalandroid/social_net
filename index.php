<?php

require_once '/home/letalandroid/Letalandroid/programming/php/social_net/controller/Usuario.php';
require_once '/home/letalandroid/Letalandroid/programming/php/social_net/controller/Post.php';
require_once '/home/letalandroid/Letalandroid/programming/php/social_net/controller/Reactions.php';
require_once '/home/letalandroid/Letalandroid/programming/php/social_net/controller/Chats.php';

use Letalandroid\controllers\Usuario;
use Letalandroid\controllers\Post;
use Letalandroid\controllers\Reactions;
use Letalandroid\controllers\Chats;

$user;
$error = true;
$user_id = (int)$_COOKIE['user_id'];
$posts = Post::getAll();

if (isset($_POST['descripcion']) && $_POST['type'] === 'post') {

    $descripcion = $_POST['descripcion'];

    try {

        Post::add($user_id, $descripcion);
        $error = false;
    } catch (ErrorException $ex) {
        echo "<script>
                alert('Error al publicar');
              </script>";
        echo $ex;
    }
} elseif (isset($_POST['descripcion']) && $_POST['type'] === 'chat') {

    $descripcion = $_POST['descripcion'];
    $post_id = $_POST['post_id'];

    try {

        Chats::add($post_id, $user_id, $descripcion);
        $error = false;
    } catch (ErrorException $ex) {
        echo "<script>
                alert('Error al publicar');
              </script>";
        echo $ex;
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/logo.png" type="image/x-icon">
    <title>Social Net</title>
    <script>
        if (localStorage.getItem('id_user') == null) {
            location.href = '/login';
        } else {
            document.cookie = `user_id=${localStorage.getItem('id_user')}`;
        }
    </script>
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
    <script src="https://kit.fontawesome.com/8b1c082df7.js" crossorigin="anonymous"></script>
    <script>
        <?php if (!$error) { ?>
            location.href = '/';
        <?php } ?>
    </script>
</head>

<body class="bg-background">
    <?php $user = Usuario::getUser((int)$_COOKIE['user_id'])[0]->getUsername() ?>
    <header class="bg-dark">
        <div class="flex justify-between w-full p-5">
            <a class="cursor-default" href="/">
                <img class="w-16 rounded-full" src="./assets/logo.png" alt="logo" />
            </a>
            <div id="profile" class='relative z-10'>
                <img src='./assets/profile.svg' alt="profile" class="w-16 h-16 bg-[#fff] rounded-full" />
                <div id="account" class='hidden flex flex-col gap-1 w-44 bg-dark px-5 py-2 border
                absolute -bottom-28 right-0 text-right rounded'>
                    <span class='text-white'><?= $user ?></span>
                    <hr />
                    <button id="closedSession" class='w-full font-bold flex
                    justify-center bg-[#f00] my-2 py-1 text-white rounded'>
                        Cerrar sesión
                    </button>
                </div>
            </div>
        </div>
    </header>
    <main class='pb-3'>
        <div class='flex flex-col justify-center items-center'>
            <form action="index.php" method="post" class="flex justify-center items-start mt-3 px-6
            py-5 gap-5 bg-[#3b332f] rounded">
                <div class="flex flex-col gap-1">
                    <span class='text-white'>
                        <?= $user ?>
                    </span>
                    <img width="50" class="bg-[#888] rounded-full" src="./assets/profile.svg" alt="profile">
                </div>
                <div class='flex flex-col gap-5 relative'>
                    <input name="type" value="post" hidden type="text">
                    <input name="descripcion" class="bg-transparent w-60 border-b-2 pb-2 pl-1
                    outline-0 text-white border-white rounded" placeholder="¿Que piensas el día de hoy?" type="text">
                    <div class='flex justify-end'>
                        <button class='bg-dark text-white hover:bg-inline
                        transition px-3 py-2 rounded'>
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </form>
            <?php foreach ($posts as $post) { ?>
                <div>
                    <div class="flex justify-center items-start mt-3 px-4
                                py-5 pb-2 gap-5 bg-[#3b332f] rounded">
                        <div class="flex flex-col gap-1">
                            <span class='text-white'>
                                <?= $post->getUsername() ?>
                            </span>
                            <img width="50" class="bg-[#888] rounded-full" src="./assets/profile.svg" alt="profile">
                        </div>
                        <div class='flex flex-col gap-5 relative'>
                            <p class="bg-transparent w-60
                        outline-0 text-white border-white rounded"><?= $post->getDescripcion() ?></p>
                            <div class='flex justify-end'>
                                <button onclick="addFav(<?= $post->getId() ?>, <?= $user_id ?>)" class='text-white hover:bg-inline transition px-3 py-2 rounded'>
                                    <?php if (Reactions::getAllUsers($post->getId(), $user_id)[0]) { ?>
                                        <i id="fav_<?= $post->getId() ?>" class="fas fa-star"></i>
                                    <?php } else { ?>
                                        <i id="fav_<?= $post->getId() ?>" class="far fa-star"></i>
                                    <?php } ?>

                                    <span id='fav_value_<?= $post->getId() ?>'>
                                        <?= Reactions::getAll($post->getId()) ?>
                                    </span>
                                </button>
                            </div>
                            <span class='text-sm text-[#6f6f6f] text-right'>
                                Publicado el: <?= $post->getFecha() ?>
                            </span>
                        </div>
                    </div>
                    <hr>
                    <form action="index.php" method="post" class="flex justify-evenly bg-[#3b332f] py-4">
                        <img width="40" class="bg-[#888] rounded-full" src="./assets/profile.svg" alt="profile">
                        <input hidden name="type" value="chat" type="text">
                        <input hidden name="post_id" value="<?= $post->getId() ?>" type="number">
                        <input name="descripcion" class="w-52 bg-transparent border-white border-b
                        outline-0 pl-1 text-white" placeholder="Escribe un comentario..." type="text">
                        <button class='bg-inline transition px-3 hover:text-white rounded-full'>
                            <i class="fas fa-reply"></i>
                        </button>
                    </form>
                    <!-- <hr class='border-[#554234]'> -->
                    <div class="flex flex-col justify-evenly items-center
                    bg-[#3b332f] cursor-pointer transition hover:bg-inline py-2">
                        <button onclick="showChats(<?= $post->getId() ?>)" class='flex gap-3 items-center text-white'>
                            <i class="icons_<?= $post->getId() ?> transition fas fa-caret-down"></i>
                            Ver comentarios
                            <i class="icons_<?= $post->getId() ?> transition fas fa-caret-down"></i>
                        </button>
                    </div>
                    <div id="chats_<?= $post->getId() ?>" class='hidden overflow-auto transition
                    w-full h-20 p-3 bg-[#3b332f] text-white'>
                        <?php $chats = Chats::getAll($post->getId()) ?>
                        <?php foreach ($chats as $chat) { ?>
                            <div class='flex gap-2 '>
                                <b><?= $chat->getUsername() ?>:</b>
                                <p><?= $chat->getDescripcion() ?></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
    <script>
        const profile = document.querySelector('#profile');
        const account = document.querySelector('#account');
        const btnClosedSession = document.querySelector('#closedSession');
        let active = false;
        let active_chat = false;

        btnClosedSession.addEventListener('click', () => {
            localStorage.removeItem('id_user');
            window.location.href = '/';
        })

        profile.addEventListener('click', () => {

            if (!active) {
                account.classList.remove('hidden');
                account.classList.add('block');
                active = true;
            } else {
                account.classList.remove('block');
                account.classList.add('hidden');
                active = false;
            }
        });

        const addFav = (post_id, user_id) => {

            const fav = document.querySelector(`#fav_${post_id}`);
            const value = document.querySelector(`#fav_value_${post_id}`);

            if (fav.className === 'far fa-star') {
                fav.className = 'fas fa-star';
                value.innerHTML = parseInt(value.innerHTML) + 1;
            } else {
                fav.className = 'far fa-star';
                value.innerHTML = parseInt(value.innerHTML) - 1;
            }

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'controller/update_reactions.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log('Reacciones actualizadas correctamente');
                    document.cookie = 'post_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC;';
                } else {
                    console.error('Error al actualizar las reacciones');
                }
            };
            xhr.onerror = function() {
                console.error('Error de conexión');
            };
            xhr.send(`post_id=${post_id}&user_id=${user_id}`);
        }

        const showChats = (post_id) => {

            if (!active_chat) {
                const chats = document.querySelector(`#chats_${post_id}`);
                const icon_left = document.querySelectorAll(`.icons_${post_id}`)[0];
                const icon_right = document.querySelectorAll(`.icons_${post_id}`)[1];

                chats.classList.remove('hidden');
                icon_left.style.transform = 'rotate(180deg)';
                icon_right.style.transform = 'rotate(-180deg)';
                active_chat = true;

            } else {
                const chats = document.querySelector(`#chats_${post_id}`);
                const icon_left = document.querySelectorAll(`.icons_${post_id}`)[0];
                const icon_right = document.querySelectorAll(`.icons_${post_id}`)[1];

                chats.classList.add('hidden');
                icon_left.style.transform = 'rotate(0)';
                icon_right.style.transform = 'rotate(-0)';
                active_chat = false;

            }

        }
    </script>
</body>

</html>