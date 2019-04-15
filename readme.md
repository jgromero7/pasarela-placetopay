# Pasarela-PlaceToPay


Este proyecto está realizado en php con el framework de laravel 5.8, este proyecto tiene una interfaz simple con la cual puede realizar pagos con una conexión a placetopay
  - Registro de Usuario 
  - Compra de producto
  - Gestión de Producto Historial y detalles de transacciones e intentos de pago

### Tecnología

Pasarela-PlaceToPay usa varios proyectos de código abierto para funcionar correctamente:

* [Laravel 5.8](https://laravel.com/docs/5.8) - Se uso este framework para el desarrollo de esta aplicación.
* [placetopay api](https://dev.placetopay.com/web/redirection/) - PlaceToPay Servicio para conectarse a la pasarela de pago por medio se su api rest.
* [mysql](https://www.mysql.com/) - Se uso como motor de base de datos para gestionar los registros de la aplicación.
* [gluzzle](docs.guzzlephp.org) - Herramienta para el consumo de api hacia un cliente rest para realizar solicitudes GET y POST, está se usó para obtener información de placetopay.

### Clonar Repositorio
```sh
$ git clone URL_REPOSITORY 
```

### Installation

Rest-Server requiere [PHP7.2.4](https://www.php.net/) para ejecutarse.

Instale las dependencias y devDependencies e inicie el servidor.
```sh
$ cd pasarela-placetopay
$ composer install 
```

Crear base de datos en mysql, como recomendación y siguiendo los valores del archivo .env, agregar la base de datos con el siguiente nombre
```sh
    DB_DATABASE=pararela_ptp_db 
```

Ya creada la base de datos ejecutamos las migraciones creadas en el proyecto
```sh
$ php artisan migrate
```

Configurar variables de entorno, para el servicio placetopay en el archivo .env escribir las siguientes variables de entorno con sus valores correspondientes
```sh
$ PLACETOPAY_LOGIN= VALUE LOGIN
$ PLACETOPAY_SECRETKEY = VALUE SECRET KEY
$ PLACETOPAY_API = URL WEBSERVICE
```

#### Ejecutar el proyecto
```sh
$ php artisan serve
```

Verifique la implementación navegando a la dirección de su servidor en su navegador preferido.
```sh
127.0.0.1:8000 || http://localhost:8000
```

##### Información adicional
Rutas::
```sh
GET /orders Lista todas las transacciones y ordenadores realizada
GET /Product Muestra un formulario para realizar un pago.
GET /orders/{id}/payment Solicita datos al usuario para confirmación y realizar el pago
GET /orders/{id} Muestra la información de una orden con su proceso de pago correspondiente
```

Autor: José Romero
----
**Software Libre!**


