# Proyecto de Gestión de Incidencias

## Índice

1. [Explicación del Proyecto](#explicacion-del-proyecto)
2. [Docker: Build y Comandos Útiles](#docker-build-y-comandos-utiles)

---

### 1. Explicación del Proyecto <a name="explicacion-del-proyecto"></a>

Este proyecto es una **aplicación web de gestión de incidencias** diseñada para facilitar el seguimiento y la administración de problemas o solicitudes dentro de una organización. La aplicación cuenta con una interfaz web para gestionar incidencias y una **API** para integraciones externas, permitiendo listar incidencias según los permisos del usuario.

El sistema de gestión de incidencias tiene implementados dos roles principales con permisos y funciones específicas:

- **Administrador**: Tiene acceso total a la aplicación y puede crear, editar y eliminar incidencias.
- **Soporte**: Puede ver todas las incidencias y editar el estado de las que ha creado.

**Características principales**:
- Creación y seguimiento de incidencias con estados (`todo`, `doing`, `done`).
- Acceso API para crear y consultar incidencias programáticamente.

Para clonear el proyecto, utiliza el siguiente comando:

```bash
git clone https://github.com/Riba00/incidence-project.git
cd incidence-project
cp .env.example .env
```

Modificar el archivo `.env` con los datos de la base de datos:

```bash
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=user
DB_PASSWORD=secret
```

### 2. Docker: Build y Comandos Útiles <a name="docker-build-y-comandos-utiles"></a>

El proyecto utiliza **Docker** para simplificar el despliegue y la configuración del entorno de desarrollo. A continuación, se detallan algunos comandos útiles:

#### Crear la imagen de Docker

Para construir la imagen del proyecto, utiliza el siguiente comando:

```bash
docker-compose build
```

#### Iniciar la aplicación

Para iniciar la aplicación, utiliza el siguiente comando:

```bash
docker-compose up -d
```

#### Detener la aplicación

Para detener la aplicación, utiliza el siguiente comando:

```bash
docker-compose down
```

### Ejecutar comandos en el contenedor

Para migrar la base de datos y ejecutar los seeders, utiliza el siguiente comando:

```
docker exec -it laravel_app bash
php artisan migrate --seed
```

En caso de problemas por permisos de archivos, puedes ejecutar el siguiente comando:

```
chmod -R 777 .
```

#### Acceder a la aplicación

Una vez que la aplicación esté en ejecución, puedes acceder a ella en la siguiente URL:

```
http://localhost:8080
```

Hay tres usuarios predefinidos en la base de datos:

- **Administrador**: 
    - **Email**: `admin@admin.com`
    - **Password**: `12341234`

- **Soporte1**: 
    - **Email**: `support1@support.com`
    - **Password**: `12341234`

- **Soporte2**: 
    - **Email**: `support2@support.com`
    - **Password**: `12341234`
---


