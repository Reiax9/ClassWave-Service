<?php
    include '../lib/PanelController.php';
    if(isset($_COOKIE['session'])){
        session_start();
    }else{header('Location: ../index.php');exit();}
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="icon" type="image/x-icon" href="../img/LogoV2.png">
    <title>Panel</title>
</head>
<body>
    <div id="wave-container">
        <object type="image/svg+xml" data="../css/waves.svg" id="wave-1"></object>
    </div>
    <?=showObject($_SESSION['course'],$_SESSION['alumno'],$_SESSION['user'])?>
</body>
</html>
<script>
window.addEventListener('unload', function(){
    document.cookie = 'session=; Max-Age=0; path=/';
    navigator.sendBeacon('logout.php');
});
function openWindow(url) {
  window.open(url, '_blank');
};
</script>
