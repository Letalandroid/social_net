<?php



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
            location.href = '/social_net/login';
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
</head>

<body class="bg-background">
    <header class="bg-dark">
        <div class="flex justify-between w-full p-5">
            <img class="w-16 rounded-full" src="./assets/logo.png" alt="logo" />
            <img src='./assets/profile.svg' alt="profile" class="w-16 h-16 bg-[#fff] rounded-full" />
        </div>
    </header>
    <main>
        <div class='flex justify-center'>
            <form action="/social_net/index.php" method="post" class="flex justify-center items-start mt-3 px-6 py-5 gap-5 bg-[#3b332f] rounded">
                <img width="50" class="bg-[#888] rounded-full" src="./assets/profile.svg" alt="profile">
                <div class='flex flex-col gap-5 relative'>
                    <input class="bg-transparent w-60 border-b-2 pb-2 pl-1 outline-0 text-white border-white rounded" placeholder="¿Que piensas el día de hoy?" type="text">
                    <div class='flex justify-end'>
                        <button class='bg-dark text-white hover:bg-inline transition px-3 py-2 rounded'><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</body>

</html>