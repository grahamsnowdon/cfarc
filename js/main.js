$(document).ready(function(){
//This script does the main 'heavy lifting' on the interface, also it does the ajax calls and controls the displaying of elements

//The following script is a work in progress to display the earliest and latest date range available on the contract

            //             var oXHR; 
            // $("#dateRange").click(function(event){
            //     if (oXHR){
            //         oXHR.abort();
            //     }
            //     oXHR = $.ajax({
            //             url: "fetchDateRange.php",
            //             type: "post"
            //             //do we need something here to make it work?
            //         });
            //     oXHR.done(function (response, textStatus, jqXHR){
            //         // log a message to the console
            //         $("#dateRange").html(response);
            //         console.log("worked "+response);
            //         });
            //     oXHR.fail(function (jqXHR, textStatus, errorThrown){
            //         // log the error to the console
            //         console.error("The following error occured: "+textStatus, errorThrown);
            //         });
            //     oXHR.always(function () {
            //     });
            //     event.preventDefault();
            //     });

        //hide the inputs that are not needed yet
        $('#cam').hide();
        $('#selTime').hide();
        //display instructions to the user
        $('#message').html('please select a date');
        //create a variable for the AJAX call
        var oXHR;
        //detect the date change and make AJAX call
        $('#imageDate').datepicker({dateFormat:"yy/mm/dd"});
        $("#imageDate").change(function(event){
            $('#output').hide();
            $('#cam').hide();
            $('#selTime').hide();
            //abort any running AJAX calls
            if (oXHR){
                oXHR.abort();
            }
            //variables for the form
            var $form = $('#timeSel');
            var $inputs = $form.find("input, select, button, textarea, text");
            var serializedData = $form.serialize();
            //disable the inputs while making the call
            $inputs.prop("disabled", true);
            //make the call to the php script
            oXHR = $.ajax({
                url: "fetch_cam.php",
                type: "post",
                data: serializedData
                });
            //if it works fine then send results to the relevant DOM object
            oXHR.done(function (response, textStatus, jqXHR){ 
                $("#cam").html(response);
                $('#cam').show();
                });
            //if it's not worked alert the error to the user
            oXHR.fail(function (jqXHR, textStatus, errorThrown){
                alert("The following error occured: "+textStatus, errorThrown);
                });
            //re-enable the inputs
            oXHR.always(function () {
                $inputs.prop("disabled", false);
                });
        event.preventDefault();
        //now show the camera selector DOM object and a message to tell the user what to do now.
        $('#cam').show();
        $('#message').html('now click the required camera');
        });
        //When the user selects the camera send an ajax request to populate the image time selector
        $("#cam").focus(function camChangeFocus(){
            $('#output').hide();
            $('#selTime').hide();
            if (oXHR){
                oXHR.abort();
            }
            var cfCam = $('#cam').val();
            document.cookie="selCam="+cfCam;
            var $form = $('#timeSel');
            var $inputs = $form.find("input, select, button, textarea, text");
            var serializedData = $form.serialize();
            oXHR = $.ajax({
                url: "fetch_times.php",
                type: "post",
                data: serializedData
                });
            oXHR.done(function(response, textStatus, jqXHR){
                $("#selTime").html(response);
                $('#selTime').show();
                });
            oXHR.fail(function (jqXHR, textStatus, errorThrown){
                console.error("The following error occured: "+textStatus, errorThrown);
                });
            $('#message').html('now select the time you want');
        });
        $("#cam").change(function camChange(){
            $('#output').hide();
            $('#selTime').hide();
            if (oXHR){
                oXHR.abort();
            }
            var cfCam = $('#cam').val();
            document.cookie="selCam="+cfCam;
            var $form = $('#timeSel');
            var $inputs = $form.find("input, select, button, textarea, text");
            var serializedData = $form.serialize();
            oXHR = $.ajax({
                url: "fetch_times.php",
                type: "post",
                data: serializedData
                });
            oXHR.done(function(response, textStatus, jqXHR){
                $("#selTime").html(response);
                $('#selTime').show();
                });
            oXHR.fail(function (jqXHR, textStatus, errorThrown){
                console.error("The following error occured: "+textStatus, errorThrown);
                });
            $('#message').html('now select the time you want');
        });

        $("#selTime").change(function(){
            $("#output").attr('src','');
            if (oXHR){
                oXHR.abort();
            }
            var $form = $('#timeSel');
            var $inputs = $form.find("input, select, button, textarea, text");
            var cfTime = $('#selTime').val();
            document.cookie="selTime="+cfTime;
            var serializedData = cfTime;
            oXHR = $.ajax({
                url: "fetch_one_image.php",
                type: "post",
                data: serializedData
                });
            oXHR.done(function(response, textStatus, jqXHR){
                $("#output").attr("src", response);
                });
            oXHR.fail(function (jqXHR, textStatus, errorThrown){
                // log the error to the console
                console.error("The following error occured: "+textStatus, errorThrown);
                });
            $('#output').show();
            $('#message').html('You can change the time or camera or date');
            $('#message').fadeOut(5000);
            $('#message').html('Click the image to zoom in or out');
            $('#message').fadeOut(5000);
        });
        
        $('#output').click(function(){
            $(this).toggleClass('output-lrg');
        });
    });
$('lg-logout').click(function(){
    window.location.replace = "logout.php";
});
