function editField(field) {
    var valueElement = document.getElementById(field + 'Value');
    var currentValue = valueElement.innerText;
    valueElement.innerHTML = '<input type="text" id="' + field + 'Input" name="' + field + '" placeholder="請輸入真實' + (field === 'name' ? '姓名' : '') + '" value="' + currentValue + '">';
    document.getElementById('saveButton').style.display = 'block';
}

function saveChanges() {
    var fields = ['name', 'email', 'id', 'passport', 'birthdate', 'phone'];
    fields.forEach(function(field) {
        var inputElement = document.getElementById(field + 'Input');
        if (inputElement) {
            var newValue = inputElement.value;
            document.getElementById(field + 'Value').innerText = newValue;
        }
    });
    document.getElementById('saveButton').style.display = 'none';
}