# csv_parse
Парс csv файлов, для выполнения задачи было принято решение реализовать простенький сервис с авторизацией и формой загрузки csv файла.
![image](https://github.com/NicolayNicolay/csv_parse/assets/156336973/3b25d2ce-8e41-4eac-bdec-5caf5308f988)


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

