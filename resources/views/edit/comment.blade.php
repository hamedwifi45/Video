@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="card mb-2 col-md-8">
                <div class="card-header text-center">
                    رفع فيديو
                </div>
                <div class="card-body">
                    <form action="{{ route('comment.update' , $comment->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="mb-3">
                            <label for="body" class="form-label">نص التعليق</label>
                            <textarea name="body" class="form-control @error('body') is-invalid @enderror" id="body" required placeholder="ضفدع شارب كحوليات شاهد قبل الحذف">{{ $comment->body}}</textarea>
                            @error('body')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-4">
                                {{-- {{dd(asset('resources/css/style.css'))}} --}}
                                <button type="submit" class="btn btn-secondary">رفع</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

