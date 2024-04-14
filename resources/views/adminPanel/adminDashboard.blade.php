@extends('layouts.adminPanelLayout')

@section('title', 'Danchou')

@section('header')
@include('includes.admin.adminHeader')
@endsection

@section('sidebar')
@include('includes.admin.adminSidebar')
@endsection

@section('content')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div><!-- End Page Title -->
<section class="section dashboard">
    <div class="row">
        <!-- Left Side -->
        <div class="col-lg-8">
            <div class="row">

                <!-- Projects Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Projects <span>| Total</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-folder"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="projectCardNo"></h6>
                                    <span class="text-success small pt-1 fw-bold">Currently</span> <span class="text-muted small pt-2 ps-1">in record</span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Projects Card -->

                <!-- Feedbacks Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Feedbacks <span>| Total</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="feedbackCardNo"></h6>
                                    <span class="text-success small pt-1 fw-bold">Currently</span> <span class="text-muted small pt-2 ps-1">in record</span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Feedbacks Card -->

                <!-- Testimonials Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Testimonies <span>| Total</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="testimonialCardNo"></h6>
                                    <span class="text-success small pt-1 fw-bold">Currently</span> <span class="text-muted small pt-2 ps-1">in record</span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Feedbacks Card -->

                <!-- Services Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Services <span>| Total</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-pencil-square"></i>
                                </div>
                                <div class="ps-3">
                                    <h6 id="serviceCardNo"></h6>
                                    <span class="text-success small pt-1 fw-bold">Currently</span> <span class="text-muted small pt-2 ps-1">in record</span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Feedbacks Card -->

            </div>
        </div>
        <!-- Right Side -->
        <div class="col-lg-4">

            <!-- News & Updates Traffic -->
            <div class="card">

                <div class="card-body pb-0">
                    <h5 class="card-title">Recent Projects <span>| Recently Posted</span></h5>

                    <div class="news" id="newsContainer">


                    </div><!-- End sidebar recent posts-->

                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/projects')
            .then(response => response.json()).then(data => {

                const projectsDashCard = document.getElementById('projectCardNo');
                let projDashCardContent = `${data.length}`;

                projectsDashCard.innerHTML = projDashCardContent;
                console.log(data[0]['id']);

                var loopLimit = 0;
                for (let i = data.length - 1; i >= 0; i--) {
                    if (loopLimit == 5) {
                        break;
                    }

                    var imagePath = 'storage/' + data[i]['picture'];
                    var newsData = `
                        <div class="post-item clearfix">
                            <img src="${imagePath}" alt="Photo">
                            <h4><a href="${data[i]['url']}">${data[i]['projectName']}</a></h4>
                            <p>${data[i]['description']}</p>
                        </div>
                    `;

                    const newsContainer = document.getElementById('newsContainer');
                    newsContainer.insertAdjacentHTML('beforeend', newsData);

                    loopLimit += 1;
                }
            }).catch(error => {
                console.error('Error fetching data:', error);
            });


        fetch('/api/messages')
            .then(response => response.json()).then(data => {

                const feedDashCard = document.getElementById('feedbackCardNo');
                let feedDashCardContent = `${data.length}`;

                feedDashCard.innerHTML = feedDashCardContent;
                // console.log(data.length);
            }).catch(error => {
                console.error('Error fetching data:', error);
            });

        fetch(`/api/testimonials`)
            .then(response => response.json())
            .then(data => {
                const testimonialDashCard = document.getElementById('testimonialCardNo');
                let testimonyDashCardContent = `${data.length}`;

                testimonialDashCard.innerHTML = testimonyDashCardContent;
                // console.log(data.length);
            }).catch(error => {
                console.error('Error fetching', error);
            });
    });
</script>
@endsection