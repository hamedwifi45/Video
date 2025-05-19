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

    .container-video {
        background-color: var(--bg);
        padding: 2rem;
        border-radius: 1rem;
    }

    .vidcontainer {
        position: relative;
        max-width: 900px;
        margin: auto;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    video {
        width: 100%;
        height: auto;
        display: block;
        background-color: #000;
        border-radius: 1rem;
    }

    select#qualityPick {
        margin-top: 1rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        border: 1px solid #ddd;
        background-color: white;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    select#qualityPick:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 8px rgba(108, 99, 255, 0.3);
    }

    .title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        margin: 1rem 0;
    }

    .interaction {
        background-color: var(--card-bg);
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        padding: 1rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .like i {
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .like i:hover {
        transform: scale(1.1);
    }

    .liked i {
        color: var(--accent);
    }

    .comments {
        margin-top: 2rem;
    }

    .commentBody .card {
        background-color: var(--card-bg);
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        transition: transform 0.3s ease;
    }

    .commentBody .card:hover {
        transform: translateY(-5px);
    }

    textarea#comment {
        resize: none;
        border-radius: 1rem;
        padding: 1rem;
        border: 1px solid #ddd;
        background-color: #fff;
        transition: all 0.3s ease;
    }

    textarea#comment:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 8px rgba(108, 99, 255, 0.3);
    }

    .savedcomment {
        background: linear-gradient(45deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .savedcomment:hover {
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .title {
            font-size: 1.2rem;
        }
    }
</style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="mx-auto col-9">
                <div class="vidcontainer">
                    <input type="hidden" value="{{$video->id}}" id="videoId">
                    @foreach($video->convert as $videoc)
                    <video id="videoPlayer" class="" style="{{$video->longi == '0' ? 'width: 100%; height: 90%;' : 'width:900px; height:510px'}}" controls>
                        @if ($video->quality == 1080)
                            <source id="webm_source" src="{{Storage::url($videoc->webm_Format_1080)}}" type='video/webm'>
                            <source id="mp4_source" src="{{Storage::url($videoc->mp4_Format_1080)}}" type='video/mp4'>
                        @elseif($video->quality == 720)
                            <source id="webm_source" src="{{Storage::url($videoc->webm_Format_720)}}" type='video/webm'>
                            <source id="mp4_source" src="{{Storage::url($videoc->mp4_Format_720)}}" type='video/mp4'>
                        @elseif($video->quality == 480)
                            <source id="webm_source" src="{{Storage::url($videoc->webm_Format_480)}}" type='video/webm'>
                            <source id="mp4_source" src="{{Storage::url($videoc->mp4_Format_480)}}" type='video/mp4'>
                        @elseif($video->quality == 360)
                            <source id="webm_source" src="{{Storage::url($videoc->webm_Format_360)}}" type='video/webm'>
                            <source id="mp4_source" src="{{Storage::url($videoc->mp4_Format_360)}}" type='video/mp4'>
                        @else
                            <source id="webm_source" src="{{Storage::url($videoc->webm_Format_240)}}" type='video/webm'>
                            <source id="mp4_source" src="{{Storage::url($videoc->mp4_Format_240)}}" type='video/mp4'>

                        @endif
                    </video>
                    @endforeach
                </div>
                <select name="" id="qualityPick">
                    <option value="1080"{{$video->quality == 1080 ? 'selected' : ''}} {{$video->quality < 1080 ? 'hidden' : ''}}>1080p</option>
                    <option value="720"{{$video->quality == 720 ? 'selected' : ''}} {{$video->quality < 720 ? 'hidden' : ''}}>720p</option>
                    <option value="480"{{$video->quality == 480 ? 'selected' : ''}} {{$video->quality < 480 ? 'hidden' : ''}}>480p</option>
                    <option value="360"{{$video->quality == 360 ? 'selected' : ''}} {{$video->quality < 360 ? 'hidden' : ''}}>360p</option>
                    <option value="240"{{$video->quality == 240 ? 'selected' : ''}} >240p</option>
                </select>
                <div class="title mt-3">
                {{$video->title}}
                </div>
                @foreach ($video->views as $view)
                    <span class="float-right">عدد المشاهدات <span class="viewsNumber">{{$view->views_number}}</span></span>
                @endforeach
                    <div id="carouselId" class="carousel slide"  data-bs-ride="carousel">
    <ol class="carousel-indicators">
        @foreach ($videos as $i => $video)
        <li
            data-bs-target="#carouselId"
            data-bs-slide-to="{{ $i }}"
            class="{{ $i === 0 ? 'active' : '' }}"
            aria-label="{{ $video->name }}"
        ></li>
        @endforeach
    </ol>
    <div class="carousel-inner" role="listbox">
        @foreach ($videos as $i => $video)
        <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
            <a href="/videos/{{ $video->id }}" class="d-block text-decoration-none">
                <img
                    src="{{ Storage::url($video->image_path) }}"
                    class="w-100 d-block"
                    alt="{{ $video->title }}"
                />
                <div class="carousel-caption mb-3 d-none d-md-block bg-dark bg-opacity-75 rounded p-2">
                    <h5>{{ $video->title }}</h5>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    <button
        class="carousel-control-prev"
        type="button"
        data-bs-target="#carouselId"
        data-bs-slide="prev"
    >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">سابق</span>
    </button>
    <button
        class="carousel-control-next"
        type="button"
        data-bs-target="#carouselId"
        data-bs-slide="next"
    >
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">التالي</span>
    </button>
                    </div>
                    
                    
                <div class="interaction mt-5">
                    <a href="" class="like ml-3">
                        @if ($userLike)
                            @if ($userLike->like == 1)
                                <i class="far fa-thumbs-up fa-2x liked  "></i> <span id="likeNumber">{{$countlike}}</span>
                            @else
                            <i class="far fa-thumbs-up fa-2x  "></i> <span id="likeNumber">{{$countlike}}</span>

                            @endif
                        @else
                        <i class="far fa-thumbs-up fa-2x  "></i> <span id="likeNumber">{{$countlike}}</span>

                        @endif

                    </a>

                    <a href="" class="like mr-3">
                        @if ($userLike)
                            @if ($userLike->like == 0)
                                <i class="far fa-thumbs-down fa-2x liked  "></i> <span id="dislikeNumber">{{$countDislike}}</span>
                            @else
                            <i class="far fa-thumbs-down fa-2x  "></i> <span id="dislikeNumber">{{$countDislike}}</span>

                            @endif
                        @else
                        <i class="far fa-thumbs-down fa-2x  "></i> <span id="dislikeNumber">{{$countDislike}}</span>

                        @endif
                    </a>
                    
                    <div class="loginAlert mt-5">

                    </div>
                    <div class="mt-4 px-2">
                        <div class="comments">
                            <div class="mb-3">
                                التعليقات
                            </div>
                            <div >
                                <textarea name="comment" class="form-control" id="comment"></textarea>
                                <button type="submit" class="btn btn-info mt-3 savedcomment">تعليق</button>

                                <div class="CommentAlert mt-5">

                                </div>


                            </div>
                            <div class="commentBody">
                                
                            @foreach ($comments as $comment)
                                <div class="card mb-3 shadow-sm border-0">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-start">
                                            <!-- صورة المستخدم مع تأثير ظل -->
                                            <img src="{{ $comment->user->profile_photo_url }}" 
                                                 class="rounded-circle me-3 shadow-sm"
                                                 width="60"
                                                 height="60"
                                                 alt="صورة المستخدم"
                                                 style="border: 2px solid #fff;">

                                            <div class="flex-grow-1">
                                                <!-- رأس التعليق -->
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <div class="d-flex align-items-center">
                                                        <h6 class="mb-0 fw-bold text-primary">{{ $comment->user->name ?? 'مستخدم مجهول' }}</h6>
                                                        <span class="ms-2 small text-muted">
                                                            <i class="fas fa-clock me-1"></i>{{ $comment->created_at->diffForHumans() }}
                                                        </span>
                                                    </div>
                                                    @if (Auth::check() && (Auth::user()->id == $comment->user_id || auth()->user()->admin_level > 0))

                                                        <div class="dropdown">
                                                            <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                                                                <i class="fas fa-ellipsis-h fs-5"></i>
                                                            </button>
                                                            @if (!auth()->user()->block)
                                                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3" style="min-width: 200px;">
                                                                <li>
                                                                    <form action="{{ route('comment.destroy', $comment->id) }}" method="POST"
                                                                        onsubmit="return confirm('هل أنت متأكد؟')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="dropdown-item d-flex align-items-center py-2 px-3 text-danger bg-danger-hover">
                                                                            <i class="fas fa-trash-alt me-2"></i>
                                                                            <span class="fw-medium">حذف التعليق</span>
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                                <li>
                                                                    <form action="{{ route('comment.edit', $comment->id) }}" method="GET">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="dropdown-item d-flex align-items-center py-2 px-3 text-primary bg-primary-hover">
                                                                            <i class="fas fa-edit me-2"></i>
                                                                            <span class="fw-medium">تعديل التعليق</span>
                                                                        </button>
                                                                    </form>
                                                                </li>

                                                            </ul>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- محتوى التعليق -->
                                                <p class="mb-2 text-dark" style="line-height: 1.6;">{{ $comment->body }}</p>

                                                <!-- أزرار التفاعل -->
                                                <div class="d-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-link text-decoration-none text-secondary p-0">
                                                        <i class="fas fa-heart me-1"></i> 12
                                                    </button>
                                                    <button class="btn btn-sm btn-link text-decoration-none text-secondary p-0">
                                                        <i class="fas fa-reply me-1"></i> رد
                                                    </button>
                                                    <button class="btn btn-sm btn-link text-decoration-none text-secondary p-0">
                                                        <i class="fas fa-share-nodes me-1"></i> مشاركة
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    document.getElementById('qualityPick').onchange = function(){changeQuality()};
    function changeQuality(){
        var video = $('#videoPlayer')[0];
        var curTime = video.currentTime;
            var selected = $('#qualityPick').val();

            if(selected == '1080'){
                source = $('#webm_source').attr('src', '{{ Storage::url($videoc->webm_Format_1080) }}');
                source = $('#mp4_source').attr('src', '{{ Storage::url($videoc->mp4_Format_1080) }}');
            }
            else if(selected == '720'){
                source = $('#webm_source').attr('src', '{{ Storage::url($videoc->webm_Format_720) }}');
                source = $('#mp4_source').attr('src', '{{ Storage::url($videoc->mp4_Format_720) }}');
            }
            else if(selected == '480'){
                source = $('#webm_source').attr('src', '{{ Storage::url($videoc->webm_Format_480) }}');
                source = $('#mp4_source').attr('src', '{{ Storage::url($videoc->mp4_Format_480) }}');
            }
            else if(selected == '360'){
                source = $('#webm_source').attr('src', '{{ Storage::url($videoc->webm_Format_360) }}');
                source = $('#mp4_source').attr('src', '{{ Storage::url($videoc->mp4_Format_360) }}');
            }
            else if(selected == '240'){
                source = $('#webm_source').attr('src', '{{ Storage::url($videoc->webm_Format_240) }}');
                source = $('#mp4_source').attr('src', '{{ Storage::url($videoc->mp4_Format_240) }}');
            }
            video.load();
            video.play();
            video.currentTime = curTime;

        }
    </script>
    <script>
        $('.like').on('click' , function(event){
            var blocked = "{{ Auth::check() ? (Auth::user()->Block ? '1' : '0') : '2' }}";
            var token = '{{Session::token()}}';
            var urllike = '{{route("like")}}';
            var videoId = 0;
            var Authuser = '{{(Auth::user() ? 0 : 1)}}';
            if (Authuser == '1'){
                event.preventDefault();
                var html = "<div class='alert alert-danger'>\
                    <ul>\
                        <li class='loginAlert'> يجب تسجيل دخول للاعجاب بالفيديو</li>\
                    </ul>\
                    </div>";
                $('.loginAlert').html(html);
            }
            else if (blocked == '1') {
            event.preventDefault();
            var html='<div class="alert alert-danger">\
                        <ul>\
                            <li class="loginAlert">أنت ممنوع من الإعجاب</li>\
                        </ul>\
                    </div>';
            $(".loginAlert").html(html);
            }
            else{
                event.preventDefault();
                videoId = $('#videoId').val();
                var isLike = event.target.parentNode.previousElementSibling == null;
                
                $.ajax({
                    method:'POST',
                    url: urllike,
                    data:{
                        isLike : isLike,
                        videoId : videoId,
                        _token : token
                    },
                    success : function(data){
                        if($(event.target).hasClass('fa-thumbs-up')){
                            if($(event.target).hasClass('liked')){
                                $(event.target).removeClass('liked');
                            }
                            else{
                                $(event.target).addClass('liked');
                            }
                            console.log(data.countlike);
                            $('#likeNumber').html(data.countlike);
                            $('#dislikeNumber').html(data.countDislike);
                        }
                        if($(event.target).hasClass('fa-thumbs-down')){
                            if($(event.target).hasClass('liked')){
                                $(event.target).removeClass('liked');
                            }
                            else{
                                $(event.target).addClass('liked');
                            }

                            $('#likeNumber').html(data.countlike);
                            $('#dislikeNumber').html(data.countDislike);
                        }
                        if(isLike){
                            $('.fa-thumbs-down').removeClass('liked');
                        }else{
                            
                            $('.fa-thumbs-up').removeClass('liked');
                        }
                    }
                
                });
            }
        });
    </script>
    <script>
        $('#videoPlayer').on('ended' , function(e){
            var token = '{{Session::token()}}';
            var urlC = '{{route("view")}}';
            // لكي لا يعاد المستخدم الى بداية الصفحة نستخدم
            event.preventDefault();
            videoId = $('#videoId').val();
            
            $.ajax({
                method:'POST',
                url: urlC,
                data:{
                    videoId : videoId,
                    _token : token
                },
                success : function(data){
                    $(".viewsNumber").html(data.views);
                }
                
                
            });
        });
    </script>
    <script>
        $('.savedcomment').on('click' , function(e){
            var token = '{{Session::token()}}';
            var urlC = '{{route("comment")}}';
            var ViedoId = 0;
            var Authuser = '{{(Auth::user() ? 0 : 1)}}';
            var blocked = "{{ auth()->check() ? (auth()->user()->Block ? '1' : '0') : '2' }}";
            if (Authuser == '1'){
                event.preventDefault();
                var html = '<div class="alert alert-danger  ">\
                            <ul>\
                                <li>يجب عليك تسجيل الدخول لكتابة تعليق ولك اي شو هيدا</li>\
                            </ul>\
                            </div>';
                $(".CommentAlert").html(html);
            }
            else if (blocked == '1') {
            var html='<div class="alert alert-danger">\
                        <ul>\
                            <li class="commentAlert">أنت ممنوع من التعليق</li>\
                        </ul>\
                    </div>';
            $(".CommentAlert").html(html);
           
        }
            else if ($('#comment').val().length == 0){
                event.preventDefault();
                var html = '<div class="alert alert-danger  ">\
                            <ul>\
                                <li>الرجاء كتابة تعليق معلم</li>\
                            </ul>\
                            </div>';
                $(".CommentAlert").html(html);
            }
            else{
                $(".CommentAlert").html('');
                // لكي لا يعاد المستخدم الى بداية الصفحة نستخدم
                event.preventDefault();
                videoId = $('#videoId').val();
                body = $('#comment').val();
            }

            
            $.ajax({
                method:'POST',
                url: urlC,
                data:{
                    comment : body,
                    videoId : videoId,
                    _token : token
                },
                success: function(data) {
    $('#comment').val('');
    
    // استخدام template literals (بدلاً من concatenation بالـ \)
    var html = `
    <div class="card mb-3 shadow-sm border-0">
        <div class="card-body p-3">
            <div class="d-flex align-items-start">
                <img src="${data.user.profile_photo_url || '/default-avatar.png'}" 
                     class="rounded-circle me-3 shadow-sm" 
                     width="60"
                     height="60"
                     alt="صورة المستخدم"
                     style="border: 2px solid #fff;">

                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0 fw-bold text-primary">${data.user.name || 'مستخدم مجهول'}</h6>
                            <span class="ms-2 small text-muted">
                                <i class="fas fa-clock me-1"></i>الآن
                            </span>
                        </div>
                    </div>
                    
                    <p class="mb-2 p-2 border-primary-subtle bg-info" style="line-height: 1.6;">اعد تحميل الصفحة لاظهار خيار الحذف والتعديل</p>
                    <p class="mb-2 text-dark" style="line-height: 1.6;">${data.body}</p>
                </div>
            </div>
        </div>
    </div>`;
    
    $('.commentBody').prepend(html); // تأكد من أن الكلاس مطابق (حساس لحالة الأحرف)
}
                
                
            });
        });
    </script>
        
@endsection