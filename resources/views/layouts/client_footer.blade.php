<section class="section_scroll no_hgt">

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="footer_nav">
                    <ul>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Privacy</a></li>
                        <li><a href="#">Guidelines</a></li>
                        <li><a href="#">Help</a></li>
                        <li><a href="#">Team</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>

                <div class="footer_copyright_div">
                    <div class="footer_lgog">
                        <a href="#"><img src="images/footer_logo.png"></a>
                        <p>Copyright © 2010-2017 Google, Inc</p>
                    </div>
							<span class="F_Select_language">
								<select>
									<option>English</option>
									<option>French</option>
									<option>Spanish</option>
								</select>
								<i class="fa fa-chevron-down" aria-hidden="true"></i>
							</span>
                    <div class="F_social_icons">
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
    </section>

<!-- Trigger the modal with a button -->

<!-- Modal -->
<div id="myModal" class="modal fade form_column" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <h2>Sign Up</h2>
            <form class="form-block" action="">
                <div class="form-group">
                    <label for="name">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="name">
                </div>
                <div class="form-group">
                    <label for="name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="new_pwd">New Password</label>
                    <input type="password" class="form-control" id="new_pwd" name="pwd">
                </div>
                <div class="form-group">
                    <label for="confirm_pwd">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_pwd" name="pwd">
                </div>
                <div class="form-group">
                    <label for="confirm_pwd">Captcha Code</label>
                    <span class="captcha_img"><img src="{{ asset('images/captcha.png') }}"></span>
                    <input type="text" class="form-control" id="captcha_code" name="code">
                </div>
                <div class="form-group">
                    <label></label>
			      <span class="term_txt">
				      <div class="squaredOne">
							 <input type="checkbox" value="None" id="squaredOne" name="check" />
							 <label for="squaredOne"></label>
					  </div>
					  I agree to the terms & conditions.
				 </span>
                </div>
                <div class="form-group">
                    <label></label>
                    <button type="submit" class="reg_btn">Register</button>
                </div>
                <div class="form-group">
                    <label></label>
                    <p>If you are already registered? Click here to <a href="#">Login</a></p>
                </div>

            </form>
        </div>
    </div>
</div>