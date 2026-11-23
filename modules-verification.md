# Проверка модулей в Docker (ноябрь 2026)

Стенд: PHP 7.3 и 8.2, MariaDB 10.4, внутренняя сеть `dmz` без выхода в интернет.

| Репозиторий | Проверка | PHP 7.3 | PHP 8.2 |
|---|---|---|---|
| majordomo-access-control | auth_guard_test.php | OK | OK |
| majordomo-access-control | auth_tokens_test.php | OK | OK |
| majordomo-access-control | oauth_providers_test.php (5 провайдеров) | OK | OK |
| majordomo-audit | php -l src/audit.php | OK | OK |
| majordomo-audit | HTTP GET /audit.php без авторизации | 403 | 403 |
| majordomo-icons | php -l + icons_config_test.php | OK | OK |
| majordomo-docker-test | docker compose config -q | OK | OK |
| majordomo-docker-test | smoke.php: ассеты, diagnostic, CDN | OK | OK |
| majordomo-docker-test | pchart_check.php: валидный PNG | OK | OK |

Дополнительно: `DMZ egress: BLOCKED`, внешних CDN-ссылок в diagnostic.php — 0,
окно праздника 25.12–15.01 определяется корректно.
