# PROJECT KELOMPOK 2

</br>
</br>

## Installation

Install atau update composer

    composer install

atau

    composer update

Copy file .env.example ke .env dan setting nama database

    cp .env.example .env
    
Generate key application

    php artisan key:generate

Untuk membuat symbolic link

    php artisan storage:link


Jalankan database migration dan seeding

    php artisan migrate --seed

Jalankan

    php artisan serve

Untuk akses di http://localhost:8000
