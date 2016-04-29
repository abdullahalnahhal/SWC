/*=============================================================
    Authour URL: www.designbootstrap.com
    
    http://www.designbootstrap.com/

    License: MIT

    http://opensource.org/licenses/MIT

    100% Free To use For Personal And Commercial Use.

    IN EXCHANGE JUST TELL PEOPLE ABOUT THIS WEBSITE
   
========================================================  */           

$(document).ready(function () {

    /*====================================
           METIS MENU 
     ======================================*/

    $('#main-menu').metisMenu();

    /*======================================
    LOAD APPROPRIATE MENU BAR ON SIZE SCREEN
    ========================================*/

    $(window).bind("load resize", function () {
        if ($(this).width() < 768) {
            $('div.sidebar-collapse').addClass('collapse')
        } else {
            $('div.sidebar-collapse').removeClass('collapse')
        }
    });
    /*======================================
   WRITE YOUR SCRIPTS BELOW
   ========================================*/
   $(".datatable").dataTable();
   /*======================================
        Upload Profile Pictures
     =======================================*/

     $("#attach").click(function(event) 
     {
        $("#uploader").click();
     });
});
var file = "";
    function get_ex()
        {
            ex = $("#uploader").val();
            ex = ex.split(".");
            ex = ex[ex.length-1];
            imgs = ["jpg","JPG","JPEG","jpeg","GIF","gif","png","PNG","ico","ICO"]
            if (imgs.indexOf(ex) == -1) 
            {
                return false;
            }
            else
            {
                return true;
            }
        }
    function loadFile (event) 
        {
            ex = get_ex(); 
            if (ex != true)
            {
                alert("You Have To Attach Images Only ...!\n يجب أن تختار صور فقط لرفعها");
            }
            else
            {
                var reader = new FileReader();
                reader.onload = function()
                {
                    var output = document.getElementById('profile');
                    output.src = reader.result;
                };
                reader.readAsDataURL(event.target.files[0]);
                file = event.target.files[0];
                send();
            }
        };
   
function send()
{
    request = 5;
    block = 0;
    file_data = $('#uploader').prop('files')[0];  
    form_data = new FormData();    
    form_data.append('file', file_data);
    if (block==0) 
    {
        $.ajax
        ({
            url: '/SWC/user/upload_pic', // point to server-side PHP script
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            beforeSend:function()
            {
                block = 1;
                console.log("sending");
            },
            success: function(data)
            {
                alert(data);
                block = 0;
                console.log("uploaded");
            }
        });
    }
}