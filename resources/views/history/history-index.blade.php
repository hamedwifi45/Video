@extends('layouts.main')

@section('style')
    <style>
        /* ألوان وفق نظرية التنسيق اللوني (60-30-10) */
        :root {
            --primary: #6C63FF; /* أزرق بنفسجي (لون رئيسي) */
            --secondary: #FF9F43; /* برتقالي فاتح (لون ثانوي) */
            --accent: #FF6B6B; /* أحمر مخملي (تركيز) */
            --bg: #F8F9FA; /* خلفية فاتحة */
            --card-bg: rgba(255, 255, 255, 0.95);
        }

        .hero {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .video-card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        .video-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .card-icons {
            position: relative;
            overflow: hidden;
        }

        .card-icons img {
            width: 100%;
            height: auto;
            transition: transform 0.5s ease;
        }

        .video-card:hover .card-icons img {
            transform: scale(1.05);
        }

        .play-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: var(--accent);
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .card-icons:hover .play-button {
            opacity: 1;
        }

        .time-badge {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 4px 8px;
            border-radius: 5px;
            font-size: 0.8rem;
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

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 1.8rem;
            }
        }
    </style>
@endsection

@section('content')
    <!-- قسم العنوان مع تأثير الـ Hero -->
    <div class="container mx-auto px-4 py-8">
        <div class="hero text-center">
            <h1 class="text-4xl font-bold mb-4">{{ $title }}</h1>
            <form action="{{route('History.delete.all')}}" method="post">
            @csrf    
            <button class="btn btn-danger" type="submit">اضغط لحذف السجل كامل</button>
            </form>
        </div>

        <!-- الشبكة (Grid) مع بطاقات الفيديو -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse ($videos as $video)
                @if ($video->processed)
                    <div class="video-card m-2">
                        <div class="card-icons relative">
                            <a href="/videos/{{ $video->id }}" class="block relative">
                                <img src="{{ Storage::url($video->image_path) }}" 
                                     class="w-full h-48 object-cover" 
                                     alt="{{ $video->title }}">
                                <div class="time-badge">
                                    {{ $video->hours > 0 ? sprintf('%02d', $video->hours) . ':' : '' }}
                                    {{ sprintf('%02d', $video->minutes) }}:{{ sprintf('%02d', $video->seconds) }}
                                </div>
                                <div class="play-button">
                                    <i class="fas fa-play text-white text-xl"></i>
                                </div>
                            </a>
                        </div>
                        
                        <div class="p-5">
                            <h2 class="text-xl font-semibold text-gray-800 truncate">{{ Str::limit($video->title, 60) }}</h2>
                        </div>
                        
                        <div class="p-5 pt-0">
                            <small class="text-gray-600 flex justify-between items-center">
                                @foreach ($video->views as $view)
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-eye"></i> {{ $view->views_number }} مشاهدة
                                </span>
                                
                                @endforeach
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i> {{ $video->pivot->created_at->diffForHumans() }}
                                </span>
                                
                                @auth
    @if ($video->user_id == auth()->user()->id || auth()->user()->admin_level > 0)
        <div class="flex gap-3">
            <!-- زر حذف الفيديو -->
            <form action="{{ route('videos.destroy', $video->id) }}" method="POST"
                  onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذا الفيديو؟')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 transition">
                    <i class="far fa-trash-alt fa-lg" title="حذف الفيديو"></i>
                </button>
            </form>

            <!-- زر تعديل الفيديو -->
            <form action="{{ route('videos.edit', $video->id) }}" method="GET">
                @csrf
                <button type="submit" class="text-blue-500 hover:text-blue-700 transition">
                    <i class="far fa-edit fa-lg" title="تعديل الفيديو"></i>
                </button>
            </form>
        </div>
    @endif

    <!-- زر حذف من السجل فقط -->
    <form action="{{ route('History.delete', $video->id) }}" method="POST">
        @csrf
        <button type="submit" class="text-gray-500 hover:text-gray-700 transition">
            <i class="far fa-trash-alt fa-lg" title="حذف من السجل"></i>
        </button>
    </form>
@endauth
                            </small>
                        </div>
                    </div>
                @endif
            @empty
                <div class="col-span-full">
                    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-6 rounded-lg text-center">
                        <p class="font-medium text-lg">لا توجد فيديوهات متاحة</p>
                        <button class="btn-gradient mt-4">تصفح الفئات</button>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // تأثيرات إضافية باستخدام JavaScript (اختياري)
        document.addEventListener('DOMContentLoaded', () => {
            console.log('تصميم مُحسّن مع تنسيق ألوان مذهل تم تحميله!');
        });
    </script>
@endsection