@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="card mb-2 col-md-8">
                <div class="card-header text-center">
                    تعديل الفيديو
                </div>
                <div class="card-body">
                    <form action="{{ route('videos.update' , $video->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="title" class="form-label">ادخل عنوان الفيديو</label>
                            <input name="title" class="form-control @error('title') is-invalid @enderror" id="title" required value="{{ $video->title }}" placeholder="{{$video->title}}">
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
                        
                        <div class="form-group row">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-secondary">رفع</button>
                            </div>
                        </div>
                    </form>
                </div>
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

    
</script>
@endsection

