var button = document.getElementById('search_list');
button.addEventListener('click', function() {
    var obj = document.getElementById('check_type');

    var index = obj.selectedIndex;
    var value = obj.options[index].value;
    window.location.href = '/admin/check_items?check_type='+value;
});


