<?php
$categories = post()->getCategories();
//var_dump($categories);

/*Custom CSS*/
wp_enqueue_style( 'issue-view', URL_ITS . 'css/issue-view.css' )
?>
<div class="wrap">

    <h2>Labels</h2>

    <form action="?" method="POST">
        <input type="hidden" name="do" value="label_create">
        <input type="hidden" name="on_error" value="alert_and_go_back">
        <input type="hidden" name="return_url" value="<?php echo urlencode( url_category_page() )?>">
        <div class="forum-list">

            <div class="col-lg-12">
                <div class="col-lg-6 padding-top">
                    <div class="input-group">
<!--                        value="<?php //echo meta()->new_label()?>"-->
                        <input type="text" class="form-control" placeholder="Add Labels..." name="new_label">
                          <span class="input-group-btn">
                            <input type="submit" class="btn btn-secondary" value="Go!">
                          </span>
                    </div>
                </div>

                <div class="col-lg-12 padding-top">
                    <div class="col-xs-12 col-sm-6 col-lg-6 "><b>Label Name:</b></div>
                    <div class="col-xs-12 col-sm-6 col-lg-6"><b>Action:</b></div>
                </div>

                <?php foreach($categories as $cat) { ?>

                <div class="col-lg-12 label-list padding-top">
                    <div class="col-xs-12 col-sm-6 col-lg-6 text-center" title=""><?php echo $cat->cat_name;  ?></div>
                    <div class="col-xs-12 col-sm-6 col-lg-6 text-center">
                        <input type="submit" value="Edit" class="btn btn-success">
                        <input type="submit" value="Delete" class="btn btn-danger">
                    </div>
                </div>
                <?php } ?>

            </div>
        </div>
    </form>
</div>
