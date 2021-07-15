<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section id="register">
<div class="container register">
                <div class="row">
                    <div class="col-md-12 register-right">
                   
                            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                              <li class="nav-item btn-dashboard">  
                                 <a href="<?php echo base_url().'dashboard' ?>" class="btn-dashboard">Dashboard</a>
                                </li>
                            </ul>
                         

                    
                        
                        <div class="tab-content" id="myTabContent"> 
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <h3 class="register-heading">Edit User</h3>
                                <?php 
                                    $subscriptions = explode(',', $userdetails->user_subscription);
                                    $attributes = array('class' => 'update-user-form',  'data-action' => base_url().'users/update-user');
                                    echo form_open('', $attributes);
                                ?>
                                <div class="row register-form">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control an-required first-name" name="first_name" placeholder="First Name *" value="<?= $userdetails->user_first_name ?>" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control an-required last-name AS-char" name="last_name" placeholder="Last Name *" value="<?= $userdetails->user_last_name ?>" />
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control an-password" name="password" placeholder="Password *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control an-confirm-password"  placeholder="Confirm Password *" value="" />
                                        </div>
                                        <div class="form-group subscription-group">
                                            <label>Subscription For *</label>
                                            <div class="maxl subscription-group-label">
                                                <label class="checkbox inline"> 
                                                    <input type="checkbox" name="subscription[]" class="subscription" value="story" <?php if(in_array('story', $subscriptions)){echo 'checked';} ?>>
                                                    <span> Story </span> 
                                                </label>
                                                <label class="checkbox inline"> 
                                                    <input type="checkbox" name="subscription[]" class="subscription" value="comment" <?php if(in_array('comment', $subscriptions)){echo 'checked';} ?>>
                                                    <span>Comment </span> 
                                                </label>
                                                <label class="checkbox inline"> 
                                                    <input type="checkbox" name="subscription[]" class="subscription" value="poll" <?php if(in_array('poll', $subscriptions)){echo 'checked';} ?>>
                                                    <span>Poll </span> 
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control an-required an-email" name="email" placeholder="Your Email *" value="<?= $userdetails->user_email ?>" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text"  name="phone" class="form-control an-uk-phone an-required" placeholder="Your Phone *" value="<?= $userdetails->user_phone ?>" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="dob" class="form-control dob-datepicker an-required datepicker an-date" autocomplete="off" placeholder="Date of Birth *" value="<?= $userdetails->user_dob ?>" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" readonly placeholder="Country" value="Country - UK" />
                                        </div>
                                        <input type="hidden" name="user_id" class="user-id" value="<?= $userdetails->user_id ?>"/>
                                        <button type="submit" class="btnRegister btn-ajax-form-btn">Update</button>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="an-form-submit-message hide">
                                             
                                         </div>    
                                     </div>      
                                </div>

                              </form>

                            </div>
                            
                        </div>
                    </div>
                </div>

            </div>

</section>

