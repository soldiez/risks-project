<?php

namespace App\Orchid\Screens;

use App\Models\Menu;
use Illuminate\Http\Request;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class MenuTestScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'MenuTestScreen';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [

            'menus' => Menu::where('parent_id', '=', 0)->get(),
            'allMenus' => Menu::pluck('title','id')->all(),

            ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            \Orchid\Support\Facades\Layout::view('menu.menuTreeview',['menus','allMenus']),
            \Orchid\Support\Facades\Layout::view('menu.dynamicMenu')

        ];
    }


    public function store(Request $request)
    {
        $request->validate([

            'title' => 'required',
        ]);

        $input = $request->all();
        $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
        Menu::create($input);
       // return back()->with('success', 'Menu added successfully.');
    }

    public function show()
    {
        $menus = Menu::where('parent_id', '=', 0)->get();
        return view('menu.dynamicMenu',compact('menus'));
    }
}
