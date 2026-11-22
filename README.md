# Docker-стенд MajorDoMo с эмуляцией DMZ

Тестовое окружение для проверки PR ядра без доступа к интернету.

## Что есть

- `db` — MariaDB 10.4 с импортом `db_terminal.sql`;
- `web73` — PHP 7.3 + mysqli/mbstring/bcmath (минимальная версия ядра);
- `web82` — PHP 8.2 с теми же расширениями;
- `cli73` — PHP 7.3 CLI для lint и запросов во внутренней сети;
- сеть `dmz` — `internal: true`: контейнеры видят друг друга, но не имеют
  выхода в интернет.

## Запуск

1. Положите проверяемую копию ядра в `core/`.
2. Создайте `config.php` из `config.php.sample`, указав `DB_HOST=db`
   и `DB_PASSWORD=test`.
3. `docker compose up -d --build`
4. Создайте таблицу, которую ядро создаёт в cycle.php:

```sql
CREATE TABLE IF NOT EXISTS `cached_cycles` (
  `TITLE` char(100) NOT NULL,
  `VALUE` char(255) NOT NULL,
  PRIMARY KEY (`TITLE`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;
```

5. Запустите `php smoke.php` или `php final_check.php` из контейнера в сети `dmz`.

## Результаты проверки (ноябрь 2026)

- `php -l` на PHP 7.3 — чисто; на PHP 8.2 — чисто, кроме существующего
  `lib/websockets/client/lib/coffeescript/classes/parser.php` (не изменялся).
- все локальные ассеты (jQuery, Bootstrap, Moment + map, Font Awesome + woff2,
  holiday.css) — HTTP 200 на обеих версиях PHP;
- `diagnostic.php` — 51767/51798 байт, внешних CDN-ссылок 0;
- выход в интернет заблокирован (`DMZ egress: BLOCKED`);
- `audit.php` без авторизации — HTTP 403;
- окно праздника: 23.11 → 0, 25.12 → 1, 15.01 → 1, 16.01 → 0.
