@extends('Templates.admin')
@section('content')

<div class="container-fluid pt-4 px-4">

    {{-- CARD PROGRES --}}
    @php
        $progress = $data[0] ?? null;
    @endphp

    @if($progress)
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-clock fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total Duration</p>
                    <h6 class="mb-0">{{ $progress['total_duration'] }} menit</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-check fa-3x text-success"></i>
                <div class="ms-3">
                    <p class="mb-2">Benar</p>
                    <h6 class="mb-0">{{ $progress['correct_count'] }}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-times fa-3x text-danger"></i>
                <div class="ms-3">
                    <p class="mb-2">Salah</p>
                    <h6 class="mb-0">{{ $progress['wrong_count'] }}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-percentage fa-3x text-info"></i>
                <div class="ms-3">
                    <p class="mb-2">Persentase Benar</p>
                    <h6 class="mb-0">{{ $progress['correct_percent'] }}%</h6>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL DETAIL PROGRES --}}
    <div class="bg-light rounded p-4 mb-4">
        <h6 class="mb-4">Rincian Sesi Quiz</h6>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Sesi</th>
                        <th>Durasi (menit)</th>
                        <th>Soal Diskip</th>
                        <th>Ganti Jawaban</th>
                        <th>Hint Digunakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($progress['time_spend_sessions'] as $index => $session)
                        <tr>
                            <td>{{ $session['session'] }}</td>
                            <td>{{ $session['time'] }}</td>
                            <td>{{ $progress['skip_question_sessions'][$index]['skipQuestion'] ?? '-' }}</td>
                            <td>{{ $progress['change_answer_sessions'][$index]['changeAnswer'] ?? '-' }}</td>
                            <td>{{ $progress['hint_sessions'][$index]['hintShowed'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

{{-- KALENDER DAN JAM --}}
{{-- <div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-4">
            <!-- Calendar Card -->
            <div class="bg-light rounded p-4">
                <h6 class="mb-3">Calendar</h6>
                <div id="calender"></div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-4">
            <!-- Clock Card -->
            <div class="bg-light rounded p-4 text-center">
                <h6 class="mb-3">Current Time</h6>
                <div id="clock"></div>
            </div>
        </div>
    </div>
</div> --}}

@endsection

@push('scripts')


<script>
    // JavaScript to update the clock
    setInterval(function () {
        document.getElementById('clock').innerHTML = new Date().toLocaleTimeString();
    }, 1000);
</script>
@endpush
