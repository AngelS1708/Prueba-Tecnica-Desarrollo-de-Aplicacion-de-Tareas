document.addEventListener('DOMContentLoaded', () => {
    // Carga y muestra todas las tareas al iniciar
    loadTasks();

    // Funcion para cargar las tareas desde la API y mostrarlas en la tabla
    function loadTasks() {
        fetch('/api/tasks') // Llama a la API para obtener las tareas
            .then(response => response.json()) // Convierte la respuesta a JSON
            .then(data => {
                const tasksTableBody = document.getElementById('taskTableBody');
                tasksTableBody.innerHTML = ''; // Limpia la tabla antes de llenarla

                // Recorre cada tarea y la agrega a la tabla
                data.tasks.forEach(task => {
                    tasksTableBody.innerHTML += `
                        <tr id="taskRow-${task.id}">
                            <td>${task.id}</td>
                            <td>${task.name}</td>
                            <td>${task.status}</td>
                            <td>
                                <button class="btn btn-primary m-2" onclick="openEditTask(${task.id})">
                                    <i class="fa-solid fa-pen-to-square fa-xl"></i>
                                </button>
                                <button class="btn btn-danger m-2" onclick="deleteTask(${task.id})">
                                    <i class="fa-solid fa-trash fa-lg"></i>
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-primary m-2" onclick="openTask(${task.id})">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
            })
            .catch(error => console.error('Error al cargar las tareas:', error));
    }

    // Funcion para abrir el modal de edicion de una tarea
    window.openEditTask = function(id) {
        fetch(`/api/tasks/${id}`) // Llama a la API para obtener los datos de la tarea específica
        .then(response => response.json())
        .then(data => {
            // Llena los campos del formulario de edicion con los datos de la tarea
            document.getElementById('editTaskId').value = data.task.id;
            document.getElementById('taskNameEdit').value = data.task.name;
            document.getElementById('taskDescriptionEdit').value = data.task.description;
            document.getElementById('taskStatusEdit').value = data.task.status;
            $('#modalEdit').modal('show'); // Muestra el modal de edición
        })
        .catch(error => {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "No se pudo cargar la tarea. Inténtalo de nuevo.",
            });
        });
    }

    // Funcion para eliminar una tarea
    window.deleteTask = function(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/api/tasks/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status == "success") {
                        Swal.fire('Eliminado!', 'La tarea ha sido eliminada con éxito.', 'success');
                        // Elimina la fila de la tarea de la tabla
                        const taskRow = document.getElementById(`taskRow-${id}`);
                        if (taskRow) {
                            taskRow.remove();
                        }
                    } else {
                        Swal.fire('Error', data.message || 'Ocurrió un problema al intentar eliminar la tarea.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: "error",
                        title: "Error de conexión",
                        text: "No se pudo conectar con el servidor. Intenta nuevamente.",
                    });
                });
            }
        });
    }

    // Funcion para abrir los detalles de una tarea en un modal
    window.openTask = function(id) {
        fetch(`/api/tasks/${id}`)
        .then(response => response.json())
        .then(data => {
            // Llena los elementos del modal con los datos de la tarea
            document.getElementById('showTaskTitle').innerText  = "Task Name: " + data.task.name;
            document.getElementById('showTaskId').innerText  = data.task.id;
            document.getElementById('showTaskDescription').innerText  = data.task.description;
            document.getElementById('showTaskStatus').innerText  = data.task.status;
            document.getElementById('showTaskCreated').innerText  = data.task.created_at;
            document.getElementById('showTaskUpdated').innerText  = data.task.updated_at;
            $('#modalShow').modal('show'); // Muestra el modal de detalles de la tarea
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "No se pudo cargar la tarea. Inténtalo de nuevo.",
            });
        });
    }
});

// Funcion para guardar los cambios de una tarea editada
document.getElementById('btnSaveEdit').addEventListener('click', function (e) {
    e.preventDefault();

    const taskName = document.getElementById('taskNameEdit').value;
    const taskDescription = document.getElementById('taskDescriptionEdit').value;
    const taskStatus = document.getElementById('taskStatusEdit').value;
    const id = document.getElementById('editTaskId').value;

    const formData = {
        name: taskName,
        description: taskDescription,
        status: taskStatus,
        _token: document.querySelector('input[name="_token"]').value
    };

    fetch(`/api/tasks/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify(formData),
    })
    .then(response => response.json())
    .then(data => {
        if (data.status == "success") {
            Swal.fire({
                icon: "success",
                title: "Tarea actualizada",
                text: "La tarea fue actualizada correctamente."
            });

            // Actualiza la fila de la tarea en la tabla con los nuevos datos
            const taskRow = document.getElementById(`taskRow-${data.task.id}`);
            taskRow.innerHTML = `
                <td>${data.task.id}</td>
                <td>${data.task.name}</td>
                <td>${data.task.status}</td>
                <td>
                    <button class="btn btn-primary m-2" onclick="openEditTask(${data.task.id})">
                        <i class="fa-solid fa-pen-to-square fa-xl"></i>
                    </button>
                    <button class="btn btn-danger m-2" onclick="deleteTask(${data.task.id})">
                        <i class="fa-solid fa-trash fa-lg"></i>
                    </button>
                </td>
                <td>
                    <button class="btn btn-primary m-2" onclick="openTask(${data.task.id})">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </button>
                </td>
            `;
        } else if (data.status == "failed") {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: data.message || "Algo salió mal al actualizar la tarea.",
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: "error",
            title: "Error de conexión",
            text: "No se pudo conectar con el servidor. Intenta nuevamente.",
        });
    });
});

// Funcion para guardar una nueva tarea
document.getElementById('btnSave').addEventListener('click', function (e) {
    e.preventDefault(); 

    const taskName = document.getElementById('taskName').value;
    const taskDescription = document.getElementById('taskDescription').value;
    const taskStatus = document.getElementById('taskStatus').value;

    const formData = {
        name: taskName,
        description: taskDescription,
        status: taskStatus,
        _token: document.querySelector('input[name="_token"]').value // Incluye el token CSRF
    };

    fetch('/api/tasks', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
    })
    .then(response => response.json())
    .then(data => {
        if (data.status == "success") {
            Swal.fire({
                icon: "success",
                title: "Tarea creada",
                text: "La tarea fue creada correctamente."
            });

            // Agrega la nueva tarea a la tabla
            const tasksTableBody = document.getElementById('taskTableBody');
            tasksTableBody.innerHTML += `
                <tr id="taskRow-${data.task.id}">
                    <td>${data.task.id}</td>
                    <td>${data.task.name}</td>
                    <td>${data.task.status}</td>
                    <td>
                        <button class="btn btn-primary m-2" onclick="openEditTask(${data.task.id})">
                            <i class="fa-solid fa-pen-to-square fa-xl"></i>
                        </button>
                        <button class="btn btn-danger m-2" onclick="deleteTask(${data.task.id})">
                            <i class="fa-solid fa-trash fa-lg"></i>
                        </button>
                    </td>
                    <td>
                        <button class="btn btn-primary m-2" onclick="openTask(${data.task.id})">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </button>
                    </td>
                </tr>
            `;
        } else if (data.status == "failed") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: data.message || "Algo salió mal al crear la tarea.",
                footer: "Verifica que todos los campos estén correctamente ingresados."
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: "error",
            title: "Error de conexión",
            text: "No se pudo conectar con el servidor. Intenta nuevamente.",
        });
    });
});
