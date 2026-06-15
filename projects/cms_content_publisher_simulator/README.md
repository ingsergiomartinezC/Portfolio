# 🖥️ CMS Content Publisher Simulator

Simulador de gestión de contenidos inspirado en plataformas CMS como WordPress y Craft CMS. Construido con HTML, CSS y JavaScript vanilla — sin dependencias ni frameworks.

**[Ver demo en vivo →](https://ingsergiomartinezC.github.io/cms-simulator)**

---

## ¿Qué demuestra este proyecto?

Construido directamente alineado a la vacante de **Web Developer / Content Manager**:

| Habilidad requerida | Cómo se aplica aquí |
|---|---|
| HTML5 semántico | Estructura accesible con roles y `aria-label` |
| CSS3 avanzado | Variables CSS, Grid, Flexbox, animaciones, responsive |
| JavaScript ES6+ | Gestión de estado, DOM manipulation, eventos |
| Gestión de contenidos CMS | CRUD completo de entradas (crear, editar, publicar) |
| Control de versiones Git | Repo con commits semánticos y flujo documentado |
| Optimización de imágenes | Lazy loading, `srcset`-ready, `object-fit` |

---

## Funcionalidades

### Panel de control
- Dashboard con estadísticas en tiempo real
- Actividad reciente de entradas
- Contadores de estado (publicadas, borradores, en revisión)

### Gestión de entradas
- Crear, editar y eliminar entradas
- Tipos de contenido: Artículo, Página, Producto
- Filtros por estado y tipo
- Búsqueda en tiempo real

### Editor de contenido
- Editor WYSIWYG con barra de herramientas (negrita, cursiva, H2/H3, listas, citas, código, links, imágenes)
- Generación automática de slug desde el título
- Contador de palabras, caracteres y tiempo de lectura
- Guardado automático con indicador visual

### Panel de publicación (CMS-style)
- Control de estado: Borrador → En revisión → Publicado → Archivado
- Fecha de publicación programada
- Asignación de autor y categoría
- Etiquetas con agregar/eliminar

### Imagen destacada
- Biblioteca de medios con selección visual
- Inserción de imágenes en el cuerpo del contenido
- Vista previa de imagen destacada en el panel

### SEO integrado
- Puntuación SEO en tiempo real (0–100%)
- Meta título, meta descripción y keyword principal
- Indicador visual de calidad (verde/amarillo/rojo)

### Vista previa
- Preview renderizado como si fuera el frontend del sitio
- URL simulada con slug generado
- Muestra contenido, imagen destacada y etiquetas

---

## Stack técnico

```
HTML5     → estructura semántica y accesible
CSS3      → custom properties, grid, flexbox, animaciones
JavaScript → ES6+, sin frameworks, sin dependencias
```

---

## Cómo ejecutar localmente

```bash
# Clonar el repositorio
git clone https://github.com/ingsergiomartinezC/cms-simulator.git

# Abrir directamente en el navegador
open cms-simulator/index.html

# O con servidor local (recomendado)
cd cms-simulator
npx serve .
# → http://localhost:3000
```

---

## Estructura del repo

```
cms-simulator/
├── index.html    ← Aplicación completa (HTML + CSS + JS)
└── README.md
```

El proyecto es deliberadamente un único archivo para facilitar el despliegue en GitHub Pages sin configuración adicional.

---

## Autor

**Sergio Martínez** — Ing. en Ciencias de la Computación  
[linkedin.com/in/ingsergiomartinez](https://linkedin.com/in/ingsergiomartinez) · [github.com/ingsergiomartinezC](https://github.com/ingsergiomartinezC)
