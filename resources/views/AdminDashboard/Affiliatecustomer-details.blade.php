@extends ('AdminDashboard.master')

@section('content')


<style>
    .card {
        margin-bottom: 20px;
        padding: 15px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        font-weight: bold;
        margin-bottom: 10px;
    }

    .order-cards-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }


    .icon-container {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 55px; 
    height: 55px; 
    border-radius: 50%; 
    background-color: white; 
    margin: auto; 
}
.icon {
    width: 20px; 
    text-align: center; 
    display: inline-block;
}
.promotion-methods {
    list-style-type: none; 
    padding: 0; 
    margin: 0; 
    display: flex; 
    flex-wrap: wrap;
}

.promotion-methods li {
    margin-right: 15px; 
    padding: 5px;
    background-color: #f1f1f1; 
    border-radius: 4px; 
}

.social-button {
    display: inline-flex;           
    justify-content: center;      
    align-items: center;          
    width: 40px;                  
    height: 40px;                  
    border-radius: 50%;           
    margin: 0 5px;               
    color: white;                  
    font-size: 18px;              
    text-decoration: none;        
    transition: background-color 0.3s; 
}

.instagram-icon {
    background-color: #E1306C; 
}

.facebook-icon {
    background-color: #4267B2; 
}

.tiktok-icon {
    background-color: black;
}

.youtube-icon {
    background-color: #FF0000;
}

.website-icon {
    background-color: #007bff;
}

.whatsapp-icon {
    background-color: #25D366;
}


.social-button:hover {
    opacity: 0.8; 
}

</style>  




<div class="content-header">
    <div>
        <h2 class="content-title card-title">Affiliate Customer Details</h2>
    </div>
</div>


<main>
    <div class="container">
        <div class="order-cards-row mt-2 d-flex">
            <!-- Profile Card -->
            <div class="card" style="width: 35%; margin-right: 2%;">
                <div class="card-title">Profile</div>
                <div class="card-body p-2">
                    <div class="text-center">
                        <div class="profile-image mb-3">
                            <img src="{{ $affiliate->profile_image_url ?? asset('/backend/assets/images/default-user.png') }}" 
                                 alt="Profile Image" class="rounded-circle" width="100" height="100" style="object-fit: cover;">
                        </div>
                        <p class="mb-1 text-muted">USER ID: #{{ $affiliate->id }}</p>
                        <h5 class="mb-2">{{ $affiliate->name }}</h5>
                    </div>

                    <div class="text-start ps-3 mt-4">
                        <p class="mb-1"><i class="fa fa-envelope me-3"></i>{{ $affiliate->email }}</p>
                        <p class="mb-1"><i class="fa-solid fa-phone me-3"></i>{{ $affiliate->contactno }}</p>
                        <p class="mb-1"><i class="fa fa-birthday-cake me-3"></i>{{ $affiliate->DOB->format('Y-m-d') }}</p>
                        <p class="mb-1"><i class="fa-solid fa-address-book me-3"></i>{{ $affiliate->address }}</p>
                    </div>
                </div>
            </div>

            <!-- Other Details Card -->
            <div class="d-flex flex-wrap" style="width: 62%; height: auto;">
                <div class="card item-details-card" style="width: 100%;">
                    <div class="card-body">
                        <h5>Other Details</h5>
                        <div class="ps-3 mt-4">
                            <p class="mb-1"><i class="fa fa-bank icon me-3"></i><span>Bank Name: {{ $affiliate->bank_name }}</span></p>
                            <p class="mb-1"><i class="fa fa-building icon me-3"></i><span>Branch: {{ $affiliate->branch }}</span></p>
                            <p class="mb-1"><i class="fa fa-user icon me-3"></i><span>Account Name: {{ $affiliate->account_name }}</span></p>
                            <p class="mb-1"><i class="fa fa-credit-card icon me-3"></i><span>Account Number: {{ $affiliate->account_number }}</span></p>
                        </div>

                        <div class="text-start ps-3 mt-4">
                            <h6>Promotion Methods</h6>
                            @if($affiliate->promotion_method)
                                <ul class="promotion-methods">
                                    @foreach($affiliate->promotion_method as $method)
                                        <li>{{ $method }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No promotion methods available.</p>
                            @endif
                        </div>

                        <div class="text-start ps-3 mt-4">
                            <h6>Social Media Links</h6>
                            @php
                                $linksAvailable = false; 
                            @endphp

                            @if (!empty($affiliate->instagram_url))
                                <a href="{{ $affiliate->instagram_url }}" target="_blank" class="social-button instagram-icon">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                @php $linksAvailable = true; @endphp
                            @endif

                            @if (!empty($affiliate->facebook_url))
                                <a href="{{ $affiliate->facebook_url }}" target="_blank" class="social-button facebook-icon">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                @php $linksAvailable = true; @endphp
                            @endif

                            @if (!empty($affiliate->tiktok_url))
                                <a href="{{ $affiliate->tiktok_url }}" target="_blank" class="social-button tiktok-icon">
                                    <i class="fab fa-tiktok"></i>
                                </a>
                                @php $linksAvailable = true; @endphp
                            @endif

                            @if (!empty($affiliate->youtube_url))
                                <a href="{{ $affiliate->youtube_url }}" target="_blank" class="social-button youtube-icon">
                                    <i class="fab fa-youtube"></i>
                                </a>
                                @php $linksAvailable = true; @endphp
                            @endif

                            @if (!empty($affiliate->content_website_url))
                                <a href="{{ $affiliate->content_website_url }}" target="_blank" class="social-button website-icon">
                                    <i class="fa fa-globe"></i>
                                </a>
                                @php $linksAvailable = true; @endphp
                            @endif

                            @if (!empty($affiliate->content_whatsapp_url))
                                <a href="{{ $affiliate->content_whatsapp_url }}" target="_blank" class="social-button whatsapp-icon">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                @php $linksAvailable = true; @endphp
                            @endif

                            @if (!$linksAvailable)
                                <p>No social media links available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>






@endsection
