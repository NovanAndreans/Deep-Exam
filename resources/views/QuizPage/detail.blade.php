@extends('Templates.admin')

@section('title', 'Detail Quiz')

@push('css')

@endpush

@section('content-header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Detail Quiz</h1>
    <div aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Quiz</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Quiz</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Quiz Matematika Dasar</h3>
        <a href="{{ route(\App\Constants\Routes::routeQuizProgress, ['id' => 1]) }}" class="btn btn-success">Attempt Quiz</a>
    </div>
    <div class="card-body">
        <table class="table table-borderless">
            <tbody>
                <tr>
                    <td><strong>Deskripsi</strong></td>
                    <td>:</td>
                    <td>Quiz ini menguji pemahaman dasar matematika.</td>
                </tr>
                <tr>
                    <td><strong>Jumlah Soal</strong></td>
                    <td>:</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td><strong>Batas Waktu</strong></td>
                    <td>:</td>
                    <td>30 menit</td>
                </tr>
                <tr>
                    <td><strong>Status</strong></td>
                    <td>:</td>
                    <td>Aktif</td>
                </tr>
                <tr>
                    <td><strong>Nama Guru</strong></td>
                    <td>:</td>
                    <td>Budi Santoso</td>
                </tr>
                <tr>
                    <td><strong>Attempt Quiz</strong></td>
                    <td>:</td>
                    <td>3 kali</td>
                </tr>
                <tr>
                    <td><strong>CPMK</strong></td>
                    <td>:</td>
                    <td>Memahami konsep dasar operasi matematika</td>
                </tr>
                <tr>
                    <td><strong>Sub-CPMK</strong></td>
                    <td>:</td>
                    <td>
                        <ul class="mb-0">
                            <li>Mampu menjumlahkan bilangan bulat dengan benar</li>
                            <li>Mampu mengurangkan bilangan bulat dengan akurat</li>
                            <li>Mampu mengalikan bilangan bulat dengan tepat</li>
                            <li>Mampu membagi bilangan bulat dengan hasil yang benar</li>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('script')

@endpush
