@servers(['web' => ['u1424128@qacjakarta.id -p 65002']])
 
@task('optimize', ['on' => 'web'])
    cd /home/u1424128/app
    php artisan optimize
@endtask

@task('deploy', ['on' => 'web'])
    cd /home/u1424128/app
    git pull origin v1
    php artisan optimize
@endtask

@task('update-testing-full', ['on' => 'web'])
    cd /home/u1424128/testing
    git checkout .
    git pull origin main
    composer install
    php artisan migrate --force
    php artisan optimize
@endtask

@task('update-testing', ['on' => 'web'])
    cd /home/u1424128/testing
    git pull origin main
    php artisan optimize
@endtask

@task('deploy-full', ['on' => 'web'])
    cd /home/u1424128/app
    git pull origin main
    composer install
    php artisan migrate --force
    php artisan optimize
@endtask