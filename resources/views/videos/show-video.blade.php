@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="mx-auto col-10">
                <div class="vidcontainer">
                    <input type="hidden" value="{{$video->id}}" id="videoId">
                    @foreach($video->convert as $videoc)
                    <video id="videoPlayer" class="" style="{{$video->longi == '0' ? 'width: 85%; height: 90%;' : 'width:900px; height:510px'}}" controls>
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
                <div class="interaction text-center mt-5">
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
        
@endsection