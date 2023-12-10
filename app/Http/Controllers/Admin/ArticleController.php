<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleCreateReqeust;
use App\Http\Requests\ArticleFilterRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Models\UserLikeArticle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use function PHPUnit\Framework\fileExists;

class ArticleController extends Controller
{

    public function index()
    {
        return view("admin.articles.list");
    }

    public function create()
    {
        $categories = Category::all();

        return view("admin.articles.create-update", compact("categories"));
    }

    public function edit(Request $request, int $articleID)
    {
//        $article = Article::find($articleID);
//        $article = Article::where("id", $articleID)->firstOrFail();
        $article = Article::query()
                            ->where("id", $articleID)
                            ->first();
        $categories = Category::all();
        $users = User::all();
        if (is_null($article))
        {
            $statusText = "Makele bulunamadi";

            alert()->error("Hata", $statusText)->showConfirmButton("Tamam", "#3085d6")->autoClose(5000);
            return redirect()->route("article.index");
        }

        return view("admin.articles.create-update", compact("article", "categories", "users"));

        dd($article);
    }

    public function update(ArticleUpdateRequest $request)
    {
        dd($request->all());
    }

    public function store(ArticleCreateReqeust $request)
    {
        $imageFile = $request->file("image");
        $originalName = $imageFile->getClientOriginalName();
        $originalExtension = $imageFile->getClientOriginalExtension();
        $explodeName = explode(".", $originalName)[0];
        $fileName = Str::slug($explodeName) . "." . $originalExtension;

        $folder = "articles";
        $publicPath = "storage/" . $folder;

        if (file_exists(public_path($publicPath . $fileName)))
        {
            return redirect()
                ->back()
                ->withErrors([
                    "image" => "Ayni gorsel daha once yuklenmistir."
                ]);
        }

        $data = $request->except("_token");
        $slug = $data['slug'] ?? $data['title'];
        $slug = Str::slug($slug);
        $slugTitle = Str::slug($data["title"]);

        $checkSlug = $this->slugCheck($slug);

        if (!is_null($checkSlug))
        {
            $checkTitleSlug = $this->slugCheck($slugTitle);
            if (!is_null($checkTitleClug))
            {
                // Title slug dolu geldiyse
                $slug = Str::slug($slug . time());
            }
            else
            {
                $slug = $slugTitle;
            }
        }

        $data['slug'] = $slug;
        $data['image'] = $publicPath . "/" . $folder;
        $data['user_id'] = auth()->id();
//        $data['user_id'] = auth()->user()->id();
//        $data['user_id'] = \Auth::id();
//        $data['user_id'] = \Auth::user()->id;

        Article::created($data);
        $imageFile->storeAs($folder, $fileName);

        alert()->success('Başarılı', " Makale kaydedildi")->showConfirmButton("Tamam", "#308d6")->autoClose(5000);
        return redirect()->back();

//        $imageFile->store("articles", "public");

    }

    public function slugCheck(string $text)
    {
        return Article::where("slug", $text)->first();
    }
}
