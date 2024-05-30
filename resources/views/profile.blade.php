@extends('layouts.admin.headeradmin')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.updateprofile') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Name:</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $users->name }}" placeholder="Enter Name">
                @error('name') 
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="email">Email:</label>
                <input type="text" class="form-control" id="email" value="{{ $users->email }}" readonly>
            </div>
             <div class="form-group mb-3">
                <label for="address">Address:</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ $userProfile->address }}">
                @error('address') 
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="phone">Phone Number:</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ $userProfile->phone }}">
                @error('phone') 
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="profile_image">Profile Image:</label>
                <input type="file" class="form-control @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image">
                @error('profile_image') 
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                @if($users->profile_image)
                <?php 
                        $profile = URL::to('storage/profile_image/' . $users->profile_image);
                        ?>
                    <img src="{{$profile}}" alt="Profile Image">
                @else
                    <img src="{{ asset('default-profile-image.jpg') }}" alt="Default Profile Image">
                @endif
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success btn-block">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
