<?php
include_once realpath(dirname(__FILE__) . "/../modelos/listas3.php");
$vista = new consulta_calendario();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Calendario Manual</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/calendario.css">
    <link rel="stylesheet" href="./css/evento-tarea.css">
</head>
<body>

    <!-- <td class="today">
        <div class="day-number">19</div>
        <div class="event" style="background-color: #4cc9f0;">Reunión equipo</div>
    </td>
    <td>
        <div class="day-number">20</div>
        <div class="event" style="background-color: #4caf50;">Entrega proyecto</div>
    </td>
    <td>
        <div class="day-number">21</div>
    </td>
    <td>
        <div class="day-number">22</div>
        <div class="event" style="background-color: #ff9800;">Revisión mensual</div>
    </td> -->
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <i class="far fa-calendar-alt"></i>
                <span>MiCalendario</span>
            </div>
            <ul class="sidebar-menu">
            <li><button class="btn btn-primary" id="add-event">                <i class="fas fa-plus"></i> Nuevo Evento            </button></li>
                <li><a href="#" class="active" onclick="showSection('calendario')"><i class="fas fa-calendar-day"></i> Calendario</a></li>
                <li><a href="#" onclick="showSection('eventos')"><i class="fas fa-calendar-alt"></i> Eventos</a></li>
                <li><a href="#" onclick="showSection('tareas')"><i class="fas fa-tasks"></i> Tareas</a></li>
                <!-- <li><a href="#" onclick="showSection('contactos')"><i class="fas fa-users"></i> Contactos</a></li> -->
                <!-- <li><a href="#" onclick="showSection('configuracion')"><i class="fas fa-cog"></i> Configuración</a></li> -->
            </ul>
        </aside>
<script>
    function showSection(sectionId) {
  event.preventDefault();
  
  // Ocultar todos los main
  document.querySelectorAll('.main-content').forEach(main => {
    main.style.display = 'none';
  });
  
  // Mostrar el seleccionado
  document.getElementById(sectionId).style.display = 'block';
  
  // Actualizar menú (igual que antes)
  const menuItems = document.querySelectorAll('.sidebar-menu a');
  menuItems.forEach(item => {
    item.classList.remove('active');
  });
  event.target.classList.add('active');
}
</script>
  <!-- Main Content -->
  <main class="main-content" id="calendario">
    <!-- Header -->
    <header class="header">
        <h1>Calendario</h1>
        <header class="header-agenda">
            </header>    
        <div class="header-actions">
            <div class="view-selector">
                <select id="select-agenda" class="select-agenda">
                    <option value="D">Día</option>
                    <option value="S">Semana</option>
                    <option value="M" selected>Mes</option>
                    <option value="A">Año</option>
                    <option value="X">4 días</option>
                </select>  
            </div>

           
            <!-- <button class="btn btn-primary" id="add-event">
                <i class="fas fa-plus"></i> Nuevo Evento
            </button> -->
        </div>
    </header>      
  <!-- Calendar Controls -->
  <div class="calendar-controls">
    <div class="calendar-nav">
          <!-- Contenedor para los controles de navegación -->
          <div id="calendar-controls-container" ></div>
    </div>
    
    <div class="calendar-search">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Buscar eventos...">
    </div>
</div>

            <!-- Calendar View -->
            <div class="calendar-view">
              
                            <!-- <td class="today">
                                <div class="day-number">19</div>
                                <div class="event" style="background-color: #4cc9f0;">Reunión equipo</div>
                            </td>
                            <td>
                                <div class="day-number">20</div>
                                <div class="event" style="background-color: #4caf50;">Entrega proyecto</div>
                            </td>
                            <td>
                                <div class="day-number">21</div>
                            </td>
                            <td>
                                <div class="day-number">22</div>
                                <div class="event" style="background-color: #ff9800;">Revisión mensual</div>
                            </td>
                            
                            <td class="other-month">
                                <div class="day-number">28</div>
                                <div class="events-container"></div>
                            </td>
                            <td class="other-month">
                                <div class="day-number">29</div>
                                <div class="events-container"></div>
                            </td>
                            <td>
                                <div class="day-number">30</div>
                                <div class="events-container">
                                    <div class="event" style="background-color: #4cc9f0;">Reunión equipo</div>
                                </div>
                            </td>
                            <td>
                                <div class="day-number">1</div>
                                <div class="events-container"></div>
                            </td>
                            <td>
                                <div class="day-number">2</div>
                                <div class="events-container"></div>
                            </td> -->
                       
                <div class="calendar-container"></div>
            </div>
            
        </main>

        <main class="main-content task-dashboard" id="eventos" style="display: none;">
            <!-- Header con estilo minimalista -->
            <header class="task-header">
            <h1 class="task-main-title">Gestión de Eventos</h1>
            <div class="header-accent"></div>
            <div class="header-actions">

           

        </div>
            </header>

            <!-- Contenedor de la tabla con scroll responsivo -->
            <div class="table-container">
            <?php echo $vista->obtener_eventos(); ?>
            </div>
        </main>

        <main class="main-content task-dashboard" id="tareas" style="display: none;">
            <!-- Header con estilo minimalista -->
            <header class="task-header">
            <h1 class="task-main-title">Gestión de Tareas</h1>
            <div class="header-accent"></div>
            </header>

            <!-- Contenedor de la tabla con scroll responsivo -->
            <div class="table-container">
            <?php echo $vista->obtener_tareas(); ?>
            </div>
        </main>

      <!-- Event Modal -->
      <div class="modal" id="event-modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2 class="modal-title">Nuevo Evento</h2>
            
            <div class="event-type-selector">
                <div class="event-type-option">
                    <input type="radio" name="event-type" id="event-type-event" class="event-type-radio" checked>
                    <label for="event-type-event" class="event-type-label">
                        <i class="fas fa-calendar-check"></i> Evento
                    </label>
                </div>
                <div class="event-type-option">
                    <input type="radio" name="event-type" id="event-type-task" class="event-type-radio">
                    <label for="event-type-task" class="event-type-label">
                        <i class="fas fa-tasks"></i> Tarea
                    </label>
                </div>
            </div>

            <div id="event-form" class="form-container">
                <div class="form-group">
                    <label for="titulo">Título</label>
                    <input type="text" id="titulo" class="form-control" placeholder="Título del evento">
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" class="form-control" rows="3" placeholder="Descripción del evento"></textarea>
                </div>
                <div class="form-group form-inline">
                    <div class="input_1">
                    <label for="fecha-inicio">Fecha de Inicio</label>
                    <input type="datetime-local" id="fecha-inicio" class="form-control inline-field">
                </div>
                <div class="input_2">
                    <label for="fecha-fin" class="ml-2">Fecha de Fin</label>
                    <input type="datetime-local" id="fecha-fin" class="form-control inline-field">
                </div>
                </div>
                <div class="form-group">
                    <label for="ubicacion">Ubicación</label>
                    <input type="text" id="ubicacion" class="form-control" placeholder="Ubicación del evento">
                </div>
                
                <div class="form-group">
                    <label for="es-todo-el-dia">¿Es Todo el Día?</label>
                    <select id="es-todo-el-dia" class="form-control">
                        <option value="no">No</option>
                        <option value="si">Sí</option>
                    </select>
                </div>
  
                <div class="form-group">
                    <label for="visibilidad">Visibilidad</label>
                    <input type="text" id="visibilidad" class="form-control" placeholder="Visibilidad del evento">
                </div>
                <button class="btn btn-primary" id="save-event">
                <i class="fas fa-save"></i> Guardar Evento
            </button>
            </div>

            <div id="task-form" class="form-container" style="display: none;">
                
                <div class="form-group">
                    <label for="user-id">ID de Usuario</label>
                    <input type="text" id="user-id" class="form-control" placeholder="ID del usuario">
                </div>
                <div class="form-group">
                    <label for="task-title">Título</label>
                    <input type="text" id="task-title" class="form-control" placeholder="Nombre de la tarea">
                </div>
                <div class="form-group">
                    <label for="task-description">Descripción</label>
                    <textarea id="task-description" class="form-control" rows="3" placeholder="Descripción de la tarea"></textarea>
                </div>

                <div class="form-group">
                    <label for="task-deadline">Fecha de Vencimiento</label>
                    <input type="datetime-local" id="task-deadline" class="form-control">
                </div>
                <div class="form-group">
                    <label for="task-priority">Prioridad</label>
                    <select id="task-priority" class="form-control">
                        <option value="low">Baja</option>
                        <option value="medium">Media</option>
                        <option value="high">Alta</option>
                    </select>
                </div>

                <button class="btn btn-primary" id="save-task">
                <i class="fas fa-save"></i> Guardar Tarea
            </button>

            </div>

           
            
            

        </div>
    </div>




    <script src="./js/eventos-tarea.js"></script>
    <script src="./js/calendario.js"></script>
</body>
</html>