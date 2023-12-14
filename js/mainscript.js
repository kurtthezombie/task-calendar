var taskForm = document.getElementById('taskForm');

document.getElementById('myModal').addEventListener('hidden.bs.modal', function () {
    clearInputs();
});
function clearInputs() {
    document.getElementById('TxtTaskTitle').value = null;
    document.getElementById('TxtTaskDescription').value = null;
    document.getElementById('TxtStartDate').value = null;
    document.getElementById('TxtDueDateTime').value = null;
    //document.getElementById('CboStatus').value = 'doing';
    //document.getElementById('TxtShareWith').value = null;
    //document.getElementById('CboReminders').value = 0;
}

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        themeSystem: 'standard',
        headerToolbar: {
            left: 'today prev,next',
            center: 'title',
            right: 'dayGridMonth timeGridWeek dayGridYear addTask'
        },
        initialView: 'dayGridMonth',
        selectable: true,
        dateClick: function(info) {
            $('#TxtStartDate').val(info.dateStr);
            $('#TxtStartDate').prop('readonly', true);

            console.log('Clicked on :' + info.dateStr);
            openModal();
        },
        events: '/taskcalendarsystem/fetch_events.php',
        customButtons: {
            addTask: {
                text: '+',
                click: function() {
                    startDateToggle();  // Assuming startDateReadOnlyToggle is a valid function
                    openModal();  // Assuming openModal is a valid function
                },
                hint: 'Add Task'
            }
        }
    });
    calendar.render();
});

function startDateToggle() {
    var startDateToggle = document.getElementById('TxtStartDate');

    startDateToggle.readOnly = false;
    console.log('StartDate Set to !isReadOnly');
} 

function openModal() {
    var myModal = new bootstrap.Modal(document.getElementById('myModal'));
    myModal.show();

} 