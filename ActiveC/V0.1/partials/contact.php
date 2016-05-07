<!-- Page Content -->

<div class="container">

    <div class="row">

        <div class="col-sm-8">
            <h3>Let's Get In Touch!</h3>

            <p>We are a group of students, and this product is a project that we made for madeinJlm.
                To contact us you can either use the git system or our ActiveC e-mail.
                Our private e-mails are provided but not for technical support.</p>

            <form role="form" method="POST" action="#" onsubmit="sub_contact(document.getElementById("input1") ,document.getElementById("input2"),document.getElementById("input3"),document.getElementById("input4") )" >
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="input1">Name</label>
                        <input type="text" name="contact_name" class="form-control" id="input1">
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="input2">Email Address</label>
                        <input type="email" name="contact_email" class="form-control" id="input2">
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="input3">Phone Number</label>
                        <input type="phone" name="contact_phone" class="form-control" id="input3">
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-lg-12">
                        <label for="input4">Message</label>
                        <textarea name="contact_message" class="form-control" rows="6" id="input4"></textarea>
                    </div>
                    <div class="form-group col-lg-12">
                        <input type="hidden" name="save" value="contact">
                        <button type="submit" class="btn btn-primary" >Submit</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-sm-4">
            <h3>ActiveC</h3>
            <p>
                Yefe Nof st.<br>
                Jerusalem, Israel<br>
            </p>

            <p><i class="fa fa-phone"></i> <abbr title="Phone">P</abbr>: (972) 548044784</p>

            <p><i class="fa fa-envelope-o"></i> <abbr title="Email">E</abbr>: <a
                    href="mailto:ActiveC.madejlm@gmail.com">ActiveC.madejlm@gmail.com</a></p>

            <p><i class="fa fa-clock-o"></i> <abbr title="Hours">H</abbr>: 24/7</p>
            <ul class="list-unstyled list-inline list-social-icons">
                <li class="tooltip-social facebook-link"><a href="https://www.facebook.com/MadeinJLM/?pnref=lhc&__mref=message_bubble" data-toggle="tooltip"
                                                            data-placement="top" title="Facebook"><i
                        class="fa fa-facebook-square fa-2x"></i></a></li>
                <li class="tooltip-social twitter-link"><a href="https://twitter.com/MadeinJLM" data-toggle="tooltip"
                                                           data-placement="top" title="Twitter"><i
                        class="fa fa-twitter-square fa-2x"></i></a></li>
                <li class="tooltip-social google-plus-link"><a href="https://plus.google.com/+MadeinjlmOrg1" data-toggle="tooltip"
                                                               data-placement="top" title="Google+"><i
                        class="fa fa-google-plus-square fa-2x"></i></a></li>
            </ul>
        </div>

    </div>
    <!-- /.row -->

</div><!-- /.container -->