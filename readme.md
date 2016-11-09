# CMD-commands

Directory: cd c:/xampp/htdocs/verwaltungstool_v2

Create new migration file: php artisan make:migration name_of_migration --table="..." (if already existing)

Migration: php artisan migrate

New controller: php artisan make:controller name_of_controller

New CRUD-Controller: php artisan make:controller name_of_controller --resource

# Installation of WKHTMLTOPDF and its wrapper

[Github website](https://github.com/KnpLabs/snappy#wkhtmltopdf-binary-as-composer-dependencies)

1) CMD: composer require knplabs/knp-snappy
2) maybe add "h4cc/wkhtmltopdf-amd64": "0.12.x" and "h4cc/wkhtmltoimage-amd64": "0.12.x" to composer.json
3) CMD: composer require barryvdh/laravel-snappy
4) add "Barryvdh\Snappy\ServiceProvider::class," to "providers" in file config/app.php
5) add "'PDF' => Barryvdh\Snappy\Facades\SnappyPdf::class," and "'SnappyImage' => Barryvdh\Snappy\Facades\SnappyImage::class," to "aliases" in file config/app.php
6) CMD: php artisan vendor:publish --provider="Barryvdh\Snappy\ServiceProvider"
7) copy "wkhtmltopdf.exe" and "wkhtmltoimage.exe" from local folder to corrsponding folder "vendor\...\bin\" (topdf or toimage)
8) change 'binary' in new generated file config/snappy.php to "'binary' => base_path('vendor\h4cc\wkhtmltopdf-amd64\bin\wkhtmltopdf.exe')" and "'binary' => base_path('vendor\h4cc\wkhtmltoimage-amd64\bin\wkhtmltoimage.exe')"

# Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).
