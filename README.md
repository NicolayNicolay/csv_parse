# csv_parse
Парс csv файлов

Краткое описание проекта: Сервис для выгрузки csv файлов.
В тестовом режиме не делалось углубленной логики. Для работы с большим кол-вом данных следует использовать сервис очередей (Horizon). Также для подобных задач с выгрузками нужно выгружать zip архивы, где будут присутствовать фотографии.
## Installation

```bash
git clone git@github.com:NicolayNicolay/csv_parse.git csv_parse.local
cd csv_parse.local
composer install
```

Copy the .env file and change the database connection settings

```bash
cp .env.example .env
```

```bash
php artisan key:generate
php artisan storage:link
```

```bash
npm install
```

```bash
npm run build
```

For development mode, use the command

```bash
npm run dev
```
Для создания тестового пользователя, и авторизации в сервисе.
```bash
php artisan db:seed --class=DatabaseSeeder
```

