@extends('Templates.guest')

@section('content')
    <!-- Hero Section with Gradient Background -->
    <div class="hero-section position-relative overflow-hidden"
        style="
        min-height: 90vh;
        background: linear-gradient(135deg, #06BBCC 0%, #029DAA 100%);
        display: flex;
        align-items: center;
    ">
        <!-- Floating Elements -->
        <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden">
            <div class="floating-shape position-absolute"
                style="
                top: 10%;
                left: 10%;
                width: 60px;
                height: 60px;
                background: rgba(255,255,255,0.1);
                border-radius: 50%;
                animation: float 6s ease-in-out infinite;
                ">
            </div>
            <div class="floating-shape position-absolute"
                style="
                top: 20%;
                right: 15%;
                width: 40px;
                height: 40px;
                background: rgba(255,193,7,0.3);
                border-radius: 50%;
                animation: float 4s ease-in-out infinite reverse;
                ">
            </div>
            <div class="floating-shape position-absolute"
                style="
                bottom: 20%;
                left: 20%;
                width: 80px;
                height: 80px;
                background: rgba(255,255,255,0.05);
                border-radius: 15px;
                animation: float 5s ease-in-out infinite;
                ">
            </div>
        </div>

        <div class="container text-center text-white position-relative z-index-2">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4 animate-fade-up">
                        Masa Depan Pembelajaran
                        <span class="text-warning d-block">Dimulai dari Sini</span>
                    </h1>
                    <p class="fs-5 mb-5 opacity-90 animate-fade-up" style="animation-delay: 0.2s;">
                        Platform e-learning modern dengan teknologi AI yang membuat belajar menjadi lebih personal,
                        efektif, dan menyenangkan.
                    </p>
                    <div class="d-flex justify-content-center gap-3 animate-fade-up" style="animation-delay: 0.4s;">
                        <a href="{{ route(\App\Constants\Routes::routeSignin) }}"
                            class="btn btn-warning btn-lg px-5 py-3 rounded-pill fw-semibold text-dark shadow-lg hover-lift">
                            <i class="fa fa-rocket me-2"></i>Mulai Belajar
                        </a>
                        <a href="#features"
                            class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill fw-semibold hover-lift">
                            <i class="fa fa-play me-2"></i>Pelajari Lebih
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wave Bottom -->
        <div class="position-absolute bottom-0 start-0 w-100">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="height: 60px; width: 100%;">
                <path
                    d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                    opacity=".25" fill="white"></path>
                <path
                    d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z"
                    opacity=".5" fill="white"></path>
                <path
                    d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"
                    fill="white"></path>
            </svg>
        </div>
    </div>

    <!-- Features Section -->
    <section id="features" class="py-5" style="background: linear-gradient(to bottom, #ffffff, #f8f9fa);">
        <div class="container">
            <!-- Section Header -->
            <div class="text-center mb-5">
                <h2 class="display-6 fw-bold mb-3">Mengapa Memilih <span class="text-primary"
                        style="color: #06BBCC !important;">eLEARNING</span>?</h2>
                <p class="fs-5 text-muted">Fitur-fitur canggih yang membuat pengalaman belajar Anda tak terlupakan</p>
            </div>

            <!-- Features Grid -->
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card h-100 p-4 bg-white rounded-4 shadow-sm border-0 hover-lift-sm">
                        <div class="feature-icon d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                            style="width: 60px; height: 60px; background: linear-gradient(135deg, #06BBCC, #029DAA);">
                            <i class="fa fa-check-circle fa-lg text-white"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Mudah & Praktis</h5>
                        <p class="text-muted mb-0">Akses materi pembelajaran, tugas, dan kuis kapan saja dari perangkat apa
                            pun. Fleksibilitas penuh untuk pembelajaran modern.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card h-100 p-4 bg-white rounded-4 shadow-sm border-0 hover-lift-sm">
                        <div class="feature-icon d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                            style="width: 60px; height: 60px; background: linear-gradient(135deg, #ffecd2, #fcb69f);">
                            <i class="fa fa-robot fa-lg text-dark"></i>
                        </div>
                        <h5 class="fw-bold mb-3">AI-Powered Learning</h5>
                        <p class="text-muted mb-0">Teknologi kecerdasan buatan yang membantu proses pembelajaran, evaluasi
                            otomatis, dan rekomendasi materi yang personal.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card h-100 p-4 bg-white rounded-4 shadow-sm border-0 hover-lift-sm">
                        <div class="feature-icon d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                            style="width: 60px; height: 60px; background: linear-gradient(135deg, #a8edea, #fed6e3);">
                            <i class="fa fa-chart-line fa-lg text-dark"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Real-time Results</h5>
                        <p class="text-muted mb-0">Dapatkan hasil evaluasi dan feedback langsung setelah menyelesaikan tugas
                            atau ujian. Tidak perlu menunggu lama.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card h-100 p-4 bg-white rounded-4 shadow-sm border-0 hover-lift-sm">
                        <div class="feature-icon d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                            style="width: 60px; height: 60px; background: linear-gradient(135deg, #84fab0, #8fd3f4);">
                            <i class="fa fa-gamepad fa-lg text-dark"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Interactive Experience</h5>
                        <p class="text-muted mb-0">Interface yang user-friendly dengan elemen interaktif yang membuat
                            belajar terasa seperti bermain game.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card h-100 p-4 bg-white rounded-4 shadow-sm border-0 hover-lift-sm">
                        <div class="feature-icon d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                            style="width: 60px; height: 60px; background: linear-gradient(135deg, #fa709a, #fee140);">
                            <i class="fa fa-bullseye fa-lg text-dark"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Performance Analytics</h5>
                        <p class="text-muted mb-0">Analisis mendalam tentang progress belajar Anda dengan visualisasi data
                            yang mudah dipahami dan actionable insights.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card h-100 p-4 bg-white rounded-4 shadow-sm border-0 hover-lift-sm">
                        <div class="feature-icon d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                            style="width: 60px; height: 60px; background: linear-gradient(135deg, #a18cd1, #fbc2eb);">
                            <i class="fa fa-users fa-lg text-dark"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Collaborative Learning</h5>
                        <p class="text-muted mb-0">Belajar bersama teman-teman dengan fitur diskusi, grup belajar, dan
                            sharing knowledge yang terintegrasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5" style="background: linear-gradient(135deg, #06BBCC 0%, #029DAA 100%);">
        <div class="container text-center text-white">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="display-6 fw-bold mb-4">Siap Memulai Perjalanan Belajar Anda?</h2>
                    <p class="fs-5 mb-4 opacity-90">Bergabunglah dengan ribuan pelajar yang sudah merasakan pengalaman
                        belajar masa depan</p>
                    <a href="{{ route(\App\Constants\Routes::routeSignin) }}"
                        class="btn btn-warning btn-lg px-5 py-3 rounded-pill fw-semibold text-dark shadow-lg hover-lift">
                        <i class="fa fa-arrow-right me-2"></i>Mulai Sekarang - Gratis!
                    </a>
                </div>
            </div>
        </div>
    </section>

    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important;
        }

        .hover-lift-sm {
            transition: all 0.3s ease;
        }

        .hover-lift-sm:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .feature-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .feature-card:hover {
            border-color: rgba(6, 187, 204, 0.2);
        }

        .btn-outline-light:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .z-index-2 {
            z-index: 2;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .display-4 {
                font-size: 2.5rem;
            }

            .hero-section {
                min-height: 70vh;
            }

            .floating-shape {
                display: none;
            }
        }
    </style>
@endsection