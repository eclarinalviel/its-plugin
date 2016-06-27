<?php
//include_once DIR_CLASS . 'meta.php';
$parent = get_category_by_slug( ITS_CATEGORY_SLUG )->term_id;
$categories = get_categories(
    array(
        'hide_empty' => 0,
        'parent' => $parent
        )
);
//var_dump($categories);
$user_login = wp_get_current_user();
?>
<div class="wrap">

    <h2>List of Issues</h2>

    <div class="forum-list">

        <form action="?" method="POST">
            <input type="hidden" name="do" value="post_create">
            <input type="hidden" name="on_error" value="alert_and_go_back">
            <input type="hidden" name="return_url" value="<?php echo urlencode( url_admin_page() )?>">

            <div class="forum-list container">
                <div class="col-lg-8">
                    <div class="col-lg-8">
                        <label for="issue_title">Title: </label>
                        <input type="text" class="form-control" name="issue_title" id="issue_title" placeholder="Title">
                    </div>
                    <div class="col-lg-8">
                        <label for="issue_description">Description: </label>
                        <textarea class="form-control" rows="10" name="issue_description" id="issue_description"></textarea>
                    </div>

                    <div class="col-lg-8">
<!--                        <select id="author" class="col-lg-12 c-select">-->
<!--                            <option selected disabled> Author </option>-->
<!--                        </select>-->
                        <label for="issue_author">Author: </label>
                        <input type="text" class="form-control" name="issue_author" id="issue_author" value="<?php echo $user_login->user_login; ?>" readonly>
                    </div>

                    <div class="col-lg-8 pull-lg-right">
                        <input type="submit" value="Submit New Issue" class="btn btn-danger">
                    </div>

                </div>

                <div class="col-lg-4 container">
                    <div class="panel panel-default">
                        <div class="panel-heading"></div>
                        <div class="panel-body">
                            <label for="label"> Issue Type: </label>

                                <select id = "label" class="col-lg-12 c-select" name = "issue_label">
                                    <?php foreach($categories as $cat) { ?>
                                    <option value="<?php echo $cat->cat_name;  ?>">
                                        <?php echo $cat->cat_name; ?>
                                    </option >
                                    <?php } ?>
                            </select >
                        </div>
                    </div>

                    <div class="">
                        <label for="milestone"> Deadline: </label>
                        <input type="date" class="form-control" name="issue_deadline">
                    </div>

                    <div class="">
                        <label for="assignee"> Assignees: </label>
                        <select id="assignee" class="col-lg-12 c-select" name="issue_assignee">
                            <option selected disabled> Assignee </option>
                        </select>
                    </div>

                    <div class="">
                        <label for="status"> Status: </label>
                        <select id="status" class="col-lg-12 c-select" name="issue_status">
                            <option selected disabled> Status </option>
                            <option value="open">Open</option>
                            <option value="close">Close</option>
                        </select>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
