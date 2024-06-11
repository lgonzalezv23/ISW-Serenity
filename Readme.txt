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

http://localhost/ISW-Serenity/register.php

