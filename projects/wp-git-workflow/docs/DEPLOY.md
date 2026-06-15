# 🚀 Checklist de Despliegue

Seguir este checklist **en orden** antes y después de cada despliegue a producción.

---

## Antes de desplegar (pre-deploy)

### En entorno local / staging

- [ ] `develop` está actualizado y todos los cambios están commiteados
- [ ] No hay errores de PHP en el log (`tail -f /var/log/php*.log`)
- [ ] No hay errores de JS en la consola del navegador
- [ ] El sitio se ve correctamente en mobile (≤768px), tablet y desktop
- [ ] Los formularios funcionan correctamente
- [ ] Las imágenes cargan y tienen atributo `alt`
- [ ] Se corrió una revisión rápida de performance (Lighthouse o PageSpeed)

### Control de versiones

- [ ] Pull Request abierto: `develop → main`
- [ ] El PR fue revisado y aprobado
- [ ] Mensaje de merge incluye número de versión: `chore: deploy v1.x.x`

### Base de datos

- [ ] **Respaldo de BD tomado** antes del despliegue
  ```bash
  bash scripts/backup-db.sh
  ```
- [ ] El respaldo existe en `./backups/` y tiene tamaño > 0

---

## Durante el despliegue

```bash
# 1. Conectar al servidor
ssh usuario@ip-servidor

# 2. Ir al directorio del sitio
cd /var/www/html

# 3. Activar modo mantenimiento
wp maintenance-mode activate

# 4. Pull del código
git pull origin main

# 5. Si hay cambios en el tema: limpiar caché de WordPress
wp cache flush
wp rewrite flush

# 6. Desactivar modo mantenimiento
wp maintenance-mode deactivate
```

---

## Después de desplegar (post-deploy)

- [ ] El sitio carga correctamente en producción
- [ ] Revisar página de inicio, páginas clave y formularios
- [ ] Revisar en mobile
- [ ] Revisar log de errores: `tail -n 50 /var/log/nginx/error.log`
- [ ] Crear tag de versión en Git:
  ```bash
  git tag -a v1.x.x -m "Descripción de los cambios"
  git push origin --tags
  ```
- [ ] Anotar en el historial del equipo (Slack / Notion / etc.)

---

## Rollback rápido

Si algo falla en producción:

```bash
# Ver el tag anterior
git tag --sort=-version:refname | head -5

# Revertir al tag anterior (ej: v1.2.0)
git checkout v1.2.0
wp cache flush
wp maintenance-mode deactivate

# Restaurar BD si es necesario
gunzip < backups/backup-db-FECHA.sql.gz | wp db import -
```
