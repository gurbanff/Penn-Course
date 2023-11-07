<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {

        $categories = Category::with(["parentCategory:id,name", "user"])
            ->orderBy("order", "DESC")
            ->paginate(5);

        return view("admin.categories.list", ["list" => $categories]);
    }

    public function create()
    {
        return view("admin.categories.create-update");
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer', 'exists:categories']
        ]);

        $categoryID = $request->id;

        $category = Category::where("id", $categoryID)->first();

        $oldStatus = $category->status;

        $category->status = !$category->status;

        $category->save();

        alert()
            ->success("Basarili", $category->name . " statusu $oldStatus 'ten " . !$category->status . " guncellendi")
            ->autoClose(5000)
            ->showConfirmButton("Tama", "#3085d6");

        return redirect()->route("category.index");

    }
}
