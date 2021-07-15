<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section id="register">
<div class="container register">
                <div class="row">
                    <div class="col-md-12 register-right">
                       
                            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                              <li class="nav-item btn-dashboard">  
                                 <a href="<?php echo base_url().'logout' ?>" class="btn-dashboard">Logout</a>
                                </li>
                            </ul>

                            <div class="users-list">
                        <div class="an-list-items">
                            <div class="card">
                                    <div class="card-header card-header-primary">
                                    <h4 class="card-title ">Users List</h4>
                                    </div>
                                    <div class="card-body">
                                    <?= $listItems ?>
                                    </div>
                                </div>
</div>

<div class='an-list-footer'>
 <div class="an-list-pagination">
    <?= $pagination ?>
</div>
</div> 
                            </div>
                       
                    </div>
                </div>

            </div>

</section>

