<!DOCTYPE html>

<html lang="en">

    <head>

	<meta charset="UTF-8" />

        <meta http-equiv="Content-language" content="vi" />

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 

	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 

        <title><?php if(isset($title)){echo $title;}else{echo __('IP_DEFAULT_TITLE');} ?></title>

        <meta name="description" content="" />

        <meta name="keywords" content="" />

        <meta name="author" content="" />

        <link rel="icon" href="<?php echo base_url(); ?>images/favicon.png" type="image/x-icon">

        <link rel="shortcut icon" href="<?php echo base_url(); ?>images/favicon.png" type="image/x-icon">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>frontend/css/signin.css">

        <script type="text/javascript" src="<?php echo base_url(); ?>frontend/js/modernizr.custom.63321.js"></script>

        <!--[if lte IE 7]><style>.main{display:none;} .support-note .note-ie{display:block;}</style><![endif]-->
        

    </head>

    <body>

        <div class="container">

            <section class="main">

                <?php echo $this->load->view('auth/signin_form'); ?>

            </section>

        </div>

        <!-- jQuery if needed -->

        <script type="text/javascript" src="<?php echo base_url(); ?>frontend/js/jquery-1.8.2.min.js"></script>

        <script type="text/javascript">

            $(function(){

                $(".showpassword").each(function(index,input) {

                    var $input = $(input);

                    $("<p class='opt'/>").append(

                        $("<input type='checkbox' class='showpasswordcheckbox' id='showPassword' />").click(function() {

                            var change = $(this).is(":checked") ? "text" : "password";

                            var rep = $("<input placeholder='Password' type='" + change + "' />")

                                .attr("id", $input.attr("id"))

                                .attr("name", $input.attr("name"))

                                .attr('class', $input.attr('class'))

                                .val($input.val())

                                .insertBefore($input);

                            $input.remove();

                            $input = rep;

                         })

                    ).append($("<label for='showPassword'/>").text("Show password")).insertAfter($input.parent());

                });



                $('#showPassword').click(function(){

                    if($("#showPassword").is(":checked")) {

                        $('.icon-lock').addClass('icon-unlock');

                        $('.icon-unlock').removeClass('icon-lock');    

                    } else {

                        $('.icon-unlock').addClass('icon-lock');

                        $('.icon-lock').removeClass('icon-unlock');

                    }

                });

            });

        </script>

    </body>

</html>