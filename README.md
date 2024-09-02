# URL Shortener API

Este es un proyecto de acortamiento de URLs construido con Laravel. Provee una API REST que permite acortar URLs, listar las URLs acortadas, y eliminarlas.

## Requisitos

- PHP >= 8.1
- Composer
- MySQL o cualquier otra base de datos compatible con Laravel

## Instalación

Sigue los siguientes pasos para configurar el proyecto en tu entorno local:

1. **Clonar el repositorio:**

   ```bash
   git clone https://github.com/1ukaz/url-shortener.git
   cd url-shortener
   ```
2. **Instalar las dependencias de PHP utilizando Composer:**
   ```bash
   composer install
   ```

3. **Configurar el entorno:**
    Copia el archivo `.env.example` y renómbralo a `.env`. Luego, edita el archivo `.env` con las configuraciones necesarias para tu entorno.
   ```bash
   cp .env.example.env
   ```
   *Recuerda que las rutas de este BE incluyen `/api` en la URL*

4. **Generar la clave de la aplicación:**
   ```bash
   php artisan key:generate
   ```

5. **Ejecutar las migraciones de la base de datos:**
   ```bash
   php artisan migrate
   ```

6. **Iniciar el servidor de desarrollo: (A menos que tengas un entorno de ejecucion montado)**
   ```bash
   php artisan serve
   ```
   El proyecto estará disponible en `http://localhost:8000/api`.

## Rutas:

### Acortar una URL
`POST /api/shorten`

- Descripción: Crea una URL acortada.
- Parámetros:
    - url: La URL original a acortar (string, requerido)
- Respuesta Exitosa:
    - Código de estado: 201 Created
- Cuerpo de la respuesta:
```
{
  "status": "success",
  "message": "URL shortened successfully",
  "data": {
    "shortened_url": "http://example.com/{short_path}"
  }
}
```
### Listar URLs acortadas
`GET /api/list`

- Descripción: Lista todas las URLs acortadas por el usuario actual.
- Parámetros:
    - user_identifier: Identificador del usuario (string, requerido)
- Respuesta Exitosa:
    - Código de estado: 200 OK
- Cuerpo de la respuesta:
```
{
  "status": "success",
  "message": "URLs retrieved successfully",
  "data": { 
    "urls" :[
        {
           "id": 9,
           "code": "E6qXxH6a",
           "original_url": "https://dummy.com/some/long/path",
           "shortened_url": "https://dummy.com/E6qXxH6a",
           "user_identifier": "5564dbcb-f26b-4733-a459-d0ef66e34769",
           "created_at": "2024-08-31T16:02:39.000000Z",
           "updated_at": "2024-08-31T16:02:39.000000Z"
        },
        ...
    ]
  }
}
```
### Eliminar una URL acortada
`DELETE /api/{code}`

- Descripción: Elimina una URL acortada.
- Parámetros:
    - code: El codigo de la URL (string, requerido)
- Respuesta Exitosa:
    - Código de estado: 200 OK
- Cuerpo de la respuesta:
```
{
  "status": "success",
  "message": "URL deleted successfully"
}
```
### Obtener una URL acortada
`GET /api/{code}`

- Descripción: Devuelve una URL acortada.
- Parámetros:
    - code: El codigo de la URL (string, requerido)
- Respuesta Exitosa:
    - Código de estado: 200 OK
- Cuerpo de la respuesta:
```
{
  "status": "success",
  "message": "URL was found",
  "data": {
     "id": 9,
     "code": "E6qXxH6a",
     "original_url": "https://dummy.com/some/long/path",
     "shortened_url": "https://dummy.com/E6qXxH6a",
     "user_identifier": "5564dbcb-f26b-4733-a459-d0ef66e34769",
     "created_at": "2024-08-30T16:02:39.000000Z",
     "updated_at": "2024-08-30T16:02:39.000000Z"
  }
}
```

## Testing
   Puedes ejecutar las pruebas unitarias y de integración con el siguiente comando:
   ```bash
   php artisan test
   ```
