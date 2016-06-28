<?php
$users = post()->getUsers();
//var_dump($users);
?>
<div class="wrap">

    <h2>Issues</h2>


        <div class="forum-list">

            <div class="col-lg-12">
                <form action="?" method="POST">
                    <input type="hidden" name="do" value="members_create">
                    <input type="hidden" name="on_error" value="alert_and_go_back">
<!--                    <input type="hidden" name="return_url" value="--><?php //echo urlencode( url_admin_page() )?><!--">-->

                <div class="col-lg-4">
                    <input type="text" class="form-control" placeholder="Add Member..." name="new_member">
                </div>
                <div class="col-lg-4">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Email Address" name="member_email">
                          <span class="input-group-btn">
                            <input type="submit" class="btn btn-secondary" value="Go!">
                          </span>
                    </div>
                </div>
                </form>
                <div class="col-lg-12 row header">
                    <div class="col-xs-12 col-sm-6 col-lg-6 ">Name:</div>
                    <div class="col-xs-12 col-sm-6 col-lg-6">Action:</div>
                </div>

                <?php foreach ( $users as $user ) { ?>
                <div class="col-lg-12 row post" >
                    <div class="col-xs-12 col-sm-6 col-lg-6 text-center" title=""><?php echo $user->user_login ?></div>
                    <div class="col-xs-12 col-sm-6 col-lg-6 text-center">
                        <input type="submit" value="Edit" class="btn btn-success">
                        <input type="submit" value="Delete" class="btn btn-danger">
                    </div>
                </div>
                <?php } ?>

            </div>
        </div>
</div>
