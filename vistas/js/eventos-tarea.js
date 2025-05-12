// JavaScript for the calendar and event management
document.addEventListener('DOMContentLoaded', function () {
    const eventTypeEvent = document.getElementById('event-type-event');
    const eventTypeTask = document.getElementById('event-type-task');
    const eventForm = document.getElementById('event-form');
    const taskForm = document.getElementById('task-form');

    eventTypeEvent.addEventListener('change', function () {
        if (eventTypeEvent.checked) {
            eventForm.style.display = 'block';
            taskForm.style.display = 'none';
        }
    });

    eventTypeTask.addEventListener('change', function () {
        if (eventTypeTask.checked) {
            eventForm.style.display = 'none';
            taskForm.style.display = 'block';
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Modal functionality
    const modal = document.getElementById('event-modal');
    const addEventBtn = document.getElementById('add-event');
    const closeModalBtn = document.querySelector('.close-modal');
    const saveEventBtn = document.getElementById('save-event');
    
    // View selector
    const viewOptions = document.querySelectorAll('.view-option');
    
    // Navigation buttons
    const prevPeriodBtn = document.getElementById('prev-period');
    const nextPeriodBtn = document.getElementById('next-period');
    
    // Open modal
    addEventBtn.addEventListener('click', function() {
        modal.style.display = 'flex';
    });
    
    // Close modal
    closeModalBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    // Save event
    saveEventBtn.addEventListener('click', function() {
        // Here you would save the event
        alert('Evento guardado!');
        modal.style.display = 'none';
    });
    
    // Change view
    viewOptions.forEach(option => {
        option.addEventListener('click', function() {
            viewOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            // Here you would change the calendar view
        });
    });
    
    // Navigation
    if (prevPeriodBtn) {
        prevPeriodBtn.addEventListener('click', function() {
            // Go to previous period (day/week/month/year)
            console.log('Navigating to previous period');
        });
    }
    
    if (nextPeriodBtn) {
        nextPeriodBtn.addEventListener('click', function() {
            // Go to next period (day/week/month/year)
            console.log('Navigating to next period');
        });
    }
    
    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
    
    // Sample: Add click event to calendar cells
    const calendarCells = document.querySelectorAll('.month-grid td:not(.other-month)');
    calendarCells.forEach(cell => {
        cell.addEventListener('click', function() {
            // Here you could open the modal with the selected date
            const dayNumber = this.querySelector('.day-number').textContent;
            console.log('Day selected:', dayNumber);
        });
    });
});