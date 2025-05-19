@extends('theme.default')
@section('title')
    حظر القنوات
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
                    <th>تاريخ الانشاء</th>
                    <th>فك الحظر</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user )
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            {{ $user->created_at }}
                        </td>
                        <td>
                            <form action="{{ route('channels.block.edit' , $user->id) }}" class="form-inline ml-4" style="display: inline-block;" method="post">
                                @method('patch')
                                @csrf
                                
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('يسطا انت متأكد من االغاء الحظر')" > <i class="fas fa-user-unlock"></i> الغاء الحظر </button>
                                
                            </form>
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