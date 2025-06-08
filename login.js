function showSection(sectionId) {
    var sections = document.querySelectorAll('.container');
    sections.forEach(function(section) {
        section.classList.remove('active');
    });
    document.getElementById(sectionId).classList.add('active');
}

function togglePasswordVisibility(passwordId) {
    var passwordInput = document.getElementById(passwordId);
    var passwordToggle = passwordInput.nextElementSibling;
    var passwordToggleIcon = passwordToggle.querySelector('i');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordToggleIcon.classList.remove('fa-eye');
        passwordToggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        passwordToggleIcon.classList.remove('fa-eye-slash');
        passwordToggleIcon.classList.add('fa-eye');
    }
}

function toggleTimeSection(day) {
    var checkbox = document.getElementById(day + '-available');
    var timeSection = document.getElementById(day + '-section');
    if (checkbox.checked) {
        timeSection.style.display = 'block';
    } else {
        timeSection.style.display = 'none';
    }
}

function applyToAll() {
    var fromTime = document.getElementById('monday-from').value;
    var toTime = document.getElementById('monday-to').value;
    var days = ['tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    days.forEach(function(day) {
        var availableCheckbox = document.getElementById(day + '-available');
        var fromInput = document.getElementById(day + '-from');
        var toInput = document.getElementById(day + '-to');
        availableCheckbox.checked = true;
        fromInput.value = fromTime;
        toInput.value = toTime;
        toggleTimeSection(day);
    });
}
