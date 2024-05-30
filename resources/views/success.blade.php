@extends('layout.header')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Payment Successful</div>

                <div class="panel-body">
                    <div class="alert alert-success">
                        Your payment was successful. Thank you for your purchase!
                    </div>
                    <a href="{{ route('/') }}" class="btn btn-primary">Return to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
