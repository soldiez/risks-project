<?php

declare(strict_types=1);

use App\Orchid\Screens\DirectoryScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\MenuTestScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\Unit\UnitDepartmentListScreen;
use App\Orchid\Screens\Unit\UnitEditScreen;
use App\Orchid\Screens\Unit\UnitJobPositionListScreen;
use App\Orchid\Screens\Unit\UnitListScreen;
use App\Orchid\Screens\Unit\UnitTerritoryListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use App\Orchid\Screens\Worker\WorkerListScreen;
use App\Orchid\Screens\Worker\WorkerEditScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile'));
    });

// Platform > System > Users
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit');

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('Create'), route('platform.systems.users.create'));
    });

// Platform > System > Users > User
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Users'), route('platform.systems.users'));
    });

// Platform > System > Roles > Role
Route::screen('roles/{roles}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(function (Trail $trail, $role) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Role'), route('platform.systems.roles.edit', $role));
    });

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Create'), route('platform.systems.roles.create'));
    });

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Roles'), route('platform.systems.roles'));
    });

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Example screen'));
    });

Route::screen('example-fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('example-layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('example-charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('example-editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('example-cards', ExampleCardsScreen::class)->name('platform.example.cards');
Route::screen('example-advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');

Route::screen('workers', WorkerListScreen::class)->name('platform.worker.list')
    ->breadcrumbs(function (Trail $trail){
        return $trail->parent('platform.index', route('platform.worker.list'))
            ->push('Список сотрудников', 'platform.worker.list');
    });
Route::screen('worker/{worker?}', WorkerEditScreen::class)->name('platform.worker.edit')
    ->breadcrumbs(function (Trail $trail){
        return $trail->parent('platform.worker.list')->push('Редактирование');
    });
Route::screen('values', \App\Orchid\Screens\ValuesScreen::class)->name('platform.value')
    ->breadcrumbs(function (Trail $trail){
        return $trail->parent('platform.index', route('platform.value'))->push('Список параметров');
    });

Route::screen('directory', DirectoryScreen::class)->name('platform.directory')
    ->breadcrumbs(function (Trail $trail){
        return $trail->parent('platform.index', route('platform.directory'))->push('Справочники');
    });
Route::screen('units', UnitListScreen::class)->name('platform.unit.list')
    ->breadcrumbs(function (Trail $trail){
        return $trail->parent('platform.index', route('platform.unit.list'))
            ->push('Список предприятий', 'platform.unit.list');
    });
Route::screen('unit/{unit?}', UnitEditScreen::class)->name('platform.unit.edit')
    ->breadcrumbs(function (Trail $trail){
        return $trail->parent('platform.unit.list')->push('Редактирование');
    });
Route::screen('unitTerritories', UnitTerritoryListScreen::class)->name('platform.unit.territory.list');
//Route::screen('unitDepartments', UnitDepartmentListScreen::class)->name('platform.unit.department.list');
//Route::screen('unitJobPositions', UnitJobPositionListScreen::class)->name('platform.unit.jobPosition.list');




// Роуты по экранам для рисков
Route::screen('riskAnalytic', \App\Orchid\Screens\Risk\RiskAnalyticScreen::class)->name('platform.risk.analytic')
    ->breadcrumbs(function (Trail $trail){
        return $trail->parent('platform.index', route('platform.risk.analytic'))->push(__('Аналитика по рискам'));
    });
Route::screen('riskList', \App\Orchid\Screens\Risk\RiskListScreen::class)->name('platform.risk.list')
    ->breadcrumbs(function (Trail $trail){
        return $trail->parent('platform.index', route('platform.risk.list'))->push(__('Профиль рисков'), 'platform.risk.list');
    });
Route::screen('riskEdit/{risk?}', \App\Orchid\Screens\Risk\RiskEditScreen::class)->name('platform.risk.edit')
    ->breadcrumbs(function (Trail $trail){
        return $trail->parent('platform.risk.list', route('platform.risk.list'))->push(__('Создание риска'));
    });




Route::screen('riskMethodInfo', \App\Orchid\Screens\Risk\RiskMethodInfoScreen::class)->name('platform.riskMethod.info')
    ->breadcrumbs(function (Trail $trail){
        return $trail->parent('platform.index', route('platform.riskMethod.info'))->push(__('Информация о методах оценки рисков'),  'platform.riskMethod.info');
    });
Route::screen('riskEditMethod/{riskMethod?}', \App\Orchid\Screens\Risk\RiskEditMethodScreen::class)->name('platform.riskEditMethod.edit')
    ->breadcrumbs(function (Trail $trail){
        return $trail->parent('platform.riskMethod.info', route('platform.riskMethod.info'))->push(__('Настройка метода риска'));
    });
Route::screen('riskBasicInfo', \App\Orchid\Screens\Risk\RiskBasicInfoScreen::class)->name('platform.riskBasic.info')
    ->breadcrumbs(function (Trail $trail){
        return $trail->parent('platform.index', route('platform.riskBasic.info'))->push(__('Информация о параметрах рисков'),  'platform.riskBasic.info');
    });


//Роуты по экранам для мероприятий
Route::screen('actionAnalytic', \App\Orchid\Screens\Action\ActionAnalyticScreen::class)->name('platform.action.analytic')
    ->breadcrumbs(function (Trail $trail){
        return $trail->parent('platform.index', route('platform.action.analytic'))->push(__('Аналитика по мероприятиям'));
    });
Route::screen('actionList', \App\Orchid\Screens\Action\ActionListScreen::class)->name('platform.action.list')
    ->breadcrumbs(function (Trail $trail){
        return $trail->parent('platform.index', route('platform.action.list'))->push(__('Перечень мероприятий'));
    });
Route::screen('actionInfo', \App\Orchid\Screens\Action\ActionInfoScreen::class)->name('platform.action.info')
    ->breadcrumbs(function (Trail $trail){
        return $trail->parent('platform.index', route('platform.action.info'))->push(__('Информация о мероприятиях'));
    });

//For testMenu example
Route::screen('menuTest', MenuTestScreen::class)->name('platform.menuTest');

Route::post('updateCategoryModal', 'App\Orchid\Screens\Unit\UnitTerritoryListScreen@updateCategoryModal')->name('updateCategoryModal');
//Route::screen('idea', 'Idea::class','platform.screens.idea');

