<?php

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [

            //Меню для модуля рисков
            Menu::make(__('Риски'))
                ->icon('arrow-right')
                ->list([
                    Menu::make(__('Аналитика по рискам'))
                        ->icon('chart')
                        ->route('platform.risk.analytic') //TODO сделать старничку по аналитике рисков
                    ,
                    Menu::make(__('Профиль рисков'))
                        ->icon('list')
                        ->route('platform.risk.list'),//TODO сделать страничку по профилю рисков
                    Menu::make(__('Методы оценки рисков'))
                        ->icon('info')
                        ->route('platform.riskMethod.info'),//TODO сделать страничку по помощи по методам оценки рисков

                    Menu::make(__('Общие настройки рисков'))
                        ->icon('info')
                        ->route('platform.riskBasic.info'),//TODO сделать страничку по помощи по parameters risk
                ]),

            //Меню для модуля мероприятий
            Menu::make(__('Мероприятия'))
                ->icon('arrow-right')
                ->list([
                    Menu::make(__('Аналитика по мероприятиям'))
                        ->icon('chart')
                        ->route('platform.action.analytic') //TODO сделать старничку по аналитике мероприятий
                    ,
                    Menu::make(__('Перечень мероприятий'))
                        ->icon('list')
                        ->route('platform.action.list'),//TODO сделать страничку по перечню мероприятий
                    Menu::make(__('Информация о мероприятиях'))
                        ->icon('info')
                        ->route('platform.action.info'),//TODO сделать страничку по помощи по мероприятиям
                ]),


            //Меню для модуля списков
            Menu::make(__('Параметры компании'))
                ->icon('arrow-right')
                ->list([
                    Menu::make('Предприятия')
                        ->icon('building')
                        ->route('platform.unit.list'),
                    Menu::make('Территории')
                        ->icon('map')
                        ->route('platform.unit.territory.list'),
//                    Menu::make('Подразделения')
//                        ->icon('organization')
//                        ->route('platform.unit.department.list'),
//                    Menu::make('Должности')
//                        ->icon('wrench')
//                        ->route('platform.unit.jobPosition.list'),
                    Menu::make('Сотрудники')
                        ->icon('people')
                        ->route('platform.worker.list'),
                    Menu::make('Справочники')
                        ->icon('database')
                        ->route('platform.directory'),
                    Menu::make('Параметры')
                        ->icon('config')
                        ->route('platform.value')
                ]),


            Menu::make('Example screen')
                ->icon('monitor')
                ->route('platform.example')
                ->title('Navigation')
                ->badge(function () {
                    return 6;
                }),

            Menu::make('Dropdown menu')
                ->icon('code')
                ->list([
                    Menu::make('Sub element item 1')->icon('bag'),
                    Menu::make('Sub element item 2')->icon('heart'),


                    Menu::make('Basic Elements')
                        ->title('Form controls')
                        ->icon('note')
                        ->route('platform.example.fields'),

                    Menu::make('Advanced Elements')
                        ->icon('briefcase')
                        ->route('platform.example.advanced'),

                    Menu::make('Text Editors')
                        ->icon('list')
                        ->route('platform.example.editors'),

                    Menu::make('Overview layouts')
                        ->title('Layouts')
                        ->icon('layers')
                        ->route('platform.example.layouts'),

                    Menu::make('Chart tools')
                        ->icon('bar-chart')
                        ->route('platform.example.charts'),

                    Menu::make('Cards')
                        ->icon('grid')
                        ->route('platform.example.cards')
                        ->divider(),

//            Menu::make('Documentation')
//                ->title('Docs')
//                ->icon('docs')
//                ->url('https://orchid.software/en/docs'),
//
//            Menu::make('Changelog')
//                ->icon('shuffle')
//                ->url('https://github.com/orchidsoftware/platform/blob/master/CHANGELOG.md')
//                ->target('_blank')
//                ->badge(function () {
//                    return Dashboard::version();
//                }, Color::DARK()),

                    Menu::make(__('Users'))
                        ->icon('user')
                        ->route('platform.systems.users')
                        ->permission('platform.systems.users')
                        ->title(__('Access rights')),

                    Menu::make(__('Roles'))
                        ->icon('lock')
                        ->route('platform.systems.roles')
                        ->permission('platform.systems.roles'),

                ]),
        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make('Profile')
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }

    /**
     * @return string[]
     */
    public function registerSearchModels(): array
    {
        return [
            // ...Models
            // \App\Models\User::class
        ];
    }
}
