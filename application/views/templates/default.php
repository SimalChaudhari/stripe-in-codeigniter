<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <?php
        $this->load->view('templates/header');
        ?>
        <script type="text/javascript">
            //-- Set common javascript vairable
            var site_url = "<?php echo site_url() ?>";
            var base_url = "<?php echo base_url() ?>";
        </script>
        <noscript>
        <META HTTP-EQUIV="Refresh" CONTENT="0;URL=js_disabled">
        </noscript>    
    </head>
    <body>
    <div class="mail_coliv col-12">
        <div class="row">
            <div class="col-md-2 p-0 m-0 mobile_menu-set">
                <div class="left_coliv">
                    <div class="person_id">
                        <div class="imag_oner">
                            <i class="fa fa-list-ul" aria-hidden="true"></i>
                            <a href="<?php echo base_url('/home'); ?>"><p>Dashboard</p></a>
                        </div>
                    </div>
                    <div class="list_left">
                        <ul>
                            <li <?php echo ($this->controller == 'stats') ? 'active' : ''; ?>><a href="<?php echo base_url('/stats'); ?>"><i class="fa fa-bar-chart" aria-hidden="true"></i> <span>Stats</span></a></li>
                            <li><a href="#"><i class="fa fa-users" aria-hidden="true"></i> <span>Visitors</span></a></li>
                            <li><a href="#"><i class="fa fa-television" aria-hidden="true"></i> <span>Heatmaps</span></a></li>
                            <li><a href="#"><i class="fa fa-cog" aria-hidden="true"></i> <span>Settings</span></a></li>
                            <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i> <span>demo</span></a></li>
                        </ul>
                    </div>
                    <div class="logo_icon">
                      <div class="bug">
                        <i class="fa fa-bug" aria-hidden="true"></i>
                        <p class="report">Report a bug or suggest a feature</p>
                      </div>
                      <p class="language">language</p>
                      <div class="set_select">
                         <select name="" id="">
                          <option value="">English</option>
                          <option value="">English</option>
                        </select>
                        <a href="index.html"><img src="images/logo-small.f004a518.png" class="img-fluid" alt=""></a>
                      </div>
                    </div>
                </div>
            </div>
            
           <?php echo $body;?>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
    <script>
        $(document).ready(function(){
          $(".col-12.search_box.p-0 i.fa.fa-bars").click(function(){
            $(".mobile_menu-set").addClass("open_menu");
          });
        });
    </script>
    
</body>
</html>

</html>
