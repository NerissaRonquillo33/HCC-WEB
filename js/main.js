$(function(){

    var ajaxGet = function(data, url, callback) {
        $.ajax({ 
            url: url, 
            type: 'GET',
            data: data, 
            success: callback
        });
    };

    $('select[name="courses_name"]').on('change', function() {
        var id = $(this).find(":selected").val();
        $('select[name="course"]').empty();
        $('select[name="course"]').prop("disabled", true);
        $('select[name="student"]').empty();
        $('select[name="student"]').prop("disabled", true);
        $('select[name="teacher"]').empty();
        $('select[name="teacher"]').prop("disabled", true);
        ajaxGet({id:id}, './api/web/courses-name.php', function(response){
            for (var i=0;i<response.results.length;++i)
            {
                $('select[name="course"]').append('<option value="'+response.results[i].id+'">'+response.results[i].code+', '+response.results[i].description+', '+response.results[i].unit+', '+response.results[i].semester+', '+response.results[i].year+'</option>');
            }
            if (response.results.length > 0) {
                $('select[name="course"]').prop("disabled", false);
            }
        });
        ajaxGet({id:id,role:'student'}, './api/web/student-by-course.php', function(response){
            for (var i=0;i<response.results.length;++i)
            {
                $('select[name="student"]').append('<option value="'+response.results[i].id+'">'+response.results[i].lastname+', '+response.results[i].firstname+' '+response.results[i].middlename+'</option>');
            }
            if (response.results.length > 0) {
                $('select[name="student"]').prop("disabled", false);
            }
        });
        ajaxGet({id:id,role:'teacher'}, './api/web/student-by-course.php', function(response){
            for (var i=0;i<response.results.length;++i)
            {
                $('select[name="teacher"]').append('<option value="'+response.results[i].id+'">'+response.results[i].lastname+', '+response.results[i].firstname+' '+response.results[i].middlename+'</option>');
            }
            if (response.results.length > 0) {
                $('select[name="teacher"]').prop("disabled", false);
            }
        });
    });

    $('.table-cell-nav-left img').on('click', function(){
        window.location.href = $(this).data("url");
        return false;
    });
    $('.table-cell-nav-bar').on('click', function(){
        window.location.href = $(this).data("url");
        return false;
    });
    $('.table-cell-nav-right img').on('click', function(){
        $("#navbar").toggle();
        return false;
    });

    $('input[name="dob"]').datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "1930:2025",
        dateFormat: "yy-mm-dd"
    });

    $('.close').on('click', function(){
        $('#popup').removeClass().addClass('overlay overlay-hidden')
    });

}); 