document.addEventListener('DOMContentLoaded', () => {
    const selectAgenda = document.getElementById('select-agenda');
    const calendarContainer = document.querySelector('.calendar-container');
    let calendarGrid = document.querySelector('.calendar-grid');
    const prevMonthBtn = document.getElementById('prev-month');
    const nextMonthBtn = document.getElementById('next-month');
    const eventModal = document.getElementById('event-modal');
    const closeModal = document.querySelector('.close');
    const saveEventBtn = document.getElementById('save-event');
    const eventTitleInput = document.getElementById('event-title');

    let currentDate = new Date();
    let selectedDate = null;
// Función para manejar el cambio de vista
function handleViewChange(viewType) {
    // Vaciar el contenedor de controles antes de cambiar de vista
    const controlsContainer = document.getElementById('calendar-controls-container');
    if (controlsContainer) {
        controlsContainer.innerHTML = '';
    }
    
    switch(viewType) {
        case 'M': // Vista mensual (calendario)
            generateCalendarView();
            break;
        case 'S': // Vista semanal
            generateWeeklyView();
            break;
        case 'D': // Vista diaria
            generateDailyView();
            break;
        case 'A': // Vista anual
            generateYearlyView();
            break;
        case 'X':
            generateFourDailyView();
            break;
        default:
            console.log("Vista no reconocida");
    }
}


    // Función para ver el año con sus meses y días
    function generateYearlyView() {
        const currentYear = currentDate.getFullYear();
        
        // Generar y asignar los controles de navegación al contenedor específico
        const controlsHTML = `
            <header>
                <div class="calendar-controls">
                    <button id="prev-year">←</button>
                    <h2 id="current-year">${currentYear}</h2>
                    <button id="next-year">→</button>
                </div>
            </header>
        `;
        
        // Asignar al contenedor de controles
        const controlsContainer = document.getElementById('calendar-controls-container');
        if (controlsContainer) {
            controlsContainer.innerHTML = controlsHTML;
        }
        
        // Generar el resto del calendario
        let yearlyHTML = ` 
        <div class="calendar-grid yearly-grid">`;
        
        for (let month = 0; month < 12; month++) {
            const firstDay = new Date(currentYear, month, 1);
            const lastDay = new Date(currentYear, month + 1, 0);
            const prevLastDay = new Date(currentYear, month, 0);
            const firstDayIndex = firstDay.getDay();
            const totalDays = lastDay.getDate();
            const prevDays = prevLastDay.getDate();
            const monthName = firstDay.toLocaleDateString('es-MX', { month: 'long' });

            yearlyHTML += `
                <div class="monthly-calendar">
                    <h3>${monthName.charAt(0).toUpperCase() + monthName.slice(1)}</h3>
                    <table class="calendar-table">
                        <thead>
                            <tr>
                                <th>D</th><th>L</th><th>M</th><th>M</th><th>J</th><th>V</th><th>S</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            let date = 1;
            let nextMonthDate = 1;

            for (let i = 0; i < 6; i++) {
                yearlyHTML += '<tr>';
                for (let j = 0; j < 7; j++) {
                    if (i === 0 && j < firstDayIndex) {
                        const day = prevDays - (firstDayIndex - j - 1);
                        yearlyHTML += `<td class="prev-month-day">${day}</td>`;
                    } else if (date > totalDays) {
                        yearlyHTML += `<td class="next-month-day">${nextMonthDate}</td>`;
                        nextMonthDate++;
                    } else {
                        yearlyHTML += `<td onclick="handleDayClickYearly(${date}, ${month})">${date}</td>`;
                        date++;
                    }
                }
                yearlyHTML += '</tr>';
                if (date > totalDays) break;
            }

            yearlyHTML += `
                        </tbody>
                    </table>
                </div>
            `;
        }

        yearlyHTML += `</div>`;

        if (calendarContainer) {
            calendarContainer.innerHTML = yearlyHTML;
        }

        // Reattach event listeners for year navigation
        const prevYearBtn = document.getElementById('prev-year');
        const nextYearBtn = document.getElementById('next-year');

        if (prevYearBtn) {
            prevYearBtn.addEventListener('click', () => {
                currentDate.setFullYear(currentDate.getFullYear() - 1);
                generateYearlyView();
            });
        }

        if (nextYearBtn) {
            nextYearBtn.addEventListener('click', () => {
                currentDate.setFullYear(currentDate.getFullYear() + 1);
                generateYearlyView();
            });
        }
    }


    
    // Función para ver los días por semana
    function generateWeeklyView() {
        const startOfWeek = new Date(currentDate);
        const dayOfWeek = startOfWeek.getDay(); // 0 (Domingo) - 6 (Sábado)
        startOfWeek.setDate(startOfWeek.getDate() - dayOfWeek); // Ajustar al Domingo de la semana

        // Generar y asignar los controles de navegación al contenedor específico
        const controlsHTML = `
            <header>
                <div class="calendar-controls">
                    <button id="prev-week">←</button>
                    <h2 id="current-week">Semana</h2>
                    <button id="next-week">→</button>
                </div>
            </header>
        `;

        // Asignar al contenedor de controles
        const controlsContainer = document.getElementById('calendar-controls-container');
        if (controlsContainer) {
            controlsContainer.innerHTML = controlsHTML;
        }

        // Generar el resto del calendario
        let weeklyHTML = `
            
            <div class="calendar-grid weekly-grid">
                <table class="schedule-table">
                    <thead>
                        <tr>
                            <th>Hora</th>
        `;

        const daysOfWeek = [];
        for (let i = 0; i < 7; i++) {
            const tempDate = new Date(startOfWeek);
            tempDate.setDate(startOfWeek.getDate() + i);
            const dayNameRaw = tempDate.toLocaleDateString('es-MX', { weekday: 'long' });
            const dayNumber = tempDate.getDate();
            const dayName = dayNameRaw.charAt(0).toUpperCase() + dayNameRaw.slice(1);
            weeklyHTML += `<th>${dayName} ${dayNumber}</th>`;
            daysOfWeek.push(tempDate);
        }

        weeklyHTML += `
                        </tr>
                    </thead>
                    <tbody>
        `;

        for (let i = 0; i < 24; i++) {
            const hour = i < 10 ? `0${i}:00` : `${i}:00`;
            weeklyHTML += `
                <tr>
                    <td class="time-slot">${hour}</td>
            `;
            for (let j = 0; j < 7; j++) {
                weeklyHTML += `<td></td>`;
            }
            weeklyHTML += `
                </tr>
            `;
        }

        weeklyHTML += `
                    </tbody>
                </table>
            </div>
        `;

        if (calendarContainer) {
            calendarContainer.innerHTML = weeklyHTML;
        }

        // Reattach event listeners for week navigation
        const prevWeekBtn = document.getElementById('prev-week');
        const nextWeekBtn = document.getElementById('next-week');
        const currentWeekTitle = document.getElementById('current-week');

        if (currentWeekTitle) {
            const startDate = daysOfWeek[0].toLocaleDateString('es-MX');
            const endDate = daysOfWeek[6].toLocaleDateString('es-MX');
            currentWeekTitle.textContent = `Semana del ${startDate} al ${endDate}`;
        }

        if (prevWeekBtn) {
            prevWeekBtn.addEventListener('click', () => {
                currentDate.setDate(currentDate.getDate() - 7);
                generateWeeklyView();
            });
        }

        if (nextWeekBtn) {
            nextWeekBtn.addEventListener('click', () => {
                currentDate.setDate(currentDate.getDate() + 7);
                generateWeeklyView();
            });
        }
    }

    // Función para ver los días en serie de 4
    function generateFourDailyView() {
        const startDate = new Date(currentDate);

        // Generar y asignar los controles de navegación al contenedor específico
        const controlsHTML = `
            <header>
                <div class="calendar-controls">
                    <button id="prev-4-days">←←</button>
                    <h2 id="current-4-days">Próximos 4 Días</h2>
                    <button id="next-4-days">→→</button>
                </div>
            </header>
        `;

        // Asignar al contenedor de controles
        const controlsContainer = document.getElementById('calendar-controls-container');
        if (controlsContainer) {
            controlsContainer.innerHTML = controlsHTML;
        }

        // Generar el resto del calendario
        let fourDayHTML = `
            
            <div class="calendar-grid four-daily-grid">
                <table class="schedule-table">
                    <thead>
                        <tr>
                            <th>Hora</th>
        `;

        const days = [];
        for (let i = 0; i < 4; i++) {
            const tempDate = new Date(startDate);
            tempDate.setDate(startDate.getDate() + i);
            const dayNameRaw = tempDate.toLocaleDateString('es-MX', { weekday: 'long' });
            const dayNumber = tempDate.getDate();
            const dayName = dayNameRaw.charAt(0).toUpperCase() + dayNameRaw.slice(1);
            fourDayHTML += `<th>${dayName} ${dayNumber}</th>`;
            days.push(tempDate);
        }

        fourDayHTML += `
                        </tr>
                    </thead>
                    <tbody>
        `;

        for (let i = 0; i < 24; i++) {
            const hour = i < 10 ? `0${i}:00` : `${i}:00`;
            fourDayHTML += `
                <tr>
                    <td class="time-slot">${hour}</td>
            `;
            for (let j = 0; j < 4; j++) {
                fourDayHTML += `<td></td>`;
            }
            fourDayHTML += `
                </tr>
            `;
        }

        fourDayHTML += `
                    </tbody>
                </table>
            </div>
        `;

        if (calendarContainer) {
            calendarContainer.innerHTML = fourDayHTML;
        }

        // Reattach event listeners for 4-day navigation
        const prev4DaysBtn = document.getElementById('prev-4-days');
        const next4DaysBtn = document.getElementById('next-4-days');

        if (prev4DaysBtn) {
            prev4DaysBtn.addEventListener('click', () => {
                currentDate.setDate(currentDate.getDate() - 4);
                generateFourDailyView();
            });
        }

        if (next4DaysBtn) {
            next4DaysBtn.addEventListener('click', () => {
                currentDate.setDate(currentDate.getDate() + 4);
                generateFourDailyView();
            });
        }
    }

    // Función para ver el día en específico
    function generateDailyView() {
        const dayNameRaw = currentDate.toLocaleDateString('es-MX', { weekday: 'long' });
        const dayNumber = currentDate.getDate();
        const monthNameRaw = currentDate.toLocaleDateString('es-MX', { month: 'long' });
        const yearNumber = currentDate.getFullYear();

        // Capitalizar la primera letra del nombre del día
        const dayName = dayNameRaw.charAt(0).toUpperCase() + dayNameRaw.slice(1);

        // Capitalizar la primera letra del nombre del mes
        const monthName = monthNameRaw.charAt(0).toUpperCase() + monthNameRaw.slice(1);

        // Generar y asignar los controles de navegación al contenedor específico
        const controlsHTML = `
            <header>
                <div class="calendar-controls">
                    <button id="prev-day">←</button>
                    <h2 id="current-day">${dayName} ${dayNumber} de ${monthName} ${yearNumber}</h2>
                    <button id="next-day">→</button>
                </div>
            </header>
        `;

        // Asignar al contenedor de controles
        const controlsContainer = document.getElementById('calendar-controls-container');
        if (controlsContainer) {
            controlsContainer.innerHTML = controlsHTML;
        }

        // Generar el resto del calendario
        let dailyHTML = `
            
            <div class="calendar-grid daily-grid">
                <table class="schedule-table">
                    <thead>
                        <tr>
                            <td>Hora</td>
                            <td>${dayName} ${dayNumber}</td>
                        </tr>
                    </thead>
                    <tbody>
        `;

        for (let i = 0; i < 24; i++) {
            const hour = i < 10 ? `0${i}:00` : `${i}:00`;
            dailyHTML += `
                <tr>
                    <td class="time-slot">${hour}</td>
                    <td></td>
                </tr>
            `;
        }

        dailyHTML += `
                    </tbody>
                </table>
            </div>
        `;

        if (calendarContainer) {
            calendarContainer.innerHTML = dailyHTML;
        }

        // Reattach event listeners for day navigation
        const prevDayBtn = document.getElementById('prev-day');
        const nextDayBtn = document.getElementById('next-day');

        if (prevDayBtn) {
            prevDayBtn.addEventListener('click', () => {
                currentDate.setDate(currentDate.getDate() - 1);
                generateDailyView();
            });
        }

        if (nextDayBtn) {
            nextDayBtn.addEventListener('click', () => {
                currentDate.setDate(currentDate.getDate() + 1);
                generateDailyView();
            });
        }
    }


    
// Función para vista de calendario mensual
function generateCalendarView() {
    const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
    const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
    const prevLastDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 0);

    const firstDayIndex = firstDay.getDay();
    const totalDays = lastDay.getDate();
    const prevDays = prevLastDay.getDate();

    const capitalize = (text) => text.charAt(0).toUpperCase() + text.slice(1);
    const currentMonthText = `${capitalize(currentDate.toLocaleString('es-MX', { month: 'long' }))} ${currentDate.getFullYear()}`;

    // Generar controles de navegación mensual
    const controlsHTML = `
        <header>
            <div class="calendar-controls">
                <button id="prev-month" class="btn btn-outline">←</button>
                <h2 id="current-month" class="calendar-title">${currentMonthText}</h2>
                <button id="next-month" class="btn btn-outline">→</button>
            </div>
        </header>
    `;
    
    // Asignar al contenedor de controles
    const controlsContainer = document.getElementById('calendar-controls-container');
    if (controlsContainer) {
        controlsContainer.innerHTML = controlsHTML;
    }

    // Generar el grid del calendario
    let calendarHTML = `
        
        
            <table class="month-grid">
                <thead>
                    <tr>
                        <th>Domingo</th>
                        <th>Lunes</th>
                        <th>Martes</th>
                        <th>Miércoles</th>
                        <th>Jueves</th>
                        <th>Viernes</th>
                        <th>Sábado</th>
                    </tr>
                </thead>
                <tbody id="calendar-days">
                </tbody>
            </table>
        
    `;

    if (calendarContainer) {
        calendarContainer.innerHTML = calendarHTML;
    }

    // Generar los días del calendario
    const calendarDays = document.getElementById('calendar-days');
    if (calendarDays) {
        let daysHTML = '';
        let date = 1;
        let nextMonthDate = 1;

        const rows = Math.ceil((firstDayIndex + totalDays) / 7);
        for (let i = 0; i < rows; i++) {
            daysHTML += '<tr>';
            for (let j = 0; j < 7; j++) {
            if (i === 0 && j < firstDayIndex) {
                const day = prevDays - (firstDayIndex - j - 1);
                daysHTML += `<td class="other-month"><div class="day-number">${day}</div></td>`;
            } else if (date > totalDays) {
                daysHTML += `<td class="other-month">${nextMonthDate}</td>`;
                nextMonthDate++;
            } else {
                const currentDay = date;
                const isToday = currentDate.getFullYear() === new Date().getFullYear() &&
                    currentDate.getMonth() === new Date().getMonth() &&
                    currentDay === new Date().getDate();
                const dayClass = isToday ? 'today' : '';
                daysHTML += `<td class="${dayClass}" onclick="handleDayClick(${currentDay})"><div class="day-number">${date}</div></td>`;
                date++;
            }
            }
            daysHTML += '</tr>';
        }
        calendarDays.innerHTML = daysHTML;
    }

    // Event listeners para navegación mensual
    const prevMonthBtn = document.getElementById('prev-month');
    const nextMonthBtn = document.getElementById('next-month');

    if (prevMonthBtn) {
        prevMonthBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            if (selectAgenda && selectAgenda.value === 'M') {
                generateCalendarView();
            }
        });
    }

    if (nextMonthBtn) {
        nextMonthBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            if (selectAgenda && selectAgenda.value === 'M') {
                generateCalendarView();
            }
        });
    }
}

    // Función global para manejar el clic en un día (para la vista mensual)
    window.handleDayClick = function(day) {
        currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
        if (selectAgenda && selectAgenda.value === 'M') {
            if (eventModal) eventModal.style.display = 'flex';
            selectedDate = new Date(currentDate); // Almacena la fecha seleccionada para el modal
        }
    };
    // Función global para manejar el clic en un día (para la vista anual)
    window.handleDayClickYearly = function(day, month) {
        currentDate = new Date(currentDate.getFullYear(), month, day);
        if (selectAgenda && selectAgenda.value === 'A') {
            if (eventModal) eventModal.style.display = 'flex';
            selectedDate = new Date(currentDate); // Almacena la fecha seleccionada para el modal
        }
    };
    // Modal de eventos
    if (closeModal) {
        closeModal.addEventListener('click', () => {
            if (eventModal) eventModal.style.display = 'none';
        });
    }

    if (saveEventBtn) {
        saveEventBtn.addEventListener('click', () => {
            if (selectedDate && eventTitleInput && eventTitleInput.value) {
                alert(`Evento "${eventTitleInput.value}" guardado para ${selectedDate.toLocaleDateString()}`);
                eventTitleInput.value = '';
                if (eventModal) eventModal.style.display = 'none';
            }
        });
    }

    // Inicializar la vista basada en la selección inicial
    if (selectAgenda) {
        handleViewChange(selectAgenda.value);
        selectAgenda.addEventListener('change', (e) => {
            console.log(`Selected value: ${e.target.value}`);
            handleViewChange(e.target.value);
        });
    }
});