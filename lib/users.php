<?php

    require "conn.php";

    function validateUser($user, $pass){
        $conn   = getDBconnection();
        $sql = "SELECT `Contraseña` FROM `Usuarios` WHERE `Usuario` LIKE :usuario";

        try{
            $db     = $conn->prepare($sql);
            $db->execute([':usuario' => $user]);
            $hash   = $db->fetchColumn();
            return  $hash && password_verify($pass,$hash)  ? true : false;
        }catch(PDOException $e){
            echo 'Error: ' . $e->getMessage();
        }
    }

    function getData($user){
        $conn   = getDBconnection();
        $sql    = "SELECT U.*, C.Nombre AS Nombre_Curso, C.Año AS Año_Curso, C.ipCurso AS IPCurso
                    FROM Usuarios U
                    INNER JOIN Curso_usuario CU ON U.idUsuario = CU.idUsuario
                    INNER JOIN Curso C ON CU.idCurso = C.idCurso
                    WHERE U.Usuario LIKE :usuario";
        try{
            $db     = $conn->prepare($sql);
            $db->execute([':usuario' => $user]);
            $data   = $db->fetch(PDO::FETCH_ASSOC);
            return  $data;
        }catch(PDOException $e){
            echo 'Error: ' . $e->getMessage();
        }
    }