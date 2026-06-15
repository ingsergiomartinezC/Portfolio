#!/usr/bin/env bash
# ─────────────────────────────────────────────────────────────────
# backup-db.sh — Respaldo de base de datos WordPress
#
# Uso:
#   bash scripts/backup-db.sh                   # Respaldo simple
#   bash scripts/backup-db.sh --upload-s3       # + subir a S3 (opcional)
#
# Requisitos: wp-cli, mysqldump, gzip
# Configurar las variables en la sección CONFIG antes de usar.
# ─────────────────────────────────────────────────────────────────

set -euo pipefail

# ─── CONFIG ────────────────────────────────────────────────────────
WP_PATH="/var/www/html"                         # Ruta a WordPress
BACKUP_DIR="./backups"                          # Directorio de salida
KEEP_DAYS=14                                    # Días de retención
S3_BUCKET="s3://mi-bucket/wp-backups/"         # Bucket S3 (opcional)
# ───────────────────────────────────────────────────────────────────

TIMESTAMP=$(date +"%Y%m%d-%H%M%S")
FILENAME="backup-db-${TIMESTAMP}.sql.gz"
FILEPATH="${BACKUP_DIR}/${FILENAME}"

# Colores para output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

log()  { echo -e "${GREEN}[OK]${NC}  $*"; }
warn() { echo -e "${YELLOW}[WARN]${NC} $*"; }
err()  { echo -e "${RED}[ERR]${NC}  $*" >&2; exit 1; }

# ─── VERIFICACIONES ────────────────────────────────────────────────
command -v wp      >/dev/null 2>&1 || err "wp-cli no encontrado. Instalar: https://wp-cli.org"
command -v gzip    >/dev/null 2>&1 || err "gzip no encontrado."
[ -f "${WP_PATH}/wp-config.php" ]  || err "wp-config.php no encontrado en ${WP_PATH}"

# ─── CREAR DIRECTORIO DE RESPALDOS ─────────────────────────────────
mkdir -p "${BACKUP_DIR}"

# ─── EXPORTAR BASE DE DATOS ────────────────────────────────────────
log "Iniciando respaldo: ${FILENAME}"
wp --path="${WP_PATH}" db export - | gzip > "${FILEPATH}"

SIZE=$(du -sh "${FILEPATH}" | cut -f1)
log "Respaldo completado: ${FILEPATH} (${SIZE})"

# ─── SUBIR A S3 (OPCIONAL) ─────────────────────────────────────────
if [[ "${1:-}" == "--upload-s3" ]]; then
    command -v aws >/dev/null 2>&1 || err "aws-cli no encontrado."
    log "Subiendo a S3: ${S3_BUCKET}"
    aws s3 cp "${FILEPATH}" "${S3_BUCKET}"
    log "Subida completada."
fi

# ─── LIMPIAR RESPALDOS VIEJOS ──────────────────────────────────────
DELETED=$(find "${BACKUP_DIR}" -name "backup-db-*.sql.gz" -mtime "+${KEEP_DAYS}" -print -delete | wc -l)
[ "${DELETED}" -gt 0 ] && warn "Eliminados ${DELETED} respaldos con más de ${KEEP_DAYS} días."

log "Proceso finalizado. Respaldos disponibles en: ${BACKUP_DIR}"
ls -lh "${BACKUP_DIR}"/backup-db-*.sql.gz 2>/dev/null || true
