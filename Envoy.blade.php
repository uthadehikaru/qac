@servers(['web' => ['u1424128@qacjakarta.id -p 65002']])
 
@task('optimize', ['on' => 'web'])
    cd /home/u1424128/quranjournal
    php artisan optimize
@endtask

@task('deploy', ['on' => 'web'])
    cd /home/u1424128/quranjournal
    git pull origin main
    php artisan optimize
@endtask

@task('update', ['on' => 'web'])
    cd /home/u1424128/quranjournal
    git checkout .
    git pull origin main
    composer install
    php artisan migrate --force
    php artisan db:seed SystemSeeder
    php artisan optimize
@endtask