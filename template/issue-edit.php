<?php
get_header();

$categories = post()->getCategories();
$post = post()->getPost(seg(2)); // get the issue ID through URL segment
//var_dump($post->ID);
$id = $post->ID;
?>
<div class="wrap">

    <h2>Edit Issue</h2>

    <div class="forum-list">

        <form action="?" method="POST">
            <input type="hidden" name="do" value="post_edit">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="on_error" value="alert_and_go_back">
            <input type="hidden" name="return_url" value="<?php echo issues()->viewURL($id)?>">

            <div class="forum-list container">
                <div class="col-lg-8">
                    <div class="col-lg-8">
                        <label for="issue_title">Title: </label>
                        <input type="text" class="form-control" name="issue_title" id="issue_title" value="<?php echo post()->meta($id, 'issue_title'); ?>">
                    </div>
                    <div class="col-lg-8">
                        <label for="issue_description">Description: </label>
                        <textarea class="form-control" rows="10" name="issue_description" id="issue_description">
                            <?php echo post()->meta($id, 'issue_description'); ?>
                        </textarea>
                    </div>

                    <div class="col-lg-8">
                        <label for="issue_author">Author: </label>
                        <input type="text" class="form-control" name="issue_author" id="issue_author" value="<?php echo post()->meta($id, 'issue_author'); ?>" readonly>
                    </div>

                    <div class="col-lg-8 pull-lg-right">
                        <input type="submit" value="Save Issue" class="btn btn-danger">
                    </div>

                </div>

                <div class="col-lg-4 container">
                    <div class="panel panel-default">
                        <div class="panel-heading"></div>
                        <div class="panel-body">
                            <label for="label"> Issue Type: </label>

                            <select id = "label" class="col-lg-12 c-select" name = "issue_label">
                                <?php $label = post()->meta($id, 'issue_label'); ?>

                                <?php foreach($categories as $cat) { ?>
                                    <option value="<?php echo $cat->cat_name;  ?>" <?php if( $cat->cat_name == $label) echo "selected"; ?> >
                                        <?php echo $cat->cat_name; ?>
                                    </option >
                                <?php } ?>
                            </select >
                        </div>
                    </div>

                    <div class="">
                        <label for="milestone"> Deadline: </label>
                        <input type="date" class="form-control" name="issue_deadline" value="<?php echo post()->meta($id, 'issue_deadline'); ?>">
                    </div>

                    <div class="">
                        <label for="assignee"> Assignees: </label>
                        <select id="assignee" class="col-lg-12 c-select" name="issue_assignee" value="<?php echo post()->meta($id, 'issue_assignee'); ?>">
                            <option selected disabled> Assignee </option>
                        </select>
                    </div>

                    <div class="">
                        <label for="status"> Status: </label>
                        <?php $status = post()->meta($id, 'issue_status'); ?>
                        <select id="status" class="col-lg-12 c-select" name="issue_status">
                            <option selected disabled> Status </option>
                            <option value="open" <?php if($status == "open") echo "selected"; ?>>Open</option>
                            <option value="close" <?php if($status == "close") echo "selected"; ?>>Close</option>
                        </select>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
<?php get_footer(); ?>