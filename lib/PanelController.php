<?php
    include 'conn.php';
    function showObject($course,$alumno,$user){
        $conn = getDBConnection();
        $sql  = "SELECT S.* FROM Software AS S INNER JOIN Curso_software AS CS ON S.idSoftware = CS.idSoftware INNER JOIN Curso AS C ON CS.idCurso = C.idCurso INNER JOIN Curso_usuario AS CU ON C.idCurso = CU.idCurso INNER JOIN Usuarios AS U ON CU.idUsuario = U.idUsuario WHERE C.ipCurso = :course AND U.ipAlumno = :alumno";
        try{
            $get = null;
            $get = $conn->prepare($sql);
            $get->execute([':course' => $course,
                           ':alumno' => $alumno]);
            $object = $get->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $error){
            echo "Error BD: ".$error->getMessage();
            $object = false;
        }finally{
            if($object){
                echo "<div id='mainContainDocker'>";
                foreach($object as $foo){
                    $url      = "http://".$user.".classwave.es:".$foo['puerto'].($foo['puerto'] == '9020' || $foo['puerto'] == '9090' ? "/vnc.html" : "");
                    $display  = "<div class='docker'>";
                    $display .= "<a href='#' onclick='openWindow(\"$url\")'>";
                    $display .= "<img src='../lib/software/".$foo['Nombre'].".png' alt='".$foo['Nombre']."'>";
                    $display .= $foo['Nombre'];
                    $display .= "</a>";
                    $display .= "</div>";
                    echo $display;
                }
                echo "</div>";
            }   
        }
    }