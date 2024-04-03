@extends('layouts.adminPanelLayout')

@section('title', 'Backgrounds')

@section('header')
@include('includes.admin.adminHeader')
@endsection

@section('sidebar')
@include('includes.admin.adminSidebar')
@endsection

@section('content')
<div class="pagetitle">
    <h1>Backgrounds</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">Danchou</a></li>
            <li class="breadcrumb-item active">Backgrounds</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Backgrounds Lists</h5>

                    <div class="text-lg-end">
                        <button id="addBGBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBGModal">Add Background</button>
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
                                <th>Year</th>
                                <th>Place</th>
                                <th>Address</th>
                                <th>Type</th>
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
<div class="modal fade" id="addBGModal" tabindex="-1" aria-labelledby="addBGModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBGModalLabel">Add New Background</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="post" action="{{ route('backgrounds.store') }}" id="addBGForm">
                    @csrf
                    <div class="mb-3">
                        <label for="BGName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="BGName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="place" class="form-label">Place</label>
                        <input type="text" class="form-control" id="place" name="place" required>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Year</label>
                        <input type="text" class="form-control" id="year" name="year" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="typeOfBackground">Select a Background Type:</label>
                        <select class="form-control" id="typeOfBackground">
                            <option value="Education">Educational</option>
                            <option value="Personal">Personal Experience</option>
                        </select>
                    </div>
                    <input type="hidden" id="bgType" name="bgType" />
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" rows="3" name="description" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Background</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Form Modal-->

<!-- Edit Modal-->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="editTitle" class="modal-title">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="bgEditBody" class="modal-body" style="min-height: 1500px;">
                <div class="card">
                    <div class="card-body">
                        <form id="editForm" action="post" method="post" class="row g-3" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" value="PATCH">
                            <div class="col-12">
                                <label for="editName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="editName" placeholder="" value="" name="name">
                            </div>
                            <div class="col-12">
                                <label for="editPlace" class="form-label">Name of Place</label>
                                <input type="text" class="form-control" id="editPlace" placeholder="" value="" name="place">
                            </div>
                            <div class="col-12">
                                <label for="editYear" class="form-label">Year</label>
                                <input type="text" class="form-control" id="editYear" placeholder="" value="" name="year">
                            </div>
                            <div class="col-12">
                                <label for="editAddress" class="form-label">Address</label>
                                <input type="text" class="form-control" id="editAddress" placeholder="" value="" name="address">
                            </div>
                            <div class="form-group">
                                <label for="editTypeOfBackground">Select a Background Type:</label>
                                <select class="form-control" id="editTypeOfBackground">
                                    <option value="Education">Educational</option>
                                    <option value="Personal">Personal Experience</option>
                                </select>
                            </div>
                            <input type="hidden" id="editBgType" name="bgType" value="" />
                            <div class="col-12">
                                <label for="editDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="editDescription" rows="15" placeholder="" name="description"></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button class="btn btn-secondary bg-danger color-light"><a class="bg-danger" href="">Delete</a></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
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
        fetch('/api/backgrounds')
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
                            <i class="bi bi-pencil-square edit-icon" data-bs-toggle="modal" data-bs-target="#editModal" data-id="${project.id}"></i>
                        </div>
                    </td>
                    <td>${project.name}</td>
                    <td>${project.year}</td>
                    <td>${project.place}</td>
                    <td>${project.address}</td>
                    <td>${project.bgType}</td>
                </tr>`;
                });

                // Set the innerHTML of tbody
                tbody.innerHTML = tableHTML;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });

        // Dropdown
        var typeOfBackgroundSelect = document.getElementById("typeOfBackground");
        var bgTypeInput = document.getElementById("bgType");

        typeOfBackgroundSelect.addEventListener("change", function() {
            bgTypeInput.value = this.value;
        });

        var editTypeOfBackgroundSelect = document.getElementById("editTypeOfBackground");
        var editBgTypeInput = document.getElementById("editBgType");

        editTypeOfBackgroundSelect.addEventListener("change", function() {
            editBgTypeInput.value = this.value;
        });
    });


    // Form Submission
    document.getElementById("addBGForm").addEventListener("submit", function(event) {

        event.preventDefault();

        var confirmed = window.confirm("Would you really like to add this background?");

        if (confirmed) {

            this.submit();

            var modal = new bootstrap.Modal(document.getElementById('addBGModal'));
            modal.hide();
        }
    });

    // Icon Operations
    const tableBody = document.getElementById('table_body');

    tableBody.addEventListener('click', function(event) {

        if (event.target.classList.contains('edit-icon')) {

            const bgId = event.target.dataset.id;

            //console.log(bgId);

            fetch(`/api/backgrounds/${bgId}`)
                .then(response => response.json())
                .then(data => {

                    const background = data[0];
                    //console.log(background);

                    const backgroundUpdateUrl = `{{ route('backgrounds.update', ':id') }}`.replace(':id', bgId);
                    const backgroundDeleteUrl = `{{ route('backgrounds.delete', ':id') }}`.replace(':id', bgId);

                    let name = background.name;
                    let place = background.place;
                    let year = background.year;
                    let address = background.address;
                    let description = background.description;

                    let formAction = document.getElementById('editForm');
                    formAction.action = backgroundUpdateUrl;

                    let editName = document.getElementById('editName');
                    editName.placeholder = name;
                    editName.value = name;

                    let editPlace = document.getElementById('editPlace');
                    editPlace.placeholder = place;
                    editPlace.value = place;

                    let editYear = document.getElementById('editYear');
                    editYear.placeholder = year;
                    editYear.value = year;

                    let editAddress = document.getElementById('editAddress');
                    editAddress.placeholder = address;
                    editAddress.value = address;

                    let editDescription = document.getElementById('editDescription');
                    editDescription.placeholder = description;

                    console.log(formAction);
                    // const editContents = `
                    //         <div class="card">
                    //             <div class="card-body">
                    //                 <form action="${backgroundUpdateUrl}" method="post" class="row g-3" enctype="multipart/form-data">
                    //                     @csrf
                    //                     <input type="hidden" name="_method" value="PATCH">
                    //                 <div class="col-12">
                    //                     <label for="name" class="form-label">Name</label>
                    //                     <input type="text" class="form-control" id="name" placeholder="${background.name}" value="${background.name}" name="name">
                    //                 </div>
                    //                 <div class="col-12">
                    //                     <label for="place" class="form-label">Name of Place</label>
                    //                     <input type="text" class="form-control" id="place" placeholder="${background.place}" value="${background.place}" name="place">
                    //                 </div>
                    //                 <div class="col-12">
                    //                     <label for="year" class="form-label">Year</label>
                    //                     <input type="text" class="form-control" id="year" placeholder="${background.year}" value="${background.year}" name="year">
                    //                 </div>
                    //                 <div class="col-12">
                    //                     <label for="address" class="form-label">Address</label>
                    //                     <input type="text" class="form-control" id="address" placeholder="${background.address}" value="${background.address}" name="address">
                    //                 </div>
                    //                 <div class="form-group">
                    //                     <label for="typeOfBackground">Select a Background Type:</label>
                    //                     <select class="form-control" id="typeOfBackground">
                    //                         <option value="Education">Educational</option>
                    //                         <option value="Personal">Personal Experience</option>
                    //                     </select>
                    //                 </div>
                    //                 <div class="col-12">
                    //                     <label for="description" class="form-label">Message</label>
                    //                     <textarea class="form-control" id="description" rows="15" placeholder="${background.description}" name="message">${background.description}</textarea>
                    //                 </div>
                    //                 <div class="text-center">
                    //                     <button type="submit" class="btn btn-primary">Submit</button>
                    //                     <button class="btn btn-secondary bg-danger color-light"><a class="bg-danger" href="${backgroundDeleteUrl}">Delete</a></button>
                    //                 </div>
                    //             </form>
                    //         </div>
                    //     `;

                    // const editContainer = document.getElementById('bgEditBody');
                    // editContainer.innerHTML = '';

                    // editContainer.innerHTML = editContents;

                    // event.preventDefault();
                }).catch(error => {
                    console.error('Error fetching data:', error);
                });

        }
    });
</script>
@endsection