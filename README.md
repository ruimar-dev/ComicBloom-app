# ComicBloom

Una app de descubrimiento y organización de cómics Marvel con estética limpia.

## Requisitos

- PHP 8.2+
- Composer
- Node.js 18+
- npm
- Clave gratuita de [ComicVine API](https://comicvine.gamespot.com/api/)

## Instalación

```bash
# 1. Instalar dependencias PHP
composer install

# 2. Instalar dependencias JS
npm install

# 3. Configurar entorno
cp .env.example .env
php artisan key:generate

# 4. Añadir tu clave ComicVine en .env
#    COMICVINE_API_KEY=tu_clave
#    Regístrate en https://comicvine.gamespot.com/api/

# 5. Crear la base de datos y migrar
php artisan migrate

# 6. Compilar assets
npm run build

# 7. Arrancar servidor
php artisan serve
```

Abre http://localhost:8000

## Estructura principal

```
app/
  Services/MarvelApiService.php   — Toda la lógica de la API Marvel
  Http/Controllers/
    ComicController.php           — Dashboard, Explorar, Detalle
    ReadingListController.php     — Biblioteca, favoritos
    ContactController.php         — Formulario de contacto
  Models/ReadingList.php          — Modelo con metadatos del cómic

resources/views/
  welcome.blade.php               — Landing pública
  dashboard.blade.php             — Home tipo Spotify
  explore.blade.php               — Buscador/Explorar
  comic.blade.php                 — Detalle del cómic
  reading_list.blade.php          — Mi biblioteca con tabs
  about_us.blade.php              — Sobre nosotros
  contact/index.blade.php         — Contacto
  terms.blade.php                 — Términos
  layouts/app.blade.php           — Layout con sidebar + bottom nav móvil
```

## Variables de entorno

```env
APP_NAME=ComicBloom

COMICVINE_API_KEY=tu_clave_de_comicvine
```

## Cambios realizados respecto al original

- **MarvelApiService**: toda la lógica de API extraída del controlador, con caché
- **ReadingList**: nuevo modelo con `is_favorite` y metadatos (evita N+1 llamadas)
- **Nueva migración**: añade `title`, `thumbnail_url`, `is_favorite`, `characters`, etc.
- **Layout sidebar**: diseño tipo Spotify con sidebar desktop y bottom nav móvil
- **Paleta cute**: colores pastel rosas/morados, tipografía Nunito, cards redondeadas
- **Dashboard**: carruseles, sección "Continúa leyendo", buscador grande
- **Explorar**: búsqueda con sugerencias, grid responsive, empty states friendly
- **Detalle cómic**: acciones completas (favorito, estado, equipo creativo)
- **Biblioteca con tabs**: Todos / Sin leer / Leyendo / Leídos / Favoritos + ordenación
- **Landing moderna**: hero visual, features, CTA, footer
- **Contacto, About, Términos**: rediseñados con el nuevo sistema visual
- **Claves API en .env**: eliminadas del código fuente
