## API Aplicación TODO
Este backend corresponde a la lógica de negocio para el frontend [hecho en ReactJS](https://github.com/JuLiAnChz/test-reactjs)

## Requisitos
* PHP 8.0: [Sitio oficial](https://www.php.net/downloads)
* Postgresql 13+: [Sitio oficial](https://www.postgresql.org/download/)
* Composer: [Sitio oficial](https://getcomposer.org/)

## Instalación
Para su instalación clone este repositorio
```bash
git clone https://github.com/JuLiAnChz/test-laravel-api
cd test-laravel-api
```

Copie la plantilla .env.example a .env en la raíz del proyecto:
```bash
cp .env.example .env
```
Cambie la configuración del archivo **.env** para la conexión a la base de datos:
```bash
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=lae-test
DB_USERNAME=postgres
DB_PASSWORD=**CONTRASEÑA**
```


Ahora debe instalar todas las dependencias con el gestor de paquetes composer
```bash
composer install
```

*Nota: Asegurese que la extensión pgsql está habilitada en su php.ini*
```bash
extension=pdo_pgsql
extension=pgsql
```

Ahora debemos ejecutar las migraciones para la creación de tablas en la base de datos:
```bash
php artisan migrate
```

Generamos los seeders para los datos básicos **IMPORTANTE**
```bash
php artisan db:seed
```
*Nota: El usuario generado es: admin@admin.com y su contraseña Admin1234*

Ahora generamos la secret key para el JWT
```bash
php artisan jwt:secret
```

## Iniciar API
```bash
php artisan serve
```

## Información adicional
Puede utilizar la base de datos que desee sin ningún problema, el ORM de laravel cuenta con compatibilidad con muchos gestores de base datos, para más información ingresa al [sitio oficial de laravel](https://laravel.com/docs/8.x/database)
