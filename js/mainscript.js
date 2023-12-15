var taskForm = document.getElementById('taskForm');

document.getElementById('addTaskModal').addEventListener('hidden.bs.modal', function () {
    clearInputs();
});

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
        dayMaxEvents: true,
        selectable: true,
        events: '/taskcalendarsystem/fetch_events.php',
        eventClick: function (info) {
            console.log("Event click functioning.."),
                assignValue(info.event),
                openModal('taskDisplayModal')
        },
        dateClick: function (info) {
            var clickedDate = info.date;

            var formattedDate = clickedDate.getFullYear() + '-' + padNumber(clickedDate.getMonth() + 1) + '-' + padNumber(clickedDate.getDate()) +
                'T' + padNumber(clickedDate.getHours()) + ':' + padNumber(clickedDate.getMinutes());

            $('#TxtStartDate').val(formattedDate);
            //$('#TxtStartDate').prop('readonly', true);

            console.log('Clicked on :' + info.dateStr);
            openModal('addTaskModal');
        },

        customButtons: {
            addTask: {
                text: '+',
                click: function () {
                    //startDateToggle();  // Assuming startDateReadOnlyToggle is a valid function
                    openModal('addTaskModal');  // Assuming openModal is a valid function
                },
                hint: 'Add Task'
            }
        }
    });
    calendar.render();
});

/*function startDateToggle() {
    var startDateToggle = document.getElementById('TxtStartDate');

    startDateToggle.readOnly = false;
    console.log('StartDate Set to !isReadOnly');
}*/

function assignValue(eventInfo) {
    document.getElementById('TaskId').value = eventInfo.id;
    document.getElementById('TaskTitle').innerHTML = eventInfo.title;
    document.getElementById('TaskDescription').innerHTML = eventInfo.extendedProps.description;
    document.getElementById('StartDate').innerHTML = eventInfo.start;
    document.getElementById('EndDate').innerHTML = eventInfo.end;
    switch (eventInfo.extendedProps.status) { 
        case 'to-do':
            document.getElementById('TaskStatus').innerHTML = 'TO-DO';
            document.getElementById('TaskStatus').classList.add('text-muted');
            document.getElementById('TaskStatus').classList.remove('text-warning');
            document.getElementById('TaskStatus').classList.remove('text-success');
            break;
        case 'doing':
            document.getElementById('TaskStatus').innerHTML = 'DOING';
            document.getElementById('TaskStatus').classList.add('text-warning');
            document.getElementById('TaskStatus').classList.remove('text-success');
            document.getElementById('TaskStatus').classList.remove('text-muted');
            break;
        case 'done':
            document.getElementById('TaskStatus').innerHTML = 'DONE';
            document.getElementById('TaskStatus').classList.add('text-success');
            document.getElementById('TaskStatus').classList.remove('text-warning');
            document.getElementById('TaskStatus').classList.remove('text-muted');
            break;
    }



    if (eventInfo.extendedProps.reminder == 1) {
        document.getElementById('ReminderSettings').innerHTML = 'ON';
        document.getElementById('ReminderSettings').classList.remove('text-danger');
        document.getElementById('ReminderSettings').classList.add('text-success');
    }
    else {
        document.getElementById('ReminderSettings').innerHTML = 'OFF';
        document.getElementById('ReminderSettings').classList.add('text-danger');
        document.getElementById('ReminderSettings').classList.remove('text-success');

    }

}

function clearInputs() {
    document.getElementById('TxtTaskTitle').value = null;
    document.getElementById('TxtTaskDescription').value = null;
    document.getElementById('TxtStartDate').value = null;
    document.getElementById('TxtDueDateTime').value = null;
    //document.getElementById('CboStatus').value = 'doing';
    //document.getElementById('TxtShareWith').value = null;
    //document.getElementById('CboReminders').value = 0;
}

function modalReadOnly() {
    //convert the inputs to readOnly
    document.getElementById('TxtTaskTitle').readOnly = true;
    document.getElementById('TxtTaskDescription').readOnly = true;
    document.getElementById('TxtStartDate').readOnly = true;
    document.getElementById('TxtDueDateTime').readOnly = true;
    document.getElementById('CboStatus').readOnly = true;
    document.getElementById('TxtShareWith').readOnly = true;
    document.getElementById('CboReminders').readOnly = true;

    openModal();
}

function openModal(modalName) {
    var myModal = new bootstrap.Modal(document.getElementById(modalName));
    myModal.show();
}

function padNumber(number) {
    return number.toString().padStart(2, '0');
}





