<?php
// Incluir la biblioteca phpseclib
use phpseclib3\Net\SSH2;
require 'vendor/autoload.php';
function startDocker($ipCurso,$ipAlumno,$user,$ipClient,$session = TRUE){
    // Configurar los datos de conexión SSH
    $host = $ipCurso;
    $port = 22; // Puerto SSH
    $username = 'admin';
    $password = 'konosuba';

    // Crear una nueva instancia de SSH2
    $ssh = new SSH2($host, $port);

    // Intentar la conexión SSH
    if (!$ssh->login($username, $password)) {
        exit('Error de autenticación');
    }
    
    // Ejecutar script Docker
    if($session == TRUE){
        $ssh->write("sudo sh docker.sh $user $ipAlumno false \n");
        // false (ssh) iniciar
        $output = $ssh->read('/.*[pP]assword.*:/');
        $ssh->write("$password\n");
        $output .= $ssh->read();
    }else{
        $ssh->write("sudo sh docker.sh $user $ipAlumno true \n");
        // true (ssh) detener
        $output = $ssh->read('/.*[pP]assword.*:/');
        $ssh->write("$password\n");
        $output .= $ssh->read();
    }
    // Ejecutar Script Iptables
    // $session == TRUE ? $ssh->write("sudo sh iptables.sh true $user $ipAlumno $ipClient \n") : $ssh->write("sudo sh iptables.sh false $user $ipAlumno $ipClient \n");
    // $output = $ssh->read('/.*[pP]assword.*:/');
    // $ssh->write("$password\n");
    // $output .= $ssh->read();
 
    echo $output;
}
?>
