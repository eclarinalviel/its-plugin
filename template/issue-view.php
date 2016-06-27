<?php
$post = issues()->getPost();
$id = get_the_ID();
//var_dump($post);
//Custom CSS
//wp_enqueue_style( 'issue-view', URL_ITS . 'css/issue-view.css' );
?>
<div class="wrap">

    <h2> <?php echo issues()->meta($id, 'issue_title'); ?></h2>

    <div class="forum-list">


        <div class="row post">
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <h4>Issue ID: <?php  echo $id;?></h4>
                </div>
                <div class="col-lg-12">
                    Description: <?php echo issues()->meta($id, 'issue_description'); ?>
                </div>
                <div class="col-lg-12">
                    Assignees: <?php echo issues()->meta($id, 'issue_assignee'); ?>
                </div>
                <div class="col-lg-12">
                    Deadline: <?php echo issues()->meta($id, 'issue_deadline'); ?>
                </div>
                <div class="col-lg-12">
                    Labels: <?php echo issues()->meta($id, 'issue_label'); ?>
                </div>
                <div class="col-lg-12">
                    <?php comments_template(); ?>
                </div>


            </div>
        </div>


    </div>

