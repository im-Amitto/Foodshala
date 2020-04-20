<footer id='footer'>
    <!-- Start footer top area -->
    <div class='footer_top'>
        <div class='container'>
            <div class='row'>
                <div class='col-ld-4  col-md-4 col-sm-4'>
                    <div class='single_footer_widget'>
                        <h3>About Us</h3>
                        <p>A Food Corner</p>
                    </div>
                </div>
                <div class='col-ld-4  col-md-4 col-sm-4'>
                    <div class='single_footer_widget'>
                        <h3>External Links</h3>
                        <ul class='footer_widget_nav list-unstyled'>
                            Some Links

                        </ul>
                    </div>
                </div>
                <div class='col-ld-4  col-md-4 col-sm-4'>
                    <div class='single_footer_widget'>
                    
                        <h3>Contact Us</h3>
                  
                <p>
                Address Line 1<br/>
                Address Line 2<br/>
                    Phone: +919876543210<br /> 
                    Email: <a href="mailto:amitmeena094@gmail.com">amitmeena094@gmail.com</a><br />
                </p>   </div>
                </div>
            </div>
            <hr>
            <div class='row'>
                <div class='single_footer_widget'>
                    <h3><center>Stay Connected</center></h3>
                        <div class='tags'>
                            <ul class='footer_social list-unstyled'>
                                <li><a data-toggle='tooltip' data-placement='top' title='Twitter' class='soc_tooltip'  href='#' ><i class='fa fa-twitter'></i></a>
                                </li>
                                <li><a data-toggle='tooltip' data-placement='top' title='Linkedin' class='soc_tooltip'  href='#'><i class='fa fa-linkedin'></i></a></li>
                            </ul>
                    </div>
                </div>
            </div>
        </div>   
    </div>
    <!-- End footer top area -->

    <!-- Start footer bottom area -->
    <div class='footer_bottom'>
        <div class='container'>
            <div class='row'>
                <div class='col-lg-6 col-md-6 col-sm-6'>
                    <div class='footer_bootomLeft'>
                        <p> 2020 &copy; Foodshala, All Rights Reserved.</p>
                    </div>
                </div>
                <div class='col-lg-6 col-md-6 col-sm-6'>
                    <div class='footer_bootomRight'>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End footer bottom area -->
</footer>
<!--===========================JavaScripts================-->
<script src='./js/jquery1.12.js'></script>
<script src='./js/bootstrap.min.js'></script>

<!--============================== Back To Top Js=========================== -->
        <script type='text/javascript'>
            $(window).scroll(function() {
                if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
                    $('#return-to-top').fadeIn(200);    // Fade in the arrow
                } else {
                    $('#return-to-top').fadeOut(200);   // Else fade out the arrow
                }
            });
            $('#return-to-top').click(function() {      // When arrow is clicked
                $('body,html').animate({
                    scrollTop : 0                       // Scroll to top of body
                }, 500);
            });
        </script>
    </body>
</html>
