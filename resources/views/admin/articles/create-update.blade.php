@extends("layouts.admin")
@section("title")
    Makale {{ isset($article) ? "Güncelleme" : "Ekleme" }}
@endsection
@section("css")
    <link href="{{ asset("assets/plugins/flatpickr/flatpickr.min.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/plugins/summernote/summernote-lite.min.css") }}" rel="stylesheet">
@endsection

@section("content")
    <x-bootstrap.card>
        <x-slot:header>
            <h2 class="card-title">Makele {{ isset($article) ? "Güncelleme" : "Ekleme" }}</h2>
        </x-slot:header>

        <x-slot:body>
            {{--<p class="card-description">Hello World</p>--}}
            <div class="example-container">
                <div class="example-content">
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                        <form action="{{ isset($article) ? route('article.edit', ['id' => $article->id]) : route('article.create') }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <label class="form-label m-b-sm" for="title">Makale Başlık</label>
                        <input type="text"
                               class="form-control form-control-solid-bordered m-b-sm
                                   @if($errors->has("title"))
                                        border-danger
                                   @endif
                                   "
                               placeholder="Makale Basligi"
                               name="title"
                               id="title"
                               value="{{ isset($article) ? $article->title : '' }}"
                               required
                        >

                        @if($errors->has("title"))
                            {{ $errors->first("title") }}
                        @endif

                        <label class="form-label m-b-sm" for="slug">Makale Slug</label>
                        <input type="text"
                               class="form-control form-control-solid-bordered m-b-sm"
                               placeholder="Category Slug"
                               name="slug"
                               id="slug"
                               value="{{ isset($article) ? $article->slug : '' }}"
                               required
                        >

                        <label class="form-label m-b-sm" for="tags">Etiketler</label>
                        <input type="text"
                               class="form-control form-control-solid-bordered"
                               placeholder="Tags"
                               name="tags"
                               id="tags"
                               value="{{ isset($article) ? $article->tags : '' }}"
                               required
                        >

                        <div class="form-text m-b-sm" id="tags">Herbir etiketi virgüllerle ayırarak yazın.</div>

                        <label class="form-label m-b-sm" for="category_id">Kategori</label>
                        <select
                            class="form-select form-control form-control-solid-bordered m-b-sm"
                            name="category_id"
                            id="category_id"
                        >
                            <option value="{{ null }}">Kategori Seçimi</option>
                            @foreach($categories as $item)
                                <option value="{{ $item->id }}" {{ isset($article) && $article->category_id == $item->id ? "selected" : "" }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>

                        <label class="form-label m-b-sm" for="summernote">İçerik</label>
                        <div id="summernote" class="my-3">Hello Summernote</div>

                        <label class="form-label m-t-sm" for="seo_keywords">Seo Anahtar Kelimeler</label>
                        <textarea
                            class="form-control form-control-solid-bordered"
                            name="seo_keywords"
                            id="seo_keywords"
                            cols="30"
                            rows="5"
                            placeholder="Seo Keywords"
                            style="resize:none;">{{ isset($article) ? $article->seo_keywords : '' }}</textarea>

                        <label class="form-label m-t-sm" for="seo_description">Açıklama</label>
                        <textarea
                            class="form-control form-control-solid-bordered"
                            name="seo_description"
                            id="seo_description"
                            cols="30"
                            rows="5"
                            placeholder="Seo Description"
                            style="resize:none;">{{ isset($article) ? $article->seo_description : '' }}</textarea>

                        <label class="form-label m-t-sm" for="publish_date">Yayınlama Tarihi</label>
                        <input class="form-control flatpickr2"
                               id="publish_date"
                               name="publish_date"
                               type="text"
                               placeholder="Ne zaman yayinlansin?">

                        <label for="image" class="form-label m-t-sm">Makale Görseli</label>
                        <input type="file"
                               name="image"
                               id="image"
                               class="form-control file-manager-folder form-control-solid-bordered"
                               accept="image/png, image/jpeg, image/jpg">
                        <div class="form-text m-b-sm">Makele Görseli Maksimum 2mb olmalıdır.</div>

                        @if(isset($article) && $article->image)
                            <img src="{{ asset($article->image) }}" class="img-fluid" style="max-height: 200px">
                        @endif

                        <div class="form-check my-3">
                            <input type="checkbox" class="form-check-input" name="status" value="1" id="status" {{ isset($article) && $article->status ? "checked" : '' }}>
                            <label for="" class="form-check-label" for="status">
                                Makale sitede Aktif olarak gorunsun mu?
                            </label>
                        </div>
                        <hr>
                        <div class="col-4 mx-auto mt-2">
                            <button type="submit" class="btn btn-success btn-rounded w-100">
                                {{ isset($article) ? "Güncelle" : "Kaydet" }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </x-slot:body>
    </x-bootstrap.card>
@endsection

@section("js")
    <script src="{{ asset("assets/js/pages/datepickers.js") }}"></script>
    <script src="{{ asset("assets/plugins/flatpickr/flatpickr.js") }}"></script>
    <script src="{{ asset("assets/js/pages/text-editor.js") }}"></script>
    <script src="{{ asset("assets/plugins/summernote/summernote-lite.min.js") }}"></script>
    <script>
        $("#publish_date").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });
    </script>
@endsection


