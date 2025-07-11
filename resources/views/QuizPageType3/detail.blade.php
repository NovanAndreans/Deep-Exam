@extends('Templates.admin')

@section('title', 'Detail Quiz Type 3')

@push('css')

@endpush

@section('content-header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Detail Quiz</h1>
    <div aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route(\App\Constants\Routes::routeAdminDashboard)}}">Dashboard</a>
            </li>
            <li class="breadcrumb-item"><a href="{{route(\App\Constants\Routes::routeQuiz)}}">Quiz</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Quiz</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Quiz Type 3 {{$data->title}}</h3>
        <a href="{{ route(\App\Constants\Routes::routeQuizType3Progress, encrypt($data->id))}}"
            class="btn btn-success">Attempt
            Quiz</a>
    </div>
    <div class="card-body">
        <table class="table table-borderless">
            <tbody>
                <tr>
                    <td><strong>Deskripsi</strong></td>
                    <td>:</td>
                    <td>{{$data->desc}}</td>
                </tr>
                <tr>
                    <td><strong>Jumlah Soal</strong></td>
                    <td>:</td>
                    <td>{{$data->quizSetting->jumlah_soal}}</td>
                </tr>
                <tr>
                    <td><strong>Batas Waktu</strong></td>
                    <td>:</td>
                    <td>{{$data->quizSetting->batas_waktu}} menit</td>
                </tr>
                <tr>
                    <td><strong>Status</strong></td>
                    <td>:</td>
                    <td>Aktif</td>
                </tr>
                <tr>
                    <td><strong>Nama Guru</strong></td>
                    <td>:</td>
                    <td>{{$data->creator->name}}</td>
                </tr>
                <tr>
                    <td><strong>Attempt Quiz</strong></td>
                    <td>:</td>
                    <td>{{$data->quizSetting->attempt_quiz}} kali</td>
                </tr>
                <tr>
                    <td><strong>CPMK</strong></td>
                    <td>:</td>
                    <td>{{$data->cpmk}}</td>
                </tr>
                <tr>
                    <td><strong>Sub-CPMK</strong></td>
                    <td>:</td>
                    <td>
                        @if (!empty($data->subCpmk))
                        <table class="mb-0">
                            <tr>
                                <td>
                                    <table class="mb-0">
                                        @foreach ($data->subCpmk as $item)
                                        <tr>
                                            <td style="padding: 0.2rem 0;">
                                                -> {{ $item->subcpmk }}
                                            </td>
                                            <td style="padding: 0.2rem 0 0.2rem 0.75rem;">
                                                <span class="badge bg-success">{{ $item->limit_bloom }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                        </table>

                        @else
                        -
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('script')

@endpush