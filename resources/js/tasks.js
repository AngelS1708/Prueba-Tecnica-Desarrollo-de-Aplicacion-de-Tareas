document.addEventListener('DOMContentLoaded', () => {
    loadTasks();

    // Función para cargar las tareas
    function loadTasks() {
        fetch('/api/tasks')
            .then(response => response.json())
            .then(data => {
                const tasksTableBody = document.getElementById('taskTableBody');
                tasksTableBody.innerHTML = ''; // Limpiar la tabla

                data.forEach(task => {
                    tasksTableBody.innerHTML += `
                        <tr>
                            <td>${task.id}</td>
                            <td>${task.title}</td>
                            <td>${task.status}</td>
                            <td>
                                <button class="btn btn-primary" onclick="editTask(${task.id})">
                                    <i class="fa-solid fa-newspaper fa-xl"></i>
                                </button>
                                <button class="btn btn-danger" onclick="deleteTask(${task.id})">
                                    <i class="fa-solid fa-trash fa-lg"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
            })
            .catch(error => console.error('Error al cargar tareas:', error));
    }

    // Función para editar una tarea (vacía por ahora)
    window.editTask = function(id) {
        console.log(`Editar tarea con id ${id}`);
    }

    // Función para eliminar una tarea (vacía por ahora)
    window.deleteTask = function(id) {
        console.log(`Eliminar tarea con id ${id}`);
    }
});
