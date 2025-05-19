@extends('theme.default')
@section('title')
    القنوات
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
                    <th>نوع القناة</th>
                    <th>التعديل</th>
                    <th>الحذف</th>
                    <th>الحظر</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user )
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->isSuperAdmin() ? 'مدير عام' : ($user->isAdmin() ? 'مدير' : 'عضو عادي') }}</td>
                        <td>
                            @if ($user->isSuperAdmin())
                                <span> لايمكنك تعديل صلاحيات المدير</span>
                            @else
                            <form action="{{ route('channels.update' , $user->id) }}" class="form-inline ml-4" style="display: inline-block;" method="post">
                                @method('patch')
                                @csrf
                                <select  name="admin_level" id="" class="form-control form-control-sm">
                                    <option selected disabled value="">اختر نوعا</option>
                                    <option value="0">مستخدم</option>
                                    <option value="1">مدير</option>
                                    <option value="2">مدير عام</option>
                                </select>
                                <button type="submit" class="btn btn-info btn-sm" ><i class="fas fa-edit    "></i> تعديل </button>
                            </form>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('channels.delete' , $user->id) }}" class="form-inline ml-4" style="display: inline-block;" method="post">
                                @method('delete')
                                @csrf
                                @if (auth()->user() != $user && $user->admin_level != 2 )
                                
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('يسطا انت متأكد ؟')" ><i class="fa fa-trash" aria-hidden="true"></i> حذف </button>
                                @else
                                    <div class="btn btn-close btn-sm" >غير مسموح </div>
                                
                                @endif
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('channels.block' , $user->id) }}" class="form-inline ml-4" style="display: inline-block;" method="post">
                                @method('patch')
                                @csrf
                                
                                @if (auth()->user() != $user && $user->admin_level != 2 )
                                @if ($user->Block)
                                    <div class="btn btn-close btn-sm" >هو محظور </div>
                                @else
                                    <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm('يسطا انت متأكد ؟')" ><i class="fas fa-user-slash"></i> حظر </button>
                                @endif
                                @else
                                    <div class="btn btn-close btn-sm" >غير مسموح </div>
                                
                                @endif                         
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