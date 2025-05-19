@extends('theme.default')
@section('title')
    لوحة التحكم
@endsection
@section('content')

<div class="row justify-content-center">
    <!-- بطاقة عدد القنوات -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            عدد القنوات</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $channelsCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tv fa-2x text-success-300" style="color: #2ecc71;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- بطاقة عدد الفيديوهات -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            عدد الفيديوهات</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$videosCount}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-video fa-2x text-info-300" style="color: #3498db;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <canvas id="myChart" class="mt-4"></canvas>
</div>

@endsection
@section('script')
@vite(['resources/js/app.js'])
<script src="https://cdn.jsdelivr.net/npm/chart.js "></script>
<script>
  var names = @php echo $names; @endphp ;
  var total = @php echo $total; @endphp ;
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