@extends('welcome')

@section('contents')
    
    <div class="container mt-5">
        <div class="row pt-5">
            <div class="col text-center">
                <h1>Tasks</h1>
            </div>
        </div>
    </div>

    <div class="container justify-content-end d-flex mb-3">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAdd">
        <i class="fa-solid fa-plus px-1"></i> Add Task 
        </button>
    </div>

    <div class="container my-4">
        <table class="table table-striped table-hover" id="TaskTable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Edit</th>
                </tr>
            </thead>

            <tbody id="taskTableBody">

            
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="ModalLabel">New Task</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="TaskName" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="taskName" name="taskName" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="taskDescription" class="form-label">Description:</label>
                        <input type="text" class="form-control" id="taskDescription" name="taskDescription" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="taskStatus" class="form-label">Status:</label>
                        <input type="text" class="form-control" id="taskStatus" name="taskStatus" placeholder="Año de publicacion del libro">
                    </div>
                    <div class="container justify-content-center text-align-center d-flex">
                        <button type="submit" class="btn btn-primary btnSave">Save</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
    
    <!-- <script src="{{ mix('js/tasks.js') }}"></script> -->
@endsection