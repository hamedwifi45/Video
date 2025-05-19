@extends('theme.default')
@section('title')
    جميع القنوات
@endsection
@section('head')
        <link href="{{asset('theme/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

@endsection
@section('content')
<hr>
<div class="row">
    <div class="col-md-12">
        <table id="videos-table" class="table table-striped text-right " >
            <thead>
                <tr>
                    <th>اسم القناة</th>
                    <th>البريد الكتروني</th>
                    <th>عدد مقاطع الفيديو</th>
                    <th>مجموع المشاهدات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user )
                    <tr>
                        <td>
                            <a href="{{ route('main.channels.videos' , $user->id) }}">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->videos->count() }}</td>
                        
                        <td>
                            {{ $user->views->sum('views_number') }}
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
    <script src="{{  asset('theme/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{  asset('theme/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#videos-table').DataTable({
                "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
            }
            });
        });
    </script>
    @endsection