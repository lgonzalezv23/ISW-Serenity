#This page is for Read-Only purposes

#git config user.email "luisenano2322@gmail.com"
#git config user.name "lgonzalezv23"

#git clone https://github.com/lgonzalezv23/ISW-Serenity

#This line was added for testing purposes


#instrucciones
instalar XAMPP
- levantar apache
- levantar MySQL

- Abre phpMyAdmin desde el panel de control de XAMPP.
- Crea una nueva base de datos llamada mental_health_app.

Dentro de esta base de datos, crea una tabla users con las siguientes columnas:

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

en un vscode clonar un repositorio
y meter esta url:

https://github.com/lgonzalezv23/ISW-Serenity

en la carpeta del xampp buscar la carpeta htdocs
y guardar ahi el repositorio

para abrir

http://localhost/ISW-Serenity/init_dashboard.html

Tablas Necesarias:

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

