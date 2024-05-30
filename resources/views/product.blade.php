@extends('layouts.admin.headeradmin')
@section('content')
<div class="card shadow mb-4">
        <div class="box-header">
                <div style="float:right;">    
                    <a href="{{ route('admin.create') }}" class="btn btn-primary btn-sm float-right">Add Products</a>
                </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                                @if (count($products) > 0)
                                    @foreach ($products as $product)
                                    <tr class="admin_products" data-product-name="{{ $product->name }}">
                                        <td>
                                            {{$product->id}}
                                        </td>
                                        <td>
                                            {{$product->name}}
                                        </td>
                                        <td>
                                            {{$product->price}}
                                        </td>
                                        <td>
                                            {{ Illuminate\Support\Str::limit($product->description, 150) }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.edit', ['id' => $product->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <a href="{{ route('admin.delete', ['id' => $product->id]) }}" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5" align="center">
                                            No Pages Found.
                                        </td>
                                    </tr>
                                @endif
                                <tr class="product_nofound" style="display:none">
                                        <td colspan="5" align="center">
                                            No Pages Found.
                                        </td>
                                </tr>
                    </tbody>
                </table>
            </div>
        </div>
</div>
<div class="d-flex mt-2 float-right">
    {{ $products->links() }}
</div>


@endsection
