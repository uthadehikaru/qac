@servers(['web' => ['u1424128@qacjakarta.id -p 65002']])
 
@task('optimize', ['on' => 'web'])
    cd /home/u1424128/app
    php artisan optimize
@endtask

@task('deploy', ['on' => 'web'])
    cd /home/u1424128/app
    git pull origin main
    php artisan optimize
@endtask

@task('update-testing-full', ['on' => 'web'])
    cd /home/u1424128/testing
    git checkout .
    git pull origin ecourse
    composer install
    php artisan migrate --force
    php artisan db:seed SystemSeeder
    php artisan optimize
@endtask

@task('update-testing', ['on' => 'web'])
    cd /home/u1424128/testing
    git pull origin main
@endtask

@task('deploy-full', ['on' => 'web'])
    cd /home/u1424128/app
    php artisan down
    git pull origin main
    php artisan migrate --force
    php artisan optimize
    php artisan up
@endtask