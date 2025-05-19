@extends('layouts.main')
@section('style')
<style>
    /* ألوان رئيسية */
    :root {
        --primary: #6C63FF; /* أزرق بنفسجي */
        --secondary: #FF9F43; /* برتقالي فاتح */
        --accent: #FF6B6B; /* أحمر مخملي */
        --bg: #F8F9FA;
        --card-bg: rgba(255, 255, 255, 0.95);
    }

    .video-card {
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    }

    .video-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .btn-gradient {
        background: linear-gradient(45deg, var(--primary), var(--secondary));
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        transform: scale(1.05);
    }
</style>
<style>
    .hero-section {
        background: linear-gradient(135deg, #6C63FF, #2E2EFE);
        color: white;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: "";
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: radial-gradient(circle at center, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        backdrop-filter: blur(5px);
        z-index: 1;
    }

    .hero-section > * {
        position: relative;
        z-index: 2;
    }
</style>
@endsection

@section('content')
<div class="row justify-content-center mb-4">
    <div class="col-md-6">
        <form class="d-flex justify-content-center" action="{{ route('channel.search') }}" method="GET">
            <input type="text" class="form-control rounded me-2 flex-grow-1" name="title" placeholder="ابحث عن فيديو...">
            <button type="submit" class="btn btn-gradient flex-shrink-0">ابحث</button>
        </form>
    </div>
</div>
        <hr>
        <br>
    <div class="container py-5">
    <div class="hero-section text-center p-6 mb-6 rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold text-white">{{ $title }}</h2>
        <p class="mt-2 text-indigo-100">استمتع بتجربة مميزة مع أفضل القنوات</p>
    </div>

    <div class="row g-4 justify-content-center">
        @forelse ($channels as $channel)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card shadow-sm border-0 rounded-3 overflow-hidden video-card h-100">
                    <div class="d-flex justify-content-center p-4">
                        <img src="{{ $channel->profile_photo_url }}" 
                             alt="صورة الملف الشخصي"
                             class="rounded-circle border border-3 border-primary" 
                             width="120" height="120">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="font-semibold text-lg mb-2">{{ $channel->name }}</h5>
                        <a href="{{ route('main.channels.videos' , $channel->id) }}" class="btn btn-gradient w-100">تصفح القناة</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-6 rounded-lg inline-block">
                    <p class="font-medium text-lg">لا يوجد قنوات متاحة</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection