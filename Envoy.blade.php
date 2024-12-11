@servers(['web' => ['u827705294@153.92.9.215 -p 65002']])
 
@task('optimize', ['on' => 'web'])
cd domains/qacjakarta.com/qac
    php artisan optimize
@endtask

@task('deploy', ['on' => 'web'])
    cd domains/qacjakarta.com/qac
    git pull origin main
    php artisan optimize
@endtask

@task('update', ['on' => 'web'])
    cd domains/qacjakarta.com/qac
    git checkout .
    git pull origin main
    composer install
    php artisan migrate --force
    php artisan optimize
@endtask