$(document).ready(function () {
    $('#loginform').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/admin/login/check",
            data: $(this).serialize(),
            success: function(response) {
                var jsonData = JSON.parse(response);

                if(jsonData.success == "1") {
                    location.href = '/admin/';
                } else {
                    alert('Неправильный ajax!!!');
                }
            }
        });
    });
});