<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<!-- This is a pagination script using Jquery, Ajax and PHP
     The enhancements done in this script pagination with first,last, previous, next buttons -->

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>LASIK Patient Adverse Event Reports to FDA</title>
        <meta name="description" content="Your description">
        <meta name="keywords" content="medwatch fda adverse event patient LASIK">
        <link rel="stylesheet" type="text/css" href="styles/pagination.css" media="screen" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
        <script type="text/javascript">
            $(document).ready(function(){
                function loading_show(){
                    $('#loading').html("<img src='images/loading.gif'/>").fadeIn('fast');
                }
                function loading_hide(){
                    $('#loading').fadeOut('fast');
                }                
                function loadData(page){
                    loading_show();                    
                    $.ajax
                    ({
                        type: "POST",
                        url: "load_data.php",
                        data: "page="+page,
                        success: function(msg)
                        {
                            $("#container").ajaxComplete(function(event, request, settings)
                            {
                                loading_hide();
                                $("#container").html(msg);
                            });
                        }
                    });
                }
                loadData(1);  // For first time page load default results
                $('#container .pagination li.active').live('click',function(){
                    var page = $(this).attr('p');
                    loadData(page);
                    
                });           
                $('#go_btn').live('click',function(){
                    var page = parseInt($('.goto').val());
                    var no_of_pages = parseInt($('.total').attr('a'));
                    if(page != 0 && page <= no_of_pages){
                        loadData(page);
                    }else{
                        alert('Enter a PAGE between 1 and '+no_of_pages);
                        $('.goto').val("").focus();
                        return false;
                    }
                    
                });
            });
        </script>
    </head>
    <body> 
        <!--  <h1 class="heading">LASIK Patient Adverse Event Reports to FDA</h1> -->
        <div id="loading"></div>
        <div id="container">

            <div class="data"></div>
            <div class="pagination"></div>
        </div>
    </body>
</html>
