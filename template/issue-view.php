<?php
get_header();

$post = post()->getPost(seg(2));
$id = get_the_ID();

/*Custom CSS*/
wp_enqueue_style( 'issue-view', URL_ITS . 'css/issue-view.css' );
?>
<div class="">

    <!-- Closing and Editing of Issues should and could only be done by the author of post/issue  -->
    <?php $status = post()->meta($id, 'issue_status'); // Show "Close Issue" button & "Edit" Button only if the status of the issue is OPEN
    if ($status == "open") {?>
    <a href="<?php echo issues()->editURL($id)?>" class="btn btn-success"> Edit </a>
    <form action="?" method="POST">
        <input type="hidden" name="do" value="close_issue">
        <input type="hidden" name="on_error" value="alert_and_go_back">
        <input type="hidden" name="return_url" value="<?php echo issues()->viewURL($id)?>">
        <input type="submit" value="Close Issue" class="btn btn-danger">
    </form>
    <?php } ?>

        <div class="">
            <div class="col-lg-6">
                <div class="col-lg-12 issue-title">
                    <?php echo post()->meta($id, 'issue_title'); ?>
                </div>
                <div class="col-lg-12">
                    <b>Issue ID: <?php  echo $id;?></b>
                </div>
                <div class="col-lg-12">
                    Description:<p> <?php echo post()->meta($id, 'issue_description'); ?> </p>
                </div>
                <div class="col-lg-12">
                    Posted by: <?php echo post()->meta($id, 'issue_author'); ?>
                </div>
                <div class="col-lg-12">
                    Assigned to: <?php echo post()->meta($id, 'issue_assignee'); ?>
                </div>
                <div class="col-lg-12">
                    Deadline: <?php echo post()->meta($id, 'issue_deadline'); ?>
                </div>
                <div class="col-lg-12">
                    Labels: <?php echo post()->meta($id, 'issue_label'); ?>
                </div>
                <div class="col-lg-12 status">
                    Status: <?php echo post()->meta($id, 'issue_status'); ?>
                </div>

            </div>
        <?php comments_template(); ?>

        </div>
    </div>
    <?php get_footer(); ?>
