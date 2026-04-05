$(document).ready(function(){

    $("#addCourse").click(function(){
        let row = $(".course-row").first().clone();
        row.find("input").val("");
        $("#courses").append(row);
    });

    $("#gpaForm").submit(function(e){
        e.preventDefault();

        $.ajax({
            url: "calculate.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",

            success: function(res){

                let color = "info";

                if (res.gpa >= 3.7) color = "success";
                else if (res.gpa >= 2.0) color = "warning";
                else color = "danger";

                $("#result").html(`
                    <div class="alert alert-${color}">
                        ${res.message}
                    </div>
                    ${res.table}
                `);
            }
        });
    });

});
