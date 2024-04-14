@extends('layouts.adminPanelLayout')

@section('title', 'Projects')

@section('header')
@include('includes.admin.adminHeader')
@endsection

@section('sidebar')
@include('includes.admin.adminSidebar')
@endsection

@section('content')

<div class="pagetitle">
    <h1>Projects</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">Danchou</a></li>
            <li class="breadcrumb-item active">Projects</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Project Lists</h5>

                    <div class="text-lg-end">
                        <button id="addProjectBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProjectModal">Add Project</button>
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
                                    <b>N</b>ame
                                </th>
                                <th>Category</th>
                                <th>Client</th>
                                <th>Url</th>
                                <th>Completion</th>
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
<div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProjectModalLabel">Add New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="post" action="{{ route('projects.store') }}" id="addProjectForm" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="projectName" class="form-label">Project Name</label>
                        <input type="text" class="form-control" id="projectName" name="projectName" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Project Category</label>
                        <input type="text" class="form-control" id="category" name="category" required>
                    </div>
                    <div class="mb-3">
                        <label for="client" class="form-label">Client</label>
                        <input type="text" class="form-control" id="client" name="client" required>
                    </div>
                    <div class="mb-3">
                        <label for="startDate" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="startDate" name="startDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" rows="3" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="url" class="form-label">URL</label>
                        <input type="text" class="form-control" id="url" name="url">
                    </div>
                    <div class="mb-3">
                        <label for="completion" class="form-label">Completion (%)</label>
                        <input type="number" class="form-control" id="completion" min="0" max="100" name="completion" required>
                    </div>
                    <div class="mb-3">
                        <label for="completionDate" class="form-label">Completion Date</label>
                        <input type="date" class="form-control" id="completionDate" name="completionDate">
                    </div>
                    <div class="mb-3">
                        <label for="picture" class="form-label">Upload Picture</label>
                        <input type="file" class="form-control" id="picture" name="picture" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Project</button>
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
            <div id="projectViewBody" class="modal-body" style="min-height: 1500px;">

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
            <div id="projectEditBody" class="modal-body" style="min-height: 1500px;">

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
        fetch('/api/projects')
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
                            <i class="bi bi-eye view-icon" data-bs-toggle="modal" data-bs-target="#viewModal" data-project-id="${project.id}" data-action="view"></i>
                            <i class="bi bi-pencil-square edit-icon" data-bs-toggle="modal" data-bs-target="#editModal" data-project-id="${project.id}" data-action="edit"></i>
                        </div>
                    </td>
                    <td>${project.projectName}</td>
                    <td>${project.category}</td>
                    <td>${project.client}</td>
                    <td>${project.url}</td>
                    <td>${project.completion}%</td>
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
    document.getElementById("addProjectForm").addEventListener("submit", function(event) {

        event.preventDefault();

        var confirmed = window.confirm("Would you really like to add this project?");

        if (confirmed) {

            this.submit();

            var modal = new bootstrap.Modal(document.getElementById('addProjectModal'));
            modal.hide();
        }
    });


    const tableBody = document.getElementById('table_body');

    tableBody.addEventListener('click', function(event) {

        if (event.target.classList.contains('view-icon') || event.target.classList.contains('edit-icon')) {

            const projectId = event.target.dataset.projectId;
            const projectAction = event.target.dataset.action;

            fetch(`/api/projects/${projectId}`)
                .then(response => response.json())
                .then(data => {

                    var project = data[0];

                    //console.log(project);

                    if (projectAction === 'view') {

                        const imageUrl = 'storage/' + project.picture;

                        // console.log(imageUrl);

                        const viewContents = `
                            <div class="justify-content-center">
                                <div class="col-md-6">
                                    <img id="projectImage" class="img-fluid mb-3" src="${imageUrl}" alt="Project Image">
                                </div>
                            </div>
                            <div id="projectTitle" class="mb-3">
                                <p><strong>Project Title:</strong></p>
                                <p>${project.projectName}</p>
                            </div>
                            <div id="projectDescription" class="mb-3">
                                <p><strong>Category:</strong></p>
                                <p>${project.category}</p>
                            </div>
                            <div id="projectDetails" class="mb-3">
                                <p><strong>Client:</strong></p>
                                <p>${project.client}</p>
                            </div>
                            <div id="projectTitle" class="mb-3">
                                <p><strong>Url:</strong></p>
                                <p>${project.url}</p>
                            </div>
                            <div id="projectDescription" class="mb-3">
                                <p><strong>Start Date:</strong></p>
                                <p>${project.startDate}</p>
                            </div>
                            <div id="projectDetails" class="mb-3">
                                <p><strong>Completion:</strong></p>
                                <p>${project.completion} %</p>
                            </div>
                            <div id="projectDescription" class="mb-3">
                                <p><strong>Completion Date:</strong></p>
                                <p>${project.completionDate}</p>
                            </div>
                            <div id="projectDetails" class="mb-3">
                                <p><strong>Details:</strong></p>
                                <p>${project.description}</p>
                            </div>
                        `;

                        const viewContainer = document.getElementById('projectViewBody');
                        viewContainer.innerHTML = '';

                        viewContainer.innerHTML = viewContents;
                    }

                    if (projectAction === 'edit') {

                        const projectId = project.id;

                        const projectUpdateUrl = `{{ route('projects.update', ':projectId') }}`.replace(':projectId', projectId);
                        const projectDeleteUrl = `{{ route('projects.delete', ':projectId') }}`.replace(':projectId', projectId);

                        const editContents = `
                        <div class="card">
                            <div class="card-body">
                                <form action="${projectUpdateUrl}" method="post" class="row g-3" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="_method" value="PATCH">
                                    <div class="col-12">
                                        <label for="title" class="form-label">Project Title</label>
                                        <input type="text" class="form-control" id="title" placeholder="${project.projectName}" value="${project.projectName}" name="projectName">
                                    </div>
                                    <div class="col-12">
                                        <label for="category" class="form-label">Category</label>
                                        <input type="text" class="form-control" id="category" placeholder="${project.category}" value="${project.category}" name="category">
                                    </div>
                                    <div class="col-12">
                                        <label for="client" class="form-label">Client</label>
                                        <input type="text" class="form-control" id="client" placeholder="${project.client}" value="${project.client}" name="client">
                                    </div>
                                    <div class="col-12">
                                        <label for="url" class="form-label">Url</label>
                                        <input type="text" class="form-control" id="url" placeholder="${project.url}" value="${project.url}" name="url">
                                    </div>
                                    <div class="col-12">
                                        <label for="startDate" class="form-label">Start Date</label>
                                        <input type="date" class="form-control" id="startDate" placeholder="${project.startDate}" value="${project.startDate}" name="startDate">
                                    </div>
                                    <div class="col-12">
                                        <label for="completion" class="form-label">Completion</label>
                                        <input type="number" class="form-control" min="0" max="100" id="completion" placeholder="${project.completion}" value="${project.completion}" name="completion">
                                    </div>
                                    <div class="col-12">
                                        <label for="completionDate" class="form-label">Completion Date</label>
                                        <input type="date" class="form-control" id="completionDate" placeholder="${project.completionDate}" value="${project.completionDate}" name="completionDate">
                                    </div>
                                    <div class="col-12">
                                        <label for="details" class="form-label">Details</label>
                                        <textarea class="form-control" id="details" rows="15" placeholder="${project.description}" name="description">${project.description}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label for="picture" class="form-label">Upload Picture</label>
                                        <input type="file" class="form-control" id="picture" name="picture" accept="image/*">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="submit" class="btn btn-danger"><a href="${projectDeleteUrl}">Delete</a></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        `;

                        const editContainer = document.getElementById('projectEditBody');
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