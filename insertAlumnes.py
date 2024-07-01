import csv
import sys 
import mysql.connector

if len(sys.argv) < 2:
    print("Ús: python script.py <ruta_al_archivo.csv>")
else:
    csv_file = sys.argv[1]
    host = "localhost"
    user = "root"
    password = "Educem00."
    database = "Educem"
    table_usuarios = "Usuarios"
    table_curso_usuario = "Curso_usuario"

    mydb = mysql.connector.connect(
        host=host,
        user=user,
        password=password,
        database=database
    )

    try:
        mycursor = mydb.cursor()

        sql_usuarios = f"INSERT INTO {table_usuarios} (Nombre, Apellidos, DNI, Correo, Usuario, Contraseña, Roles, ipAlumno) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)"

        sql_curso_usuario = f"INSERT INTO {table_curso_usuario} (idCurso, idUsuario) VALUES (%s, %s)"

        with open(csv_file, mode='r', encoding='utf-8-sig') as file:
            csv_reader = csv.reader(file)
            next(csv_reader)
            
            for row in csv_reader:
                nombre = row[0]
                apellidos = row[1]
                dni = row[2]
                correo = row[3]
                usuario = row[4]
                contraseña = row[5]
                roles = row[6]
                ip_alumno = row[7]
                id_curso = int(row[8])

                mycursor.execute(sql_usuarios, (nombre, apellidos, dni, correo, usuario, contraseña, roles, ip_alumno))
                id_usuario = mycursor.lastrowid
                mycursor.execute(sql_curso_usuario, (id_curso, id_usuario))

        mydb.commit()

        print(mycursor.rowcount, "Alumnes insertats")

        mycursor.close()
        mydb.close()
    except:
        print("Error en el arxiu")