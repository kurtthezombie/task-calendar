document.getElementById('myModal').addEventListener('hidden.bs.modal', function () {
    clearInputs();
});
function clearInputs() {
    document.getElementById('TxtTaskTitle').value = '';
    document.getElementById('TxtTaskDescription').value = '';
    document.getElementById('TxtDueDateTime').value = '';
    document.getElementById('CboStatus').value = '';
    document.getElementById('TxtShareWith').value = '';
    document.getElementById('CboReminders').value = '0';
}

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      selectable: true,
      dateClick: function(info) {
          openModal();
      }
    });
    calendar.render();
  });

  function openModal(){
      var myModal = new bootstrap.Modal(document.getElementById('myModal'));
      myModal.show();
      
  } 