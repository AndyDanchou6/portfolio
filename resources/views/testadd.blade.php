@extends('layouts.adminPanelLayout')

@section('title', 'Add Project')

@section('header')
@include('includes.admin.adminHeader')
@endsection

@section('sidebar')
@include('includes.admin.adminSidebar')
@endsection

@section('content')
<div>
    <form method="post" action="{{ route('projects.store') }}" id="addProjectForm" enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
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
@endsection