@extends('layout.header')

@section('content')
<div class="wishlist_wrapper">
    <div class="container">
        @if (Session::has('error'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('error') }}
            </div>
        @endif

        @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('message') }}
            </div>
        @endif
        <div class="col-sm-12 wishlist_items">
            @foreach ($wishlistItems as $item)
                <div class="col-sm-4 wishlist_product">
                    <div class="products_details">
                        <div class="product_img">
                            <a href="#"><img src="{{ asset('storage/' . $item->product->images) }}" alt="product"></a>
                            <div class="add-to-cart">
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                    <div class="form-group">
                                        <label for="quantity">Quantity:</label>
                                        <input type="number" name="quantity" value="1" min="1" class="form-control" style="width: 60px; display: inline-block;">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                                </form>
                            </div>
                            <div class="like">
                                <form action="{{ route('wishlist.remove') }}" method="POST" class="wishlist-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                    <button type="button" class="btn btn-link wishlist-button">
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="share"><a href="#"><i class="fa fa-share-alt" aria-hidden="true"></i></a></div>
                        </div>
                        <div class="product_content">
                            <p>{{ $item->product->name }}</p>
                            <span>${{ number_format($item->product->price, 2) }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.wishlist-button').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                let form = this.closest('.wishlist-form');
                let formData = new FormData(form);
                let action = form.getAttribute('action');

                fetch(action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'removed') {
                        form.closest('.wishlist_product').remove();
                        window.location.href = "{{ URL::to('/') }}";
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
</script>

@endsection
