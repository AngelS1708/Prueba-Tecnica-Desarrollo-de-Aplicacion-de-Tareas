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
        <table class="table table-striped table-hover table-responsive" id="TaskTable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Show</th>
                </tr>
            </thead>

            <tbody id="taskTableBody">

            
            </tbody>
        </table>
    </div>


    <!-- Modal Add -->
    <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ModalLabel">New Task</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="taskForm" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="TaskName" class="form-label">Name*:</label>
                            <input type="text" class="form-control" id="taskName" name="taskName" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="taskDescription" class="form-label">Description*:</label>
                            <input type="text" class="form-control" id="taskDescription" name="taskDescription" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="taskStatus" class="form-label">Status*:</label>
                            <select class="form-select" aria-label="Default select example" id="taskStatus" name="taskStatus">
                                <option selected disabled>Open this select menu</option>
                                <option value="En Progreso">En progreso</option>
                                <option value="Pendiente">Pendiente</option>
                                <option value="Completado">Completado</option>
                            </select>
                        </div>
                        <div class="container justify-content-center text-align-center d-flex">
                            <button type="submit" class="btn btn-primary" id="btnSave" data-bs-dismiss="modal" aria-label="Close">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Show Task -->
    <div class="modal fade" id="modalShow" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="showTaskTitle"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="row">
                        <div class="col">
                            <h5>Id:</h5>
                            <p id="showTaskId"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h5>Description:</h5>
                            <p id="showTaskDescription"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h5>Status:</h5>
                            <p id="showTaskStatus"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h5>Created at:</h5>
                            <p id="showTaskCreated"></p>
                        </div>
                        <div class="col">
                            <h5>Updated at:</h5>
                            <p id="showTaskUpdated"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Task -->

    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="taskTitleName">Edit Task</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="taskForm" method="PUT">
                        @csrf
                        <input type="hidden" id="editTaskId" name="taskId">
                        <div class="mb-3">
                            <label for="TaskName" class="form-label">Name*:</label>
                            <input type="text" class="form-control" id="taskNameEdit" name="taskNameEdit" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="taskDescription" class="form-label">Description*:</label>
                            <input type="text" class="form-control" id="taskDescriptionEdit" name="taskDescriptionEdit" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="taskStatus" class="form-label">Status*:</label>
                            <select class="form-select" aria-label="Default select example" id="taskStatusEdit" name="taskStatusEdit">
                                <option selected disabled>Open this select menu</option>
                                <option value="En Progreso">En progreso</option>
                                <option value="Pendiente">Pendiente</option>
                                <option value="Completado">Completado</option>
                            </select>
                        </div>
                        <div class="container justify-content-center text-align-center d-flex">
                            <button type="submit" class="btn btn-primary" id="btnSaveEdit" data-bs-dismiss="modal" aria-label="Close">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection