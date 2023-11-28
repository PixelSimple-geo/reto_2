/* Desmarcar checkboxes */
document.getElementById('uncheck-all').addEventListener('click', function() {
    var checkboxes = document.querySelectorAll('input[name="categories[]"]');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = false;
    });
});
