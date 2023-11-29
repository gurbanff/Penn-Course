<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Psy\Util\Str;


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
        $categories = Category::all();

        return view("admin.categories.create-update", compact("categories"));
    }

    public function store(CategoryStoreRequest $request)
    {

        $slug = Str::slug($request->slug);

        try
        {
            $category                  = new Category();
            $category->name            = $request->name;
            $category->color            = $request->color;
            $category->slug            = is_null($this->slugCheck($slug)) ? $slug : Str::slug($slug . time());
            $category->description     = $request->description;
            $category->status          = $request->status ? 1 : 0;
            $category->parent_id       = $request->parent_id;
            $category->feature_status  = $request->feature_status ? 1 : 0;
            $category->seo_keywords    = $request->seo_keywords;
            $category->seo_description = $request->seo_description;
            $category->user_id         = random_int(1, 10);
            $category->order           = $request->order;

            $category->save();
        }catch (\Exception $exception)
        {
            abort(404, $exception->getMessage());
        }
        alert()->success('Başarılı', " Kategori kaydedildi")->showConfirmButton("Tamam", "#308d6")->autoClose(5000);
        return redirect()->back();
    }

    public function slugCheck(string $text)
    {
        return Category::where("slug", $text)->first();
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

    public function changeFeatureStatus(Request $request)
    {
        $request->validate(['id' => ['required', 'integer', 'exists:categories']]);

        $categoryID = $request->id;

        $category = Category::where("id", $categoryID)->first();

        $oldStatus = $category->feature_status;

        $category->feature_status = !$category->feature_status;
        $category->save();

        $statusText = ($oldStatus == 1 ? "Aktif" : "Pasif") . "ten " . ($category->feature_status == 1 ? "Aktif" : "Pasif");

        alert()->success('Başarılı', $category->name . " feature status degeri " . $statusText . " olarak guncellendi")->showConfirmButton("Tamam", "#308d6")->autoClose(5000);

        return redirect()->route("category.index");

    }

    public function delete(Request $request)
    {
        $request->validate(['id' => ['required', 'integer', 'exists:categories']]);
        $categoryID = $request->id;

        Category::where("id", $categoryID)->delete();

        $statusText = "Kategori Silindi";

        alert()->success('Basarili', $statusText)->showConfirmButton("Tamam", "#3085d6");

        return redirect()->route("category.index");
    }

    public function edit(Request $request)
    {
        $categories = Category::all();

        $categoryID = $request->id;

        $category = Category::where("id", $categoryID)->first();

        if (is_null($category))
        {
            $statusText = "Kategori bulunamadi";

            alert()->error("Hata", $statusText)->showConfirmButton("Tamam", "#3085d6")->autoClose(5000);
            return redirect()->route("category.index");
        }

        return view("admin.categories.create-update", compact("category", "categories"));
    }

}
