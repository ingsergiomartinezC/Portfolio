# 🎨 WordPress Child Theme + Git Workflow

Tema hijo de WordPress gestionado con Git. Este repositorio demuestra cómo aplicar un **flujo de control de versiones profesional** en proyectos WordPress: desde configuración del entorno local hasta despliegue en producción.

---

## 📋 Tabla de contenidos

- [Estructura del proyecto](#estructura-del-proyecto)
- [Requisitos](#requisitos)
- [Instalación local con ddev](#instalación-local-con-ddev)
- [Flujo de trabajo con Git](#flujo-de-trabajo-con-git)
- [Convención de commits](#convención-de-commits)
- [Respaldo de base de datos](#respaldo-de-base-de-datos)
- [Despliegue a producción](#despliegue-a-producción)

---

## 📁 Estructura del proyecto

```
wp-git-workflow/
├── theme/                        ← Tema hijo (se copia a wp-content/themes/)
│   ├── style.css                 ← Header del tema hijo (obligatorio)
│   ├── functions.php             ← Encolar estilos y scripts del hijo
│   ├── assets/
│   │   ├── css/
│   │   │   ├── main.css          ← Estilos personalizados
│   │   │   └── custom-blocks.css ← Estilos para bloques Gutenberg
│   │   ├── js/
│   │   │   └── main.js           ← Scripts del tema
│   │   └── images/               ← Imágenes del tema (optimizadas)
│   ├── template-parts/
│   │   ├── header-custom.php
│   │   └── footer-custom.php
│   └── inc/
│       └── helpers.php           ← Funciones auxiliares
├── docs/
│   ├── BRANCHING.md              ← Guía visual del flujo de ramas
│   ├── DB_BACKUP.md              ← Procedimiento de respaldo de BD
│   └── DEPLOY.md                 ← Checklist de despliegue
├── scripts/
│   └── backup-db.sh              ← Script de respaldo automatizado
├── .gitignore
└── README.md
```

> **Nota:** Este repo versiona **únicamente el tema hijo**. Los archivos core de WordPress (`wp-admin/`, `wp-includes/`, plugins de terceros) se excluyen via `.gitignore`.

---

## ⚙️ Requisitos

| Herramienta | Versión mínima | Notas |
|---|---|---|
| Git | 2.x | `git --version` |
| Docker Desktop | 4.x | Requerido por ddev |
| ddev | 1.22+ | `ddev version` |
| Node / NPM | 18+ | Para compilar assets |
| WP-CLI | 2.x | Opcional pero recomendado |

---

## 🐳 Instalación local con ddev

```bash
# 1. Clonar el repositorio
git clone https://github.com/ingsergiomartinezC/wp-git-workflow.git
cd wp-git-workflow

# 2. Iniciar el entorno ddev (WordPress + PHP + MySQL)
ddev start

# 3. Instalar WordPress
ddev exec wp core download --locale=es_MX
ddev exec wp core install \
  --url="https://wp-git-workflow.ddev.site" \
  --title="Mi Sitio WP" \
  --admin_user=admin \
  --admin_password=admin \
  --admin_email=sergio@example.com

# 4. Copiar el tema hijo al directorio de temas
cp -r theme/ .ddev/wordpress/wp-content/themes/mi-tema-hijo/

# 5. Activar el tema
ddev exec wp theme activate mi-tema-hijo

# 6. Abrir en el navegador
ddev launch
```

---

## 🔀 Flujo de trabajo con Git

Este proyecto sigue una versión simplificada de **Git Flow** con tres tipos de ramas:

```
main ──────────────────────────────────────── producción (solo merges desde develop)
  │
develop ───────────────────────────────────── integración y QA
  │
  ├── feature/nombre-del-cambio              ← nuevas funcionalidades
  ├── fix/descripcion-del-bug                ← correcciones de errores
  └── content/seccion-actualizada            ← actualizaciones de contenido
```

### Paso a paso por cada tarea

```bash
# 1. Asegurarse de estar actualizado
git checkout develop
git pull origin develop

# 2. Crear rama para el cambio
git checkout -b feature/nueva-seccion-testimonios

# 3. Hacer los cambios (editar archivos del tema, agregar templates, etc.)
# ...

# 4. Revisar qué cambió
git status
git diff

# 5. Staging y commit
git add theme/template-parts/testimonios.php
git add theme/assets/css/main.css
git commit -m "feat: agregar sección de testimonios con slider"

# 6. Push y Pull Request
git push origin feature/nueva-seccion-testimonios
# → Abrir PR en GitHub: feature/... → develop

# 7. Después de review y aprobación: merge a develop
# 8. QA en develop → si pasa, merge de develop → main (despliegue)
```

---

## ✍️ Convención de commits

Se usa **Conventional Commits** para mantener un historial legible:

| Prefijo | Uso | Ejemplo |
|---|---|---|
| `feat:` | Nueva funcionalidad o template | `feat: agregar mega menú mobile` |
| `fix:` | Corrección de bug visual o lógico | `fix: corregir z-index del header en iOS` |
| `style:` | Cambios de CSS sin lógica | `style: ajustar espaciado en hero section` |
| `content:` | Actualización de contenido/copy | `content: actualizar textos de home` |
| `perf:` | Optimización de imágenes o código | `perf: comprimir imágenes del slider a WebP` |
| `docs:` | Actualización de documentación | `docs: agregar guía de despliegue` |
| `chore:` | Tareas de mantenimiento | `chore: actualizar .gitignore` |

---

## 🗄️ Respaldo de base de datos

Antes de cualquier despliegue, se toma un respaldo de la BD:

```bash
# Respaldo manual con WP-CLI
ddev exec wp db export backups/pre-deploy-$(date +%Y%m%d-%H%M).sql

# O con el script automatizado incluido
bash scripts/backup-db.sh
```

Ver [`docs/DB_BACKUP.md`](docs/DB_BACKUP.md) para el procedimiento completo.

---

## 🚀 Despliegue a producción

```bash
# 1. Asegurarse que develop está limpio y testeado
git checkout develop
git pull origin develop

# 2. Merge a main
git checkout main
git merge develop --no-ff -m "chore: deploy v1.3.0 — testimonios + optimización mobile"

# 3. Crear tag de versión
git tag -a v1.3.0 -m "Testimonios, fix mobile header, imágenes WebP"
git push origin main --tags

# 4. En servidor de producción: pull + activar tema
ssh usuario@servidor "cd /var/www/html && git pull origin main"
```

Ver [`docs/DEPLOY.md`](docs/DEPLOY.md) para el checklist completo pre/post despliegue.

---

## 👤 Autor

**Sergio Martínez** — Ingeniero en Ciencias de la Computación  
[linkedin.com/in/ingsergiomartinez](https://linkedin.com/in/ingsergiomartinez) · [github.com/ingsergiomartinezC](https://github.com/ingsergiomartinezC)
