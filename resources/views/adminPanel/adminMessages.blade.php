@extends('layouts.adminPanelLayout')

@section('title', 'Messages')

@section('header')
@include('includes.admin.adminHeader')
@endsection

@section('sidebar')
@include('includes.admin.adminSidebar')
@endsection

@section('content')
<div class="pagetitle">
    <h1>Messages</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ Route('dashboard') }}">Danchou</a></li>
            <li class="breadcrumb-item active">Messages</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Message Lists</h5>

                    <div class="text-lg-end d-flex justify-content-end">
                        <button id="markAllBtn" class="btn btn-primary">Mark All As Read</button>
                        <button id="deleteAllBtn" class="btn btn-danger">Delete All</button>
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
                                <th>Status</th>
                                <th>Email</th>
                                <th>Subject</th>
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

<!-- View Modal -->
<div class="modal fade" id="viewMessageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="viewTitle" class="modal-title">Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="messageModalBody" class="modal-body" style="min-height: 1000px;">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteMessageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="viewTitle" class="modal-title">Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="messageModalBody" class="modal-body" style="min-height: 500px;">
                <div class="d-flex justify-content-center">
                    <div class="col-4">
                        <p>Are you sure you want to delete this message?</p>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="col-3">
                        <button type="button" class="btn btn-secondary">Ok</button>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-danger">Cancel</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/messages')
            .then(response => response.json())
            .then(data => {

                //console.log(data);

                const messageContainer = document.getElementById('table_body');
                let messageContent = '';

                data.forEach(message => {
                    if (message.status == 1) {
                        var status = 'Read';
                    } else {
                        var status = "Unread";
                    }

                    messageContent += `<tr>
                    <td class="text-center">
                        <div>
                            <i class="bi bi-eye view-icon" data-bs-toggle="modal" data-bs-target="#viewMessageModal" data-id="${message.id}" data-action="view"></i>
                            <i class="bi bi-trash edit-icon delete-message" data-id="${message.id}"></i>
                        </div>
                    </td>
                    <td>${message.fullname}</td>
                    <td>${status}</td>
                    <td>${message.email}</td>
                    <td>${message.subject}</td>
                </tr>`;

                    messageContainer.innerHTML = messageContent;
                });

                const deleteIcons = document.querySelectorAll('.delete-message');
                deleteIcons.forEach(icon => {
                    icon.addEventListener('click', function() {
                        const messageId = icon.dataset.id;

                        const isConfirmed = window.confirm('Are you sure you want to delete this message?');
                        if (!isConfirmed) {
                            return;
                        }

                        fetch(`/api/deleteTestimonials/${messageId}`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {

                                console.log(data);
                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });
                    });
                });

                const tableBody = document.getElementById('table_body');

                tableBody.addEventListener('click', function(event) {
                    if (event.target.classList.contains('view-icon')) {

                        const messageId = event.target.dataset.id;

                        //console.log(messageId);

                        fetch(`/api/testimonials/${messageId}`)
                            .then(response => response.json())
                            .then(data => {

                                let fetchedMessage = data[0];
                                if (fetchedMessage.status == 1) {
                                    var stat = 'Read';
                                } else {
                                    var stat = 'Unread';
                                }
                                //console.log(data);
                                const messageModal = document.getElementById('messageModalBody');
                                const content = `
                            <div id="name" class="mb-3">
                                <p><strong>Sender Name:</strong></p>
                                <p>${fetchedMessage.fullname}</p>
                            </div>
                            <div id="email" class="mb-3">
                                <p><strong>Email:</strong></p>
                                <p>${fetchedMessage.email}</p>
                            </div>
                            <div id="status" class="mb-3">
                                <p><strong>Status:</strong></p>
                                <p>${stat}</p>
                            </div>
                            <div id="message" class="mb-3">
                                <p><strong>Message:</strong></p>
                                <textarea class="col-12" rows="20">${fetchedMessage.message}</textarea>
                            </div>
                            `;

                                messageModal.innerHTML = content;
                            }).catch(error => {
                                console.error('Error fetching data', error);
                            });
                    }
                });

            }).catch(error => {
                console.error('Error fetching data', error);
            });
    });

    const deleteBtn = document.getElementById('deleteAllBtn');
    deleteBtn.addEventListener('click', function() {

        const isConfirmed = window.confirm('Are you sure you want to delete all message?');
        if (!isConfirmed) {
            return;
        }

        fetch(`/api/messages/deleteAll`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
            }).catch(error => {
                console.error('Error fetching data', error);
            });
    });

    const markAllBtn = document.getElementById('markAllBtn')
    markAllBtn.addEventListener('click', function() {
        const isConfirmed = window.confirm('Are you sure you want to mark all message as read?');
        if (!isConfirmed) {
            return;
        }
        fetch(`/api/messages/updateAll`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
            }).catch(error => {
                console.error('Error fetching data', error);
            });

    });
</script>
@endsection