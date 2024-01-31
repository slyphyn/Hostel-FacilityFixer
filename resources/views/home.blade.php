@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                
                    <div class="d-flex justify-content-center align-items-center flex-column mb-3">
                        <h3>Hey, {{ auth()->user()->name }}!</h3>
                        <p>{{ __('Welcome to Hostel FacilityFixer for Kolej Tun Fatimah residents.') }}</p>
                        <img src="{{ asset('images/ilovektf.png') }}" class="img-fluid" alt="KTF Logo">
                    </div>
                </div>
                <div class="text-center">
                    <h4>Contact Us</h4>
                    <ul class="list-unstyled">
                        <li><strong>Phone:</strong> (6) 07 55 37259 / 37255</li>
                        <li><strong>Email:</strong> <a href="mailto:ktf@utm.my">ktf@utm.my</a></li>
                        <li><strong>Website:</strong> <a href="https://dvcdev.utm.my/hospitality" target="_blank">https://dvcdev.utm.my/hospitality</a></li>
                    </ul>
        
                    <p class="mt-3"><strong>Office Hours:</strong></p>
                    <ul class="list-unstyled">
                        <li><strong>Sunday – Wednesday:</strong> 08.00 A.M – 05.00 P.M</li>
                        <li><strong>Thursday:</strong> 08.00 A.M – 03.30 P.M</li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
