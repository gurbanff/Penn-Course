@extends("layouts.admin")
@section("title")
    Kategori Listleme
@endsection
@section("css")
    <style>
        .table-hover > tbody > tr:hover {
            --bs-table-hover-bg: transparent;
            color: #fff;
            background: #363638;
        }
    </style>
@endsection

@section("content")
    <x-bootstrap.card>
        <x-slot:header>
            <h2 class="card-title">Kategori Listesi</h2>
        </x-slot:header>

        <x-slot:body>
            <x-bootstrap.table
                :class="'table-responsive'"
                :is-responsive="1"
            >
                <x-slot:columns>
                    <th scope="col">Name</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Status</th>
                    <th scope="col">Feature Status</th>
                    <th scope="col">Description</th>
                    <th scope="col">Order</th>
                    <th scope="col">Parent Category</th>
                    <th scope="col">User</th>
                    <th scope="col">Actions</th>
                </x-slot:columns>

                <x-slot:rows>
                    @foreach($list as $category)
                        <tr>
                            <th scope="row">{{ $category->name  }}</th>
                            <td>{{ $category->slug }}</td>
                            <td>
                                @if($category->status)
                                    <a href="javascript:void(0)" data-id="{{ $category->id }}" class="btn btn-success btn-sm btnChangeStatus">Aktif</a>
                                @else
                                    <a href="javascript:void(0)" data-id="{{ $category->id }}" class="btn btn-danger btn-sm btnChangeStatus">Pasif</a>
                                @endif
                            </td>
                            <td>
                                @if($category->feature_status)
                                    <a href="javascript:void(0)" data-id="{{ $category->id }}" class="btn btn-success btn-sm btnChangeFeatureStatus">Aktif</a>
                                @else
                                    <a href="javascript:void(0)" data-id="{{ $category->id }}" class="btn btn-danger btn-sm btnChangeFeatureStatus">Pasif</a>
                                @endif
                            </td>
                            <td title="{{ $category->description }}">
                                {{ substr($category->description, 0, 20) }}
                            </td>
                            <td>
                                {{ $category->order }}
                            </td>
                            <td>
                                {{ $category->parentCategory?->name }}
                            </td>
                            <td>
                                {{ $category->user->name }}
                            </td>
                            <td>
                                <div class="d-flex">
{{--                                    <a href="{{ route('categories.edit', ['id' => $category->id]) }}"--}}
                                    <a href="javascript:void(0)"
                                       class="btn btn-warning btn-sm">
                                        <i class="material-icons ms-0">edit</i>
                                    </a>

                                    <a href="javascript:void(0)"
                                       class="btn btn-danger btn-sm
                                       data-name='{{ $category->name }}'
                                       data-id='{{ $category->id }}' ">
                                        <i class="material-icons ms-0">delete</i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-slot:rows>
            </x-bootstrap.table>
            <div class="d-flex justify-content-center">
                {{ $list->onEachside(1)->links() }}
            </div>
        </x-slot:body>
    </x-bootstrap.card>
    <form action="" method="POST" id="statusChangeForm">
        @csrf
        <input type="hidden" name="id" id="inputStatus" value="">
    </form>
@endsection

@section("js")
    <script>
        $(document).ready(function ()
        {
            $('.btnChangeStatus').click(function () {
                let categoryID = $(this).data('id');
                $('#inputStatus').val(categoryID);

                Swal.fire({
                    title: 'Status degistirmek istediginize emin misiniz?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Evet',
                    denyButtonText: `Hayir`,
                    cancelButtonText: "Iptal",
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {

                        $('#statusChangeForm').attr("action", "{{ route("categories.changeStatus") }}");
                        $('#statusChangeForm').submit();

                    } else if (result.isDenied) {

                        Swal.fire({
                            title: "Bilgi",
                            text: "Herhangi bir islem yapilmadi!",
                            confirmButtonText: 'Tamam',
                            icon: "info",
                        });
                    }
                })


            });
        });
    </script>
@endsection