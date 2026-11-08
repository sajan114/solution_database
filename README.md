# Solution Database

An internal tool for consultants. When a consultant finds a problem in a client company, they can look up possible solutions, then specific products and services for each solution, and filter those by tags.

## Tech

- Laravel 12 (PHP 8.2+)
- SQLite database
- JavaScript with Vite

## How to install and run

Requirements: PHP 8.2+, Composer, Git, Node.js (LTS).

``` powershell
git clone https://github.com/sajan114/solution_database.git
cd solution_database
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm install
npm run build
php artisan serve
```

Then open http://127.0.0.1:8000

Notes:
- If asked whether to create the SQLite file, answer 'yes'.
- A warning about the "openssl" module is harmless.
- If you see "Vite manifest not found", run 'npm install' and 'npm run build'.
- After pulling changes to 'resources/js' or 'resources/css', run 'npm run build' again.
- 'php artisan migrate:fresh --seed' resets the database to the example data.

## Database design

- A problem can have many solutions, and a solution can fit many problems.
- A solution can have many products/services, and a product can belong to many solutions.
- A product can have many tags.

Link tables: 'sdb_problem_solution', 'sdb_product_solution', 'sdb_product_tag'.

## Features

What's Done:
- Browse problem, then solutions, then products
- CRUD for problems
- Live tag filter on the solution page (JavaScript, no page reload)
- Seeder with example data

Planned:
- CRUD for solutions, products and tags
- Adding a solution and linking it to problems
- KPI suggestion
- Layout with the CSS

## Git workflow

- Nobody works directly on 'main'.
- Each task has its own branch (e.g. 'feature/tags-crud') and a pull request that another member reviews.
- And run 'git pull' before starting work.