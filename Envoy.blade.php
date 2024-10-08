@servers(['web' => ['u827705294@153.92.9.215 -p 65002']])
 
@task('optimize', ['on' => 'web'])
    cd /home/u1424128/app
    php artisan optimize
@endtask

@task('deploy', ['on' => 'web'])
    cd /home/u1424128/app
    git pull origin main
    php artisan optimize
@endtask

@task('update', ['on' => 'web'])
    cd /home/u1424128/app
    git checkout .
    git pull origin main
    composer install
    php artisan migrate --force
    php artisan optimize
@endtask