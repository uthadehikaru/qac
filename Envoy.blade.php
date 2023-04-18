@servers(['web' => ['u1424128@qacjakarta.id -p 65002']])
 
@task('optimize', ['on' => 'web'])
    cd /home/u1424128/app
    php artisan optimize
@endtask

@task('deploy', ['on' => 'web'])
    cd /home/u1424128/app
    git pull origin qac
    php artisan optimize
@endtask

@task('deploy-full', ['on' => 'web'])
    cd /home/u1424128/app
    git pull origin qac
    composer install
    php artisan migrate --force
    php artisan optimize
@endtask