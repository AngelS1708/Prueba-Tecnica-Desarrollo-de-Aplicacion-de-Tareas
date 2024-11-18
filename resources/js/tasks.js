document.addEventListener('DOMContentLoaded', () => {
    loadTasks();

    // Función para cargar las tareas
    function loadTasks() {
        fetch('/api/tasks')
            .then(response => response.json())
            .then(data => {
                const tasksTableBody = document.getElementById('taskTableBody');
                tasksTableBody.innerHTML = ''; // Limpiar la tabla

                data.tasks.forEach(task => {
                    tasksTableBody.innerHTML += `
                        <tr>
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

    // Función para editar una tarea (vacía por ahora)
    window.openEditTask = function(id) {
        console.log(`Editar tarea con id ${id}`);
        fetch(`/api/tasks/${id}`)
        .then(response => response.json())
        .then(data => {
            // Asigna el id de la tarea que se está editando
            // currentTaskId = id;

            // Llena el formulario con los datos de la tarea
            document.getElementById('editTaskId').value = data.task.id;
            document.getElementById('taskNameEdit').value = data.task.name;
            document.getElementById('taskDescriptionEdit').value = data.task.description;
            document.getElementById('taskStatusEdit').value = data.task.status;

            // Muestra el modal
            $('#modalEdit').modal('show');
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

    // Función para eliminar una tarea (vacía por ahora)
    window.deleteTask = function(id) {
        console.log(`Eliminar tarea con id ${id}`);
        
        Swal.fire({
            title: '¿Estas seguro?',
            text: "¡No podras revertir esto!",
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
                        Swal.fire(
                            'Eliminado!',
                            'La tarea ha sido eliminada con exito.',
                            'success'
                        );
                        // Aquí puedes agregar código para actualizar la lista de tareas sin recargar la página
                    } else {
                        Swal.fire(
                            'Error',
                            data.message || 'Ocurrió un problema al intentar eliminar la tarea.',
                            'error'
                        );
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

    window.openTask = function(id) {
        console.log(`Abierta la tarea con id ${id}`);
        fetch(`/api/tasks/${id}`)
        .then(response => response.json())
        .then(data => {
                        
            // Llenar el modal con los datos de la tarea
            document.getElementById('showTaskTitle').innerText  = "Task Name: " + data.task.name;
            document.getElementById('showTaskId').innerText  = data.task.id;
            document.getElementById('showTaskDescription').innerText  = data.task.description;
            document.getElementById('showTaskStatus').innerText  = data.task.status;
            document.getElementById('showTaskCreated').innerText  = data.task.created_at;
            document.getElementById('showTaskUpdated').innerText  = data.task.updated_at;
            
            // Mostrar el modal (si no se abre automáticamente con data-bs-toggle)
            $('#modalShow').modal('show');
            console.log(data.task.name);
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



document.getElementById('btnSaveEdit').addEventListener('click', function (e) {
    e.preventDefault(); // Prevenir el envío normal del formulario

    const taskName = document.getElementById('taskNameEdit').value;
    const taskDescription = document.getElementById('taskDescriptionEdit').value;
    const taskStatus = document.getElementById('taskStatusEdit').value;
    const id = document.getElementById('editTaskId').value;

    console.log(taskName);
    console.log(taskDescription);
    console.log(taskStatus);
    console.log(id);

    const formData = {
        name: taskName,
        description: taskDescription,
        status: taskStatus,
        _token: document.querySelector('input[name="_token"]').value // Incluir el token CSRF
    };

        // Realizar la solicitud PUT
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
        
        // Cerrar el modal de edición y resetear el formulario
        // $('#modalEdit').modal('hide');
        // document.getElementById('editTaskForm').reset(); // Asegúrate de que el ID del formulario de edición es 'editTaskForm'
    } else if(data.status == "failed") {
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

document.getElementById('btnSave').addEventListener('click', function (e) {
    e.preventDefault(); // Prevenir el envío normal del formulario

    
    // Recoger los valores de los campos del formulario
    const taskName = document.getElementById('taskName').value;
    const taskDescription = document.getElementById('taskDescription').value;
    const taskStatus = document.getElementById('taskStatus').value;

    console.log(taskName);
    console.log(taskDescription);
    console.log(taskStatus);

    // Crear un objeto con los datos del formulario
    const formData = {
        name: taskName,
        description: taskDescription,
        status: taskStatus,
        _token: document.querySelector('input[name="_token"]').value // Incluir el token CSRF
    };

    // Hacer la solicitud POST con Fetch
    fetch('/api/tasks', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
    })
    .then(response => response.json())
    .then(data => {
        // Aquí validamos si la respuesta es exitosa o contiene errores
        if (data.status == "success") {
            // Si la API devuelve un campo success, podemos asumir que la tarea fue creada correctamente
            Swal.fire({
                icon: "success",
                title: "Tarea creada",
                text: "La tarea fue creada correctamente."
            });
            // Cerrar el modal
            $('#modalAdd').modal('hide');
            document.getElementById('taskForm').reset(); // Resetear el formulario
        } else if(data.status == "failed"){
            // Si la API devuelve un error
            console.log(data);
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: data.message || "Algo salió mal al crear la tarea.",
                footer: "Verifica que todos los campos esten correctamente ingresados."
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Si ocurre un error de red o de otro tipo
        Swal.fire({
            icon: "error",
            title: "Error de conexión",
            text: "No se pudo conectar con el servidor. Intenta nuevamente.",

        });
    });
});
