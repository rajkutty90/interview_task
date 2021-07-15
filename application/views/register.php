<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section id="register">
<div class="container register">
                <div class="row">
                    <div class="col-md-3 register-left">
                        <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
                        <h3>Welcome</h3>
                    </div>
                    <div class="col-md-9 register-right">
                    <?php if(!$login){ ?>
                        <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Register</a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Login</a>
                            </li>
                            
                        </ul>
                        <?php }else{
                           ?>
                            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                              <li class="nav-item btn-dashboard">  
                                 <a href="<?php echo base_url().'dashboard' ?>" class="btn-dashboard">Dashboard</a>
                                </li>
                            </ul>
                          <?php

                        } ?>
                        
                        <div class="tab-content" id="myTabContent"> 
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <h3 class="register-heading">Register</h3>
                                <?php 
                                    $attributes = array('class' => 'registration-form',  'data-action' => base_url().'register/register-user');
                                    echo form_open('', $attributes);
                                ?>
                                <div class="row register-form">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control an-required first-name" name="first_name" placeholder="First Name *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control an-required last-name AS-char" name="last_name" placeholder="Last Name *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control an-required an-password" name="password" placeholder="Password *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control an-required an-confirm-password"  placeholder="Confirm Password *" value="" />
                                        </div>
                                        <div class="form-group subscription-group">
                                            <label>Subscription For *</label>
                                            <div class="maxl subscription-group-label">
                                                <label class="checkbox inline"> 
                                                    <input type="checkbox" name="subscription[]" class="subscription" value="story">
                                                    <span> Story </span> 
                                                </label>
                                                <label class="checkbox inline"> 
                                                    <input type="checkbox" name="subscription[]" class="subscription" value="comment">
                                                    <span>Comment </span> 
                                                </label>
                                                <label class="checkbox inline"> 
                                                    <input type="checkbox" name="subscription[]" class="subscription" value="poll">
                                                    <span>Poll </span> 
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control an-required an-email" name="email" placeholder="Your Email *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text"  name="phone" class="form-control an-uk-phone an-required" placeholder="Your Phone *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="dob" class="form-control dob-datepicker an-required datepicker an-date" autocomplete="off" placeholder="Date of Birth *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" readonly placeholder="Country" value="Country - UK" />
                                        </div>
                                        <div class="form-group">
                                            <div class="captcha-image-wrap">
                                                <?= $captcha['image'] ?>
                                            </div>    
                                            <input type="text" class="form-control an-required an-captcha" name="captcha"  placeholder="Enter Captcha" value="" />
                                        </div>
                                        <button type="submit" class="btnRegister btn-ajax-form-btn">Register</button>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="an-form-submit-message hide">
                                             
                                         </div>    
                                     </div>      
                                </div>

                              </form>

                            </div>
                            <?php if(!$login){ ?>
                            <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <h3  class="register-heading">Login</h3>
                                <?php 
                                    $attributes = array('class' => 'login-form',  'data-action' => base_url().'register/login');
                                    echo form_open('', $attributes);
                                ?>
                                <div class="row register-form login-form">
                                  
                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <input type="text"  class="form-control an-required an-email" name="email" placeholder="Email" value="" />
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control an-required an-password" name="password" placeholder="Password" value="" />
                                            </div>
                                            <button type="submit" class="btnRegister btn-ajax-form-btn">Login</button>
                                        </div>
                                </div>
                                <div class="col-md-12">
                                        <div class="an-form-submit-message hide">
                                             
                                         </div>    
                                     </div> 
                              </form>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

            </div>

</section>

