@extends('layouts.adminPanelLayout')

@section('title', 'Testimonials')

@section('header')
@include('includes.admin.adminHeader')
@endsection

@section('sidebar')
@include('includes.admin.adminSidebar')
@endsection

@section('content')
<div class="pagetitle">
    <h1>Testimonials</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">Danchou</a></li>
            <li class="breadcrumb-item active">Testimonials</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Testimonial Lists</h5>

                    <div class="text-lg-end">
                        <button id="addTestimonialBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTestimonialModal">Add Testimonial</button>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    <!-- Table with stripped rows -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    <b>F</b>ullname
                                </th>
                                <th>Job</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody id="table_body">
                            <tr>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</section>

<!-- Form Modal -->
<div class="modal fade" id="addTestimonialModal" tabindex="-1" aria-labelledby="addTestimonialModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTestimonialModalLabel">Add New Testimonial</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="post" action="{{ route('testimonials.store') }}" id="addTestimonialForm" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="fullname" required>
                    </div>
                    <div class="mb-3">
                        <label for="job" class="form-label">Job</label>
                        <input type="text" class="form-control" id="job" name="job" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" rows="3" name="message" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="picture" class="form-label">Upload Picture</label>
                        <input type="file" class="form-control" id="picture" name="profilePic" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Testimonial</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Form Modal-->

<!-- View Modal-->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="viewTitle" class="modal-title">View</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="testimonialViewBody" class="modal-body" style="min-height: 1500px;">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End of View Modal-->

<!-- Edit Modal-->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="editTitle" class="modal-title">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="testimonialEditBody"class="modal-body" style="min-height: 1500px;">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Edit Modal-->
<!-- End #main -->
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch data from an API
        fetch('/api/testimonials')
            .then(response => response.json())
            .then(data => {
                // Reference to the tbody element
                const tbody = document.querySelector('tbody');
                let tableHTML = '';

                // Loop through the data and populate the table
                data.forEach(project => {
                    tableHTML += `<tr>
                    <td class="text-center">
                        <div>
                            <i class="bi bi-eye view-icon" data-bs-toggle="modal" data-bs-target="#viewModal" data-id="${project.id}" data-action="view"></i>
                            <i class="bi bi-pencil-square edit-icon" data-bs-toggle="modal" data-bs-target="#editModal" data-id="${project.id}" data-action="edit"></i>
                        </div>
                    </td>
                    <td>${project.fullname}</td>
                    <td>${project.job}</td>
                    <td>${project.email}</td>
                </tr>`;
                });

                // Set the innerHTML of tbody
                tbody.innerHTML = tableHTML;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    });


    // JavaScript to handle form submission
    document.getElementById("addTestimonialForm").addEventListener("submit", function(event) {

        event.preventDefault();

        var confirmed = window.confirm("Would you really like to add this testimony?");

        if (confirmed) {

            this.submit();

            var modal = new bootstrap.Modal(document.getElementById('addTestimonialModal'));
            modal.hide();
        }
    });


    const tableBody = document.getElementById('table_body');

    tableBody.addEventListener('click', function(event) {
        // Check if the clicked element is an icon
        if (event.target.classList.contains('view-icon') || event.target.classList.contains('edit-icon')) {
            // Retrieve the dataset of the clicked icon
            const testimonialId = event.target.dataset.id;
            const testimonialAction = event.target.dataset.action;

            // console.log(testimonialAction);
            // console.log(testimonialId);
            fetch(`/api/testimonials/${testimonialId}`)
                .then(response => response.json())
                .then(data => {

                    var testimonial = data[0];

                    // console.log(project);

                    if (testimonialAction === 'view') {

                        const imageUrl = 'storage/' + testimonial.profilePic;

                        // console.log(imageUrl);

                        const viewContents = `
                            <div class="justify-content-center">
                                <div class="col-md-6">
                                    <img id="testimonialImage" class="img-fluid mb-3" src="${imageUrl}" alt="Testimonial Image">
                                </div>
                            </div>
                            <div id="Name" class="mb-3">
                                <p><strong>Name:</strong></p>
                                <p>${testimonial.fullname}</p>
                            </div>
                            <div id="job" class="mb-3">
                                <p><strong>Occupation:</strong></p>
                                <p>${testimonial.job}</p>
                            </div>
                            <div id="email" class="mb-3">
                                <p><strong>Email Address:</strong></p>
                                <p>${testimonial.email}</p>
                            </div>
                            <div id="message" class="mb-3">
                                <p><strong>Message:</strong></p>
                                <p>${testimonial.message}</p>
                            </div>
                        `;

                        const viewContainer = document.getElementById('testimonialViewBody');
                        viewContainer.innerHTML = '';

                        viewContainer.innerHTML = viewContents;
                    }

                    if (testimonialAction === 'edit') {

                        // const testimonialId = project.id;

                        const testimonialUpdateUrl = `{{ route('testimonials.update', ':id') }}`.replace(':id', testimonialId);
                        const testimonialDeleteUrl = `{{ route('testimonials.delete', ':id') }}`.replace(':id', testimonialId);

                        // console.log(projectUpdateUrl);
                        const editContents = `
                            <div class="card">
                                <div class="card-body">
                                    <form action="${testimonialUpdateUrl}" method="post" class="row g-3" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="_method" value="PATCH">
                                    <div class="col-12">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" placeholder="${testimonial.fullname}" value="${testimonial.fullname}" name="fullname">
                                    </div>
                                    <div class="col-12">
                                        <label for="job" class="form-label">Occupation</label>
                                        <input type="text" class="form-control" id="job" placeholder="${testimonial.job}" value="${testimonial.job}" name="job">
                                    </div>
                                    <div class="col-12">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" placeholder="${testimonial.email}" value="${testimonial.email}" name="email">
                                    </div>
                                    <div class="col-12">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea class="form-control" id="message" rows="15" placeholder="${testimonial.message}" name="message">${testimonial.message}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label for="picture" class="form-label">Upload Picture</label>
                                        <input type="file" class="form-control" id="picture" name="profilePic" accept="image/*">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button class="btn btn-secondary bg-danger color-light"><a class="bg-danger" href="${testimonialDeleteUrl}">Delete</a></button>
                                    </div>
                                </form>
                            </div>
                        `;

                        const editContainer = document.getElementById('testimonialEditBody');
                        editContainer.innerHTML = '';

                        editContainer.innerHTML = editContents;

                        event.preventDefault();

                    }

                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }
    });
</script>
@endsection