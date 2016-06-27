<?php
include_once DIR_CLASS . 'meta.php';
//count categories under parent
?>
<div class="wrap">

    <h2>Issues</h2>

    <form action="?" method="POST">
        <input type="hidden" name="do" value="label_create">
        <input type="hidden" name="on_error" value="alert_and_go_back">
        <input type="hidden" name="return_url" value="<?php echo urlencode( url_admin_page() )?>">
        <div class="forum-list">

            <div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Add Labels..." name="new_label" value="<?php echo meta()->new_label()?>">
                          <span class="input-group-btn">
                            <input type="submit" class="btn btn-secondary" value="Go!">
                          </span>
                    </div>
                </div>

                <div class="col-lg-12 row header">
                    <div class="col-xs-12 col-sm-6 col-lg-6 ">Label Name:</div>
                    <div class="col-xs-12 col-sm-6 col-lg-6">Action:</div>
                </div>

                <div class="col-lg-12 row post" data-post-id="<?php the_ID()?>">
                    <div class="col-xs-12 col-sm-6 col-lg-6 text-center" title="">Sample Label</div>
                    <div class="col-xs-12 col-sm-6 col-lg-6 text-center">
                        <input type="submit" value="Edit" class="btn btn-success">
                        <input type="submit" value="Delete" class="btn btn-danger">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
