@extends('Templates.admin')

@section('title', 'Pilih Quiz')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
<style>
    .container {
        max-width: 100%;
        padding: 0 15px;
        margin: auto;
    }

    .swiper-container {
        width: 100%;
        overflow: hidden;
    }

    .swiper-slide {
        display: flex;
        justify-content: center;
    }

    .quiz-card {
        flex: 1 1 auto;
        width: 100%;
        max-width: 250px;
        text-align: center;
        padding: 16px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 200px;
        overflow-wrap: break-word;
    }

    .quiz-card p {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        /* Maksimal 3 baris */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        max-height: 4.5em;
        /* Sesuaikan tinggi */
    }

    .quiz-card a {
        margin-top: auto;
    }

    .swiper-pagination {
        position: relative;
        margin-top: 10px;
        z-index: 10;
    }
</style>
@endpush

@section('content-header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Pilih Quiz Type 3</h1>
    <div aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route(\App\Constants\Routes::routeAdminDashboard) }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Pilih Quiz</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="container mt-4">
    <!-- Quiz Versi Publik -->
    @if (count($publicQuizzes))
    <h2 class="text-lg font-semibold mb-2">Quiz Versi Publik</h2>
    <div class="swiper-container public-quiz-slider">
        <div class="swiper-wrapper">
            @php
            $colors = ['#FFCDD2', '#C8E6C9', '#BBDEFB', '#FFF9C4'];
            @endphp
            @foreach($publicQuizzes as $quiz)
            <div class="swiper-slide">
                <div class="quiz-card" style="background-color: {{ $colors[$loop->index % count($colors)] }};">
                    <h3 class="text-md font-bold">{{ $quiz->title }}</h3>
                    <p class="text-sm text-gray-600" title="{{ $quiz->desc }}">{{ $quiz->desc }}</p>
                    <a href="{{ route('quiz3.show', encrypt($quiz->id)) }}" class="btn btn-primary">Mulai</a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
    @endif

    <!-- Quiz dari Guru Anda -->
    @if (count($teacherQuizzes))
    <h2 class="text-lg font-semibold mt-6 mb-2">Quiz dari Guru Anda</h2>
    <div class="swiper-container teacher-quiz-slider">
        <div class="swiper-wrapper">
            @foreach($teacherQuizzes as $quiz)
            <div class="swiper-slide">
                <div class="quiz-card" style="background-color: {{ $colors[$loop->index % count($colors)] }};">
                    <h3 class="text-md font-bold">{{ $quiz->title }}</h3>
                    <p class="text-sm text-gray-600" title="{{ $quiz->description }}">{{ $quiz->description }}</p>
                    <a href="{{ route('quiz3.show', $quiz->id) }}" class="btn btn-primary">Mulai</a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
    @endif
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    new Swiper(".public-quiz-slider", {
      slidesPerView: "auto",
      spaceBetween: 10,
      pagination: { el: ".swiper-pagination", clickable: true },
      breakpoints: {
        320: { slidesPerView: 1 },
        576: { slidesPerView: 2 },
        768: { slidesPerView: 3 },
        1024: { slidesPerView: 4 },
      }
    });

    new Swiper(".teacher-quiz-slider", {
      slidesPerView: "auto",
      spaceBetween: 10,
      pagination: { el: ".swiper-pagination", clickable: true },
      breakpoints: {
        320: { slidesPerView: 1 },
        576: { slidesPerView: 2 },
        768: { slidesPerView: 3 },
        1024: { slidesPerView: 4 },
      }
    });
  });
</script>
@endpush