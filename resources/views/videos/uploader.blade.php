@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="card mb-2 col-md-8">
                <div class="card-header text-center">
                    رفع فيديو
                </div>
                @if (!auth()->user()->block)
                    <div class="alert alert-danger">
                        لايمكنك انشاء فيديوهات فأت محظور لاتتواصل مع الادارة فنحن ليس لدينا ارقام
                    </div>
                @else
                <div class="card-body">
                    <form action="{{ route('videos.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">ادخل عنوان الفيديو</label>
                            <input name="title" class="form-control @error('title') is-invalid @enderror" id="title" required value="{{ old('title') }}" placeholder="ضفدع شارب كحوليات شاهد قبل الحذف">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        <div class="mb-3 file-area">
                            <label for="image" class="form-label">صورة الغلاف</label>
                            <input name='image' class="form-control @error('image') is-invalid @enderror" onchange="readCoverImage(this)" accept="image/*" id="image" value="{{ old('image') }}" type="file">
                            <div class="input-title">اسحب وأفلت الصورة هنا لتحميلها او انقر لتحميلها</div>
                            @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <div class="row">
                                <img src="" class="col-2" width="100px" height="100px" alt="" id="cover-image">
                                <span class="col-6 input-name" ></span>
                            </div>
                            
                        </div>
                        <div class="mb-3 file-area">
                            <label for="video" class="form-label">مقطع الفيديو </label>
                            <input class="form-control @error('video') is-invalid @enderror" name="video" onchange="readVideo(this)" accept="video/*" id="video" value="{{ old('video') }}" type="file">
                            <div class="input-title">اسحب وأفلت الفيديو هنا لتحميله او انقر لتحميله</div>
                            @error('video')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="row">
                                
                                <span class="video-name mb-4" ></span>
                            </div>
                            
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                {{-- {{dd(asset('resources/css/style.css'))}} --}}
                                <button type="submit" class="btn btn-secondary">رفع</button>
                            </div>
                        </div>
                    </form>
                </div>

                    @endif

            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    function readCoverImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#cover-image').attr('src', e.target.result);
            };
            
            reader.readAsDataURL(input.files[0]);
            $(".input-name").html(input.files[0].name);
        }
    }

    function readVideo(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.readAsDataURL(input.files[0]);
            $(".video-name").html('\
                <div class="alert alert-primary">\
                    تم اختيار مقطع الفيديو بنجاح '+input.files[0].name+'\
                </div>'
            );
        }
    }
</script>
@endsection

