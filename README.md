# 👨‍💻 Portafolio — Sergio Martínez

> Ingeniero en Ciencias de la Computación | Frontend · CMS · DevOps básico  
> [Ver sitio en vivo →](https://ingsergiomartinezC.github.io/portfolio)

---

## Sobre este repositorio

Este portafolio fue construido para demostrar habilidades alineadas al perfil de **Web Developer / Content Manager**, con enfoque en:

- Implementación de cambios en **HTML, CSS y JavaScript**
- Gestión de contenidos en **CMS** (WordPress, Craft CMS)
- **Control de versiones** con Git (flujo feature-branch → PR → merge)
- Entornos locales con **Docker / ddev**
- **Linux** y automatización con Bash
- **Optimización** de imágenes y performance web

---

## 📁 Proyectos incluidos

| Proyecto | Tecnologías | Descripción |
|---|---|---|
| [Landing page responsiva](./projects/landing-page/) | HTML · CSS · JS | Sitio estático, Lighthouse >90, dark mode |
| [WordPress + Git Workflow](https://github.com/ingsergiomartinezC/wp-git-workflow) | WordPress · Git | Tema hijo + flujo de versiones documentado |
| [Entorno local ddev](https://github.com/ingsergiomartinezC/ddev-starter) | Docker · ddev · NPM | Setup local para CMS con Makefile |
| [Script de respaldo web](https://github.com/ingsergiomartinezC/web-backup-script) | Bash · MySQL · Cron | Respaldo automatizado de BD y archivos |
| [QA Checklist](./projects/qa-checklist/) | Vanilla JS | Herramienta de revisión antes de publicar |
| [Optimizador de imágenes](https://github.com/ingsergiomartinezC/img-optimizer) | Python · Pillow · WebP | Conversión y redimensionado por lotes |

---

## 🛠 Stack y herramientas

```
Frontend:   HTML5 · CSS3 (Flexbox/Grid) · JavaScript ES6+
CMS:        WordPress · Craft CMS (en aprendizaje)
Versiones:  Git · GitHub · commits semánticos
Local:      Docker · ddev · NPM
OS:         Ubuntu / Linux daily driver
Scripts:    Bash · Python
Diseño:     Figma · GIMP
```

---

## 📂 Estructura del repo

```
portfolio/
├── index.html          ← Página principal del portafolio
├── css/
│   └── style.css
├── js/
│   └── main.js
├── projects/
│   ├── landing-page/   ← Demo: landing responsiva
│   └── qa-checklist/   ← Demo: herramienta de QA
└── README.md
```

---

## 🔀 Flujo de trabajo con Git

```bash
# Por cada cambio o feature
git checkout -b feature/nombre-del-cambio

# Commits semánticos
git commit -m "feat: agregar sección de testimonios"
git commit -m "fix: corregir alineación en móvil"
git commit -m "docs: actualizar README con instrucciones de ddev"

# Pull Request → revisión → merge a develop → QA → merge a main
```

---

## 📬 Contacto

- LinkedIn: [linkedin.com/in/ingsergiomartinez](https://linkedin.com/in/ingsergiomartinez)
- GitHub: [github.com/ingsergiomartinezC](https://github.com/ingsergiomartinezC)
- Ubicación: Querétaro, México · Disponible Home Office
