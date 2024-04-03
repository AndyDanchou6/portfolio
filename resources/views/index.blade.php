@extends('layouts.indexLayout')

@section('header')
@include('includes.header')
@endsection

@section('hero')
@include('includes.heroSect')
@endsection

@section('about')
@include('includes.aboutSect')
@endsection



@section('skills')
@include('includes.skillsSect')
@endsection

@section('resume')
@include('includes.resumeSect')
@endsection

@section('portfolio')
@include('includes.portfolioSect')
@endsection



@section('testimonials')
@include('includes.testimonialsSect')
@endsection

@section('contact')
@include('includes.contactSect')
@endsection

@section('content')
<div class="modal fade" id="modalDialogScrollable" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">PortFolio Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <div class="row">
                    <div>
                        <img src="" alt="">
                    </div>
                    <div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // About
        fetch(`/api/about`)
            .then(res => res.json())
            .then(data => {

                const myDetails = data[0];
                const aboutWrapper = document.getElementById('aboutContainer');
                const aboutContents = `
                <div class="col-lg-6">
                    <ul>
                        <li><i class="bi bi-chevron-right"></i> <strong>Name:</strong> <span>${myDetails.name}</span></li>
                        <li><i class="bi bi-chevron-right"></i> <strong>Birth Date:</strong> <span>${myDetails.birthdate}</span></li>
                        <li><i class="bi bi-chevron-right"></i> <strong>Age:</strong> <span>${myDetails.age}</span></li>
                        <li><i class="bi bi-chevron-right"></i> <strong>Civil Status:</strong> <span>${myDetails.civilStatus}</span></li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <ul>
                        <li><i class="bi bi-chevron-right"></i> <strong>Citizenship:</strong> <span>${myDetails.citizenship}</span></li>
                        <li><i class="bi bi-chevron-right"></i> <strong>Contact Number:</strong> <span>${myDetails.contactNo}</span></li>
                        <li><i class="bi bi-chevron-right"></i> <strong>Email:</strong> <span>${myDetails.email}</span></li>
                        <li><i class="bi bi-chevron-right"></i> <strong>Address:</strong> <span>${myDetails.address}</span></li>
                    </ul>
                </div>
            `;

                aboutWrapper.innerHTML = aboutContents;

                var aboutLocation = document.createTextNode(myDetails.address);
                var aboutEmail = document.createTextNode(myDetails.email);
                var aboutPhone = document.createTextNode(myDetails.contactNo);

                const contactLocation = document.getElementById('contactLocation');
                contactLocation.append(aboutLocation);
                const contactEmail = document.getElementById('contactEmail');
                contactEmail.append(aboutEmail);
                const contactPhone = document.getElementById('contactPhone');
                contactPhone.append(aboutPhone);
                //console.log(data);
            }).catch(error => {
                console.error("Error fetching Danchou details", error);
            });

        // Projects
        fetch(`/api/projects`)
            .then(response => response.json())
            .then(data => {

                const portfolioContainer = document.getElementById('portfolioContainer');
                var limit = 0;
                for (let i = data.length - 1; i >= 0; i--) {
                    if (limit >= 5) {
                        break;
                    }

                    var item = data[i];
                    var imageUrl = 'storage/' + item.picture;
                    const portfolioContents = `
                    <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                        <div class="portfolio-wrap">
                            <img src="${imageUrl}" class="img-fluid img-responsive" alt="Photo">
                            <div class="portfolio-links">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDialogScrollable" data-contentId="${item.id}">More Details</button>
                            </div>
                        </div>
                    </div>
                `;

                    portfolioContainer.insertAdjacentHTML('beforeend', portfolioContents);

                    limit++;
                    //console.log(item.id)
                }

                //console.log(item.picture);
            })
            .catch(error => {
                console.error('Error fetching projects data:', error);
            });
        
            // Contents Modal
        // const portfolioItem = document.getElementById('portfolioContainer')
        // portfolioItem.addEventListener('click', function() {
        //     if (event.target.matches('.portfolio-links button')) {
        //         const itemId = event.target.dataset.contentId;
        //         console.log(itemId);
        //     }
        // });

        console.log(portfolioItem);
        // Backgrounds
        fetch(`/api/backgrounds`)
            .then(response => response.json())
            .then(data => {

                const educationResume = document.getElementById('education');
                const personalResume = document.getElementById('personal');

                for (let i = 0; i < data.length; i++) {
                    let resume = data[i];
                    let resumeContent = `
                        <div class="resume-item">
                            <h4>${resume.name}</h4>
                            <h5>${resume.year}</h5>
                            <p><em>${resume.place}</em></p>
                            <p>${resume.description}</p>
                        </div>
                    `;
                    if (resume.bgType === 'Education') {
                        educationResume.insertAdjacentHTML('beforeend', resumeContent);
                    } else {
                        personalResume.insertAdjacentHTML('beforeend', resumeContent);
                    }

                }
                //console.log(data[1].bgType);
            }).catch(error => {
                console.error('Error fetching background data: ', error)
            });

        // Testimonials
        fetch(`/api/testimonials`)
            .then(response => response.json())
            .then(data => {

                const testimonyContainer = document.getElementById('swiper-item')
                var loopLimit = 0;
                let delay = 0;

                for (let i = data.length - 1; i >= 0; i--) {

                    if (loopLimit == 5) {

                        break;
                    }
                    if (data[i].role == 0) {

                        let testimony = data[i];
                        let imageUrl = 'storage/' + testimony.profilePic;
                        const testimonyContents = `
                            <div class="testimonial-item" data-aos="fade-up" data-aos-delay="${delay}">
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    ${testimony.message}
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                                <img src="${imageUrl}" class="testimonial-img" alt="">
                                <h3>${testimony.fullname}</h3>
                                <h4>${testimony.job}</h4>
                            </div>
                        `;

                        testimonyContainer.insertAdjacentHTML('beforeend', testimonyContents);
                    }
                    loopLimit += 1;
                    delay += 100;
                }
                //console.log(data);
            }).catch(error => {
                console.error('Error fetching testimials data', error);
            });

    });
</script>
@endsection