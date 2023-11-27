@extends("layouts.admin")
@section("title")
    Makele Ekleme Ya Da Güncelleme
@endsection
@section("css")
@endsection

@section("content")
    <x-bootstrap.card>
        <x-slot:header>
            <h2 class="card-title">Makele Ekleme</h2>
        </x-slot:header>

        <x-slot:body>
            <p class="card-description">Hello World</p>
                <div class="example-container">
                    <div class="example-content">
                        <form action="{{ route('category.create') }}" method="POST">
                            @csrf
                            <input type="text"
                                   class="form-control
                                   form-control-solid-bordered
                                   m-b-sm"
                                   aria-describedby="solidBoderedInputExample"
                                   placeholder="Category name"
                                   name="name"
                                   required
                            >
                            <input type="text"
                                   class="form-control
                                   form-control-solid-bordered
                                   m-b-sm"
                                   aria-describedby="solidBoderedInputExample"
                                   placeholder="Category Slug"
                                   name="slug"
                                   required
                            >
                            <textarea
                                class="form-control form-control-solid-bordered m-b-sm"
                                name="description"
                                id=""
                                cols="30"
                                rows="5"
                                placeholder="Description"
                                style="resize:none;"></textarea>

                            <input type="number"
                                   class="form-control
                                   form-control-solid-bordered
                                   m-b-sm"
                                   aria-describedby="solidBoderedInputExample"
                                   placeholder="Order"
                                   name="order"
                            >
                            <select
                                class="form-control form-control-solid-bordered m-b-sm"
                                aria-label="Category Choose"
                                name="parent_id"
                            >
                                <option value="{{ null }}">Category Choose</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                            <textarea
                                class="form-control form-control-solid-bordered m-b-sm"
                                name="seo_keywords"
                                id="seo_keywords"
                                cols="30"
                                rows="5"
                                placeholder="Seo Keywords"
                                style="resize:none;"></textarea>

                            <textarea
                                class="form-control form-control-solid-bordered m-b-sm"
                                name="seo_description"
                                id="seo_description"
                                cols="30"
                                rows="5"
                                placeholder="Seo Description"
                                style="resize:none;"></textarea>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="status" value="1" id="status">
                                <label for="" class="form-check-label" for="status">
                                    Kategori sitede gorunsun mu?
                                </label>
                            </div>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="feature_status" value="1" id="feature_status">
                                <label for="" class="form-check-label" for="feature_status">
                                    Kategori Anasayfada one cikarilsin mi?
                                </label>
                            </div>
                            <hr>
                            <div class="col-4 mx-auto mt-2">
                                <button type="submit" class="btn btn-success btn-rounded w-100">Success</button>
                            </div>
                        </form>
                    </div>
                </div>
        </x-slot:body>
    </x-bootstrap.card>
@endsection

@section("js")
@endsection
