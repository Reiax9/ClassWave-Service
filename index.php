<?php
    require "./lib/users.php";
    require "./lib/ssh/remotescript.php";
    if(isset($_COOKIE['session'])){
        header("Location: panel/index.php");
        exit();
    }elseif ($_SERVER["REQUEST_METHOD"]=="POST") {
        
        $user = isset($_POST['name'])     ? htmlspecialchars($_POST['name'])     : null;
        $pass = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : null;

        if ($user && $pass) {
            if (validateUser($user, $pass)) {
                session_start();
                $data = getData($user);
                $_SESSION['user'] = $user;
                $_SESSION['course'] = $data['IPCurso'];
                $_SESSION['alumno'] = $data['ipAlumno'];
                setcookie('session', hash('sha512',$user), time() + (86400 * 30), "/");
                // Esta funcion arrancara todos los dockers del alumno
                startDocker($data['IPCurso'],$data['ipAlumno'],$user,$_SERVER["REMOTE_ADDR"]);
                header("Location: panel/index.php");
                exit();
            }
            $error = "Usuario o contraseña incorrectos.";
        }
    } else { $error = "<br>"; }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login ClassWave</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="icon" type="image/x-icon" href="./img/LogoV2.png">
</head>
<body>
    <main>
        <div id="wave-container">
            <object type="image/svg+xml" data="./css/waves.svg" id="wave-1"></object>
        </div>
        <div id="overlay" class="overlay"></div>
        <div id="loader" class="loader hidden"></div>
        <div id="container-form">
            <img src="./img/LogoV2.png" alt="Logo ClassWave" id="iconoEmpresa">
            <?php if(isset($error)) { echo "<span>".$error."</span>"; }?>
            <form method="post" id="login-form" onsubmit="showLoader()">
                <div class="logoInput">
                    <img src="./img/profile.png" alt="logoProfile" id="logoProfile">
                    <input type="text" name="name" class="passuser" placeholder="Username" value="<?= isset($user) ? $user : "";?>">
                </div>
                <div class="logoInput">
                    <img src="./img/key.png" alt="logoProfile" id="logoProfile">
                    <input type="password" name="password" class="passuser" placeholder="Password">
                </div>
                <button id="botonLogin">Enviar</button>
            </form>
        </div>
    </main>
    
</body>
<script>
        function showLoader() {
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('loader').classList.remove('hidden');
            document.getElementById('login-form').classList.add('form-hidden');
        }
    </script>
</html>