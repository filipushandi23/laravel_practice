<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Items;

class ItemsController extends Controller
{
    private $item;
    public function __construct(Items $items)
    {
        $this->items = $items;
    }

    public function index()
    {
        return json_encode(Items::all());
    }

    public function store(Request $request)
    {
        $item  = new Items();
        $item->name = $request->name;
        $item->category = $request->category;
        $item->price = $request->price;
        $item->save();

        return response()->json(['success' => 'success'], 200);
    }

    public function update(Request $request,$id)
    {
        $item  = Items::findOrFail($id);
        $item->name = $request->name;
        $item->category = $request->category;
        $item->price = $request->price;
        $item->update();

        return response()->json(['success' => 'success'], 200);
    }

    public function delete($id){
        $item = Items::findOrFail($id);
        $item->delete();

        return 204;
    }
}
