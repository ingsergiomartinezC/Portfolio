# 🔀 Guía de Ramas (Branching)

Este documento describe la estrategia de ramas del proyecto.

## Diagrama del flujo

```
main         ──●──────────────────────────────●──────────── producción
               │  merge desde develop          ↑
               │                               │ merge + tag
develop      ──●──────────●──────────●─────────●──────────── integración
               │          ↑         ↑
               │          │ merge   │ merge
feature/*    ──●──────────●         │
fix/*                    ──●────────●
```

## Tipos de ramas

| Rama | Prefijo | Ejemplo | Descripción |
|---|---|---|---|
| Producción | `main` | `main` | Solo recibe merges desde `develop`. Nunca commits directos. |
| Integración | `develop` | `develop` | Base para todas las ramas de trabajo. |
| Nueva funcionalidad | `feature/` | `feature/hero-animado` | Una tarea = una rama. |
| Corrección de bug | `fix/` | `fix/menu-mobile-ios` | Bugs encontrados en develop o reportados. |
| Actualización de contenido | `content/` | `content/actualizar-about` | Cambios de texto o imágenes sin lógica. |
| Hotfix crítico | `hotfix/` | `hotfix/error-404-home` | Bug urgente directo a main → cherry-pick a develop. |

## Reglas

1. **Nunca** hacer commit directo a `main` ni a `develop`.
2. Todo trabajo inicia desde `develop` actualizado (`git pull origin develop`).
3. Los Pull Requests requieren al menos 1 revisión antes de merge.
4. Los merges a `main` deben ir acompañados de un tag de versión (`v1.x.x`).
5. Eliminar la rama feature/fix después del merge.

## Ejemplo de hotfix

```bash
# Bug crítico en producción
git checkout main
git pull origin main
git checkout -b hotfix/error-pago-checkout

# ... arreglar bug ...

git commit -m "fix: corregir validación en checkout"

# Merge a main Y a develop
git checkout main && git merge hotfix/error-pago-checkout --no-ff
git tag -a v1.2.1 -m "Hotfix: error en checkout"
git push origin main --tags

git checkout develop && git merge hotfix/error-pago-checkout --no-ff
git push origin develop

git branch -d hotfix/error-pago-checkout
```
