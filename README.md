# ciudata

1 docker compose up -d --build

2 docker exec -it php-ciudata bash

3 composer install 

4 cp .env.example .env

5 chmod 777 -R storage

6 php artisan migrate:fresh --seed
