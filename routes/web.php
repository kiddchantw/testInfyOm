<?php

use Illuminate\Support\Facades\Route;
use Butschster\Dbml\DbmlParserFactory;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test', function () {
    return 'test';
});


Route::get('/test-dbml', function () {
    $parser = DbmlParserFactory::create();
    $schema = $parser->parse(<<<DBML
    Project test {
        database_type: 'mysql'
        Note: 'Description of the project'
    }
    Table countries {
        code int [pk]
        name varchar
        continent_name varchar
    }
    DBML);

    $tables = $schema->getTables(); // \Butschster\Dbml\Ast\TableNode[]
    return $tables;
    return 'test-dbml';
});



Route::resource('staff', App\Http\Controllers\StaffController::class);
