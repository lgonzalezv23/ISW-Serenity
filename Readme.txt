#This page is for Read-Only purposes

Configuración de Git

En la consola de VS, configura tu usuario de Git con los siguientes comandos:

git config user.email "tu correo de GitHub"
git config user.name "tu usuario de GitHub"
------

Clona el repositorio:

git clone https://github.com/lgonzalezv23/ISW-Serenity
------

Donaciones: Si deseas hacer una donación, por favor envía un correo a edsilent9@gmail.com.

-------
Instrucciones para Configurar el Entorno
- Instalar XAMPP.
- Iniciar Apache y MySQL desde el panel de control de XAMPP.
- (Opcional) Si tu phpMyAdmin está en un puerto diferente, como el 3307, asegúrate de modificar la configuración según tu caso.
- Abre phpMyAdmin desde el panel de control de XAMPP.
- Crea una nueva base de datos llamada mental_health_app.
- Crea las siguientes tablas en la base de datos mental_health_app:


CREATE TABLE especialistas (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    apellidos VARCHAR(255) NOT NULL,
    fecha_nacimiento DATE,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    tipo ENUM('usuario', 'especialista') NOT NULL,
    cedula VARCHAR(255)
);

CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    apellidos VARCHAR(255) NOT NULL,
    fecha_nacimiento DATE,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    tipo ENUM('usuario', 'especialista') NOT NULL
);

CREATE TABLE seguimientos (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT(11) NOT NULL,
    fecha DATE,
    estado_animo INT(11),
    calidad_sueno INT(11),
    nivel_estres INT(11),
    nivel_energia INT(11),
    ansiedad_depresion INT(11),
    concentracion INT(11),
    FOREIGN KEY (usuario_id) REFERENCES users(id)
);

CREATE TABLE citas (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT(11) NOT NULL,
    horario_id INT(11) NOT NULL,
    fecha DATE,
    descripcion TEXT,
    FOREIGN KEY (usuario_id) REFERENCES users(id),
    FOREIGN KEY (horario_id) REFERENCES horarios(id)
);

CREATE TABLE horarios (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    especialista_id INT(11) NOT NULL,
    dia_semana ENUM('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'),
    hora_inicio TIME,
    hora_fin TIME,
    agendada TINYINT(1),
    FOREIGN KEY (especialista_id) REFERENCES especialistas(id)
);

CREATE TABLE contacto_especialista (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    especialista_id INT(11) NOT NULL,
    correo VARCHAR(255),
    telefono VARCHAR(20),
    FOREIGN KEY (especialista_id) REFERENCES especialistas(id)
);

-----------------
Clonar el Repositorio en VS Code
- En Visual Studio Code, abre la terminal y ejecuta el siguiente comando para clonar el repositorio:

git clone https://github.com/lgonzalezv23/ISW-Serenity

- Navega a la carpeta htdocs en la instalación de XAMPP.
- Guarda el repositorio clonado en la carpeta htdocs.

---------------
Abrir la Página Web
Para abrir la página, utiliza la siguiente URL en tu navegador:

http://localhost/ISW-Serenity/init_dashboard.html


