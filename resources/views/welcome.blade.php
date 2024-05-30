@extends('layout.header')

@section('content')
<div class="homebrands_wrapper">
    <div class="container">
        
        <div class="col-sm-12 homebrands_slider">

            @if (session('success'))
                <script>
                    toastr.success("{{ session('success') }}");
                </script>
            @endif

            @if (session('error'))
                <script>
                    toastr.error("{{ session('error') }}");
                </script>
            @endif

            @foreach ($products as $product)
            <?php $product_name = str_replace("'", "", $product->name); ?>
                <div class="col-sm-4 home_products" data-product-name="{{ $product->name }}">
                    <div class="products_details">
                        <div class="product_img">
                            <a href="#"><img src="{{ asset('storage/' . $product->images) }}" alt="product"></a>
                            <div class="add-to-cart">
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="form-group">
                                        <label for="quantity">Quantity:</label>
                                        <input type="number" name="quantity" value="1" min="1" class="form-control" style="width: 60px; display: inline-block;">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                                </form>
                            </div>
                            <div class="like">
                                <form action="{{ route('wishlist.add') }}" method="POST" class="wishlist-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="button" class="btn btn-link wishlist-button">
                                   
                                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="share">
                                @auth
                                    <a href="#" onclick="openShareModal('{{ $product_name }}', '{{ $product->id }}')">
                                        <i class="fa fa-share-alt" aria-hidden="true"></i>
                                    </a>
                                @else
                                    <a href="#" onclick="showLoginError()">
                                        <i class="fa fa-share-alt" aria-hidden="true"></i>
                                    </a>
                                @endauth
                            </div>

                        </div>
                        <div class="product_content">
                            <p>{{ $product->name }}</p>
                            <span>${{ number_format($product->price, 2) }}</span>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-sm-12 product_nofound" style="display: none;">
                 <div class="noproducts_img">
                     <img src="images/home/no-products.jpg" alt="no-product">
                 </div>
                 <a href="{{ URL::to('/') }}">Back to Home</a>
            </div>
        </div>
    </div>
</div>


<!-- Share Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">Share Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body share_images">
                <input type="hidden" id="productName">
                <input type="hidden" id="productId">
                    <img src="{{ URL::to('images/home/whatsapp_icon.jpg') }}" alt="Share on WhatsApp" onclick="shareOnWhatsApp()">
                    <img src="{{ URL::to('images/home/facebook_icon.jpg') }}" alt="Share on Facebook" onclick="shareOnFacebook()">
                    <img src=" {{ URL::to('images/home/twitter_icon.jpg') }}" alt="Share on Twitter" onclick="shareOnTwitter()">
            </div>
        </div>
    </div>
</div>

<!-- products search  -->
<script>
    $(document).ready(function() {
        function filterProducts(query) {
            var found = false;
            $('.home_products').each(function() {
                if ($(this).data('product-name').toLowerCase().includes(query.toLowerCase())) {
                    $(this).show();
                    found = true;
                } else {
                    $(this).hide();
                }
            });
            if (!found) {
                $('.product_nofound').show();
            } else {
                $('.product_nofound').hide();
            }
        }

        $('#search-form').on('keyup', 'input[name="query"]', function() {
            var query = $(this).val();
            filterProducts(query);
        });
    });
</script>

<!-- products share  -->
<script>
    function showLoginError() {
            toastr.error("Please login to share this product.");
    }
  function openShareModal(productName, productId) {
    document.getElementById('productName').value = productName;
    document.getElementById('productId').value = productId;
    $('#shareModal').modal('show');
  }

  function shareOnWhatsApp() {
        var productName = document.getElementById('productName').value;
        var productId = document.getElementById('productId').value;
        var productImage = document.querySelector('.product_img img').getAttribute('src');
        var productPrice = document.querySelector('.product_content span').textContent;
        var whatsappText = encodeURIComponent(productName + '\nPrice: ' + productPrice + '\n\n' + window.location.origin + '/product/' + productId);
        var whatsappUrl = 'whatsapp://send?text=' + whatsappText;
        window.open(whatsappUrl);
     }

     function shareOnFacebook() {
        var productName = document.getElementById('productName').value;
        var productId = document.getElementById('productId').value;
        var productImage = document.querySelector('.product_img img').getAttribute('src');
        var productPrice = document.querySelector('.product_content span').textContent;
        var productUrl = window.location.origin + '/product/' + productId;
        var metaTags = [
            '<meta property="og:title" content="' + productName + '">',
            '<meta property="og:description" content="Price: ' + productPrice + '">',
            '<meta property="og:image" content="' + productImage + '">',
            '<meta property="og:url" content="' + productUrl + '">'
        ].join('');
        var facebookWindow = window.open('about:blank', 'Facebook Share', 'width=600,height=400');
        var facebookUrl = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(productUrl);
        facebookWindow.document.write('<!DOCTYPE html><html><head>' + metaTags + '</head><body></body></html>');
        facebookWindow.location.href = facebookUrl;
      }

  function shareOnTwitter() {
    var productName = document.getElementById('productName').value;
    var productId = document.getElementById('productId').value;
    var twitterUrl = 'https://twitter.com/intent/tweet?url=' + encodeURIComponent(window.location.origin + '/product/' + productId) + '&text=' + encodeURIComponent(productName);
    window.open(twitterUrl);
  }
</script>

<!-- product wishlist  -->
<script>
    $(document).ready(function() {
        $('.wishlist-button').click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            var productId = form.find('input[name="product_id"]').val();
            var isAdded = $(this).find('i').hasClass('fa-heart');

            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: form.serialize(),
                success: function(response) {
                    if (response.status === 'added') {
                        form.find('i').removeClass('fa-heart-o').addClass('fa-heart');
                    } else {
                        form.find('i').removeClass('fa-heart').addClass('fa-heart-o');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    toastr.error("You need to log in to access this feature. Please log in to continue.");

                }
            });
        });
    });
</script>

@endsection
