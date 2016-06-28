<?php
$categories = post()->getCategories();
$user_login = wp_get_current_user();
$users = post()->getUsers();
//var_dump($users);
?>
<div class="wrap">

    <h2>Add New Issue</h2>

    <div class="forum-list">

        <form action="?" method="POST">
            <input type="hidden" name="do" value="post_create">
            <input type="hidden" name="on_error" value="alert_and_go_back">
            <input type="hidden" name="return_url" value="<?php echo issues()->viewURL($id)?>">

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
                            <label> Labels: </label>
                            <div class="input-group-btn">
                                <button tabindex="-1" class="btn btn-secondary" type="button">Issue Type:</button>
                                <button tabindex="-1" data-toggle="dropdown" class="btn btn-secondary dropdown-toggle" type="button">
                                    <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu">
                                    <?php foreach($categories as $cat) { ?>
                                        <a class="dropdown-item" href="#">
                                            <input type="checkbox" value="<?php echo $cat->cat_name;  ?>" name="issue_label[]">
                                            <?php echo $cat->cat_name;  ?>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>

<!--                                <select id = "label" class="col-lg-12 c-select" name = "issue_label">-->
<!--                                    --><?php //foreach($categories as $cat) { ?>
<!--                                    <option value="--><?php //echo $cat->cat_name;  ?><!--">-->
<!--                                        --><?php //echo $cat->cat_name; ?>
<!--                                    </option >-->
<!--                                    --><?php //} ?>
<!--                                </select >-->


                    <div class="">
                        <label for="milestone"> Deadline: </label>
                        <input type="date" class="form-control" name="issue_deadline">
                    </div>

                    <div class="">
                        <label> Assignees: </label>
                        <div class="input-group-btn">
                            <button tabindex="-1" class="btn btn-secondary" type="button">Assign to:</button>
                            <button tabindex="-1" data-toggle="dropdown" class="btn btn-secondary dropdown-toggle" type="button">
                                <span class="caret"></span>
                            </button>
                            <div class="dropdown-menu">
                                <?php foreach($users as $user){ ?>
                                <a class="dropdown-item" href="#">
                                    <input type="checkbox" value="<?php echo $user->user_login; ?>" name="issue_assignee[]">
                                    <?php echo $user->user_login; ?>
                                </a>
                                <?php } ?>
                            </div>
                        </div>

                    </div>

                    <div class="">
                        <label for="status"> Status: </label>
                        <select id="status" class="col-lg-12 c-select" name="issue_status">
                            <option value="open">Open</option>
                            <option value="close">Close</option>
                        </select>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
