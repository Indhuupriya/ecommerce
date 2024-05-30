@extends('layouts.admin.headeradmin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('admin.updateSettings') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Enter Title" value="{{ old('title', $settings['title'] ?? '') }}" name="title">
                                @error('title') 
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="meta_title">Meta Title:</label>
                                <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" placeholder="Enter Meta Title" value="{{ old('meta_title', $settings['meta_title'] ?? '') }}" name="meta_title">
                                @error('meta_title') 
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="meta_key">Meta Key:</label>
                                <input type="text" class="form-control @error('meta_key') is-invalid @enderror" id="meta_key" placeholder="Enter Meta Key" value="{{ old('meta_key', $settings['meta_key'] ?? '') }}" name="meta_key">
                                @error('meta_key') 
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="meta_desc">Meta Description:</label>
                                <textarea class="form-control @error('meta_desc') is-invalid @enderror" id="meta_desc" placeholder="Enter Meta Description" name="meta_desc">{{ old('meta_desc', $settings['meta_desc'] ?? '') }}</textarea>
                                @error('meta_desc') 
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="favicon">Favicon:</label>
                                <input type="file" class="form-control @error('favicon') is-invalid @enderror" id="favicon" name="favicon">
                                @error('favicon') 
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                @if(isset($settings['favicon']))
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $settings['favicon']) }}" alt="Favicon" style="width: 50px; height: 50px;">
                                    </div>
                                @endif
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-block">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
