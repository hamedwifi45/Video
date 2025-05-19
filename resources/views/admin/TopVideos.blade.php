@extends('theme.default')
@section('title')
    اكثر الفيديوهات مشاهدة
@endsection

@section('content')
<hr>
<div class="row">
    <div class="col-md-12">
        <table id="videos-table" class="table table-striped text-right " >
            <thead>
                <tr>
                    <th>عنوان الفيديو</th>
                    <th>اسم القناة</th>
                    <th>تاريخ الانشاء</th>
                    <th>مجموع المشاهدات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Views as $user )
                    <tr>
                        <td>
                            <a href="{{ route('videos.show' , $user->video->id) }}">
                                {{ $user->video->title }}
                            </a>
                        </td>
                        <td>{{ $user->user->name }}</td>
                        <td>{{ $user->views_number }}</td>
                        
                        <td>
                            {{ $user->video->created_at }}
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div>
    <canvas id="myChart" class="mt-4"></canvas>
</div>
@endsection
@section('script')


<script src="https://cdn.jsdelivr.net/npm/chart.js "></script>
<script>
  // ملاحظة في المخطط السابق وصلت العاومة وهي محولة
   var names = <?php echo json_encode($vN); ?>;
   var total = <?php echo json_encode($vV); ?>;
  document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('myChart');
    
    if (typeof Chart !== 'undefined') {
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: names,
          datasets: [{
            label: '# of Votes',
            data: total ,
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    } else {
      console.error('Chart.js is not loaded');
    }
  });
</script>
@endsection