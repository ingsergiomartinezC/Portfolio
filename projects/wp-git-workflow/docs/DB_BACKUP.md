# 🗄️ Respaldo de Base de Datos

Procedimiento estándar para respaldar la BD de WordPress antes de cualquier cambio importante.

---

## Método 1 — Script automatizado (recomendado)

```bash
bash scripts/backup-db.sh
```

El script:
- Exporta la BD con `wp db export`
- Comprime con `gzip`
- Guarda en `./backups/backup-db-YYYYMMDD-HHMMSS.sql.gz`
- Elimina respaldos con más de 14 días

---

## Método 2 — WP-CLI manual

```bash
# Exportar
wp db export backups/manual-$(date +%Y%m%d).sql

# Comprimir
gzip backups/manual-$(date +%Y%m%d).sql
```

---

## Método 3 — mysqldump directo

```bash
# Leer credenciales de wp-config.php
DB_NAME=$(wp config get DB_NAME)
DB_USER=$(wp config get DB_USER)
DB_PASS=$(wp config get DB_PASSWORD)
DB_HOST=$(wp config get DB_HOST)

mysqldump -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" \
  | gzip > "backups/mysqldump-$(date +%Y%m%d).sql.gz"
```

---

## Restaurar un respaldo

```bash
# Descomprimir e importar
gunzip < backups/backup-db-20240315-143000.sql.gz | wp db import -

# Verificar
wp db check
```

---

## Política de retención

| Tipo | Frecuencia | Retención |
|---|---|---|
| Pre-deploy | Cada despliegue | 30 días |
| Automático (cron) | Diario | 14 días |
| Semanal | Lunes 00:00 | 90 días |

### Configurar cron para respaldo automático

```bash
# Editar crontab
crontab -e

# Agregar respaldo diario a las 2 AM
0 2 * * * /bin/bash /var/www/html/scripts/backup-db.sh >> /var/log/wp-backup.log 2>&1
```
