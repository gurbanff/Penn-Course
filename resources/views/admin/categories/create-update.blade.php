@extends("layouts.admin")
@section("title")
    Kategori {{ isset($category) ? "Güncelleme" : "Ekleme" }}
@endsection
@section("css")
@endsection

@section("content")
    <x-bootstrap.card>
        <x-slot:header>
            <h2 class="card-title">Makele {{ isset($category) ? "Güncelleme" : "Ekleme" }}</h2>
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
                        <form action="{{ isset($category) ? route('categories.edit', ['id' => $category->id]) : route('category.create') }}" method="POST">
                            @csrf
                            <input type="text"
                                   class="form-control form-control-solid-bordered m-b-sm
                                   @if($errors->has("name"))
                                        border-danger
                                   @endif
                                   "
                                   aria-describedby="solidBoderedInputExample"
                                   placeholder="Category name"
                                   name="name"
                                   value="{{ isset($category) ? $category->name : '' }}"
                                   required
                            >
                            @if($errors->has("name"))
                                {{ $errors->first("name") }}
                            @endif
                            <input type="text"
                                   class="form-control
                                   form-control-solid-bordered
                                   m-b-sm"
                                   aria-describedby="solidBoderedInputExample"
                                   placeholder="Category Slug"
                                   name="slug"
                                   value="{{ isset($category) ? $category->slug : '' }}"
                                   required
                            >
                            <textarea
                                class="form-control form-control-solid-bordered m-b-sm"
                                name="description"
                                id=""
                                cols="30"
                                rows="5"
                                placeholder="Description"
                                style="resize:none;">{{ isset($category) ? $category->description : '' }}</textarea>

                            <input type="number"
                                   class="form-control
                                   form-control-solid-bordered
                                   m-b-sm"
                                   aria-describedby="solidBoderedInputExample"
                                   placeholder="Order"
                                   name="order"
                                   value="{{ isset($category) ? $category->order : '' }}"
                            >
                            <select
                                class="form-control form-control-solid-bordered m-b-sm"
                                aria-label="Category Choose"
                                name="parent_id"
                            >
                                <option value="{{ null }}">Category Choose</option>
                                @foreach($categories as $item)
                                    <option value="{{ $item->id }}" {{ isset($category) && $category->id == $item->id ? '"selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>

                            <textarea
                                class="form-control form-control-solid-bordered m-b-sm"
                                name="seo_keywords"
                                id="seo_keywords"
                                cols="30"
                                rows="5"
                                placeholder="Seo Keywords"
                                style="resize:none;">{{ isset($category) ? $category->seo_keywords : '' }}</textarea>

                            <textarea
                                class="form-control form-control-solid-bordered m-b-sm"
                                name="seo_description"
                                id="seo_description"
                                cols="30"
                                rows="5"
                                placeholder="Seo Description"
                                style="resize:none;">{{ isset($category) ? $category->seo_description : '' }}</textarea>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="status" value="1" id="status" {{ isset($category) && $category->status ? "checked" : '' }}>
                                <label for="" class="form-check-label" for="status">
                                    Kategori sitede gorunsun mu?
                                </label>
                            </div>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="feature_status" value="1" id="feature_status" {{ isset($category) && $category->feature_status ? "checked" : '' }}>
                                <label for="" class="form-check-label" for="feature_status">
                                    Kategori Anasayfada one cikarilsin mi?
                                </label>
                            </div>
                            <hr>
                            <div class="col-4 mx-auto mt-2">
                                <button type="submit" class="btn btn-success btn-rounded w-100">
                                    {{ isset($category) ? "Güncelle" : "Kaydet" }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
        </x-slot:body>
    </x-bootstrap.card>
@endsection

@section("js")
@endsection
