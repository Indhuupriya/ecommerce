@extends('layouts.admin.headeradmin')
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
<<<<<<< HEAD
                <label for="name">Slug:</label>
                <input type="text" name="slug" id="slug" class="form-control">
                @error('slug')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
=======
>>>>>>> abf70130a6b3add7269e80a3c226d04f2f7bf96d
                <label for="price">Price:</label>
                <input type="text" name="price" id="price" class="form-control">
                @error('price')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" class="form-control"></textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="images">Images:</label>
                <input type="file" name="images[]" id="images" class="form-control" multiple>
                @error('images')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>
</div>
<<<<<<< HEAD
<script>
    // JavaScript function to generate slug
    document.getElementById('slug').addEventListener('input', function () {
        const nameValue = this.value;
        const slugValue = nameValue
            .toLowerCase()
            .replace(/ /g, '-')        
            .replace(/[^\w-]+/g, '');  

        document.getElementById('slug').value = slugValue;
    });
</script>
=======
>>>>>>> abf70130a6b3add7269e80a3c226d04f2f7bf96d
@endsection
