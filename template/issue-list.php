<?php
/* if search button or "assigned to you" button is clicked, call the search function
 * @todo unit tests
 */
$posts = "";
if($_REQUEST['search'] || in('assigned_to_user')){
   $posts = post()->issue_search();
//    var_dump(count($posts));
}else{
    $posts = post()->getPosts();
}

/*Custom CSS*/
wp_enqueue_style( 'issue-view', URL_ITS . 'css/issue-view.css' );
?>
<div class="wrap">

    <h2>Issues</h2>

        <form action="" method="POST">
            <div class="col-lg-6 input-group">
                <div class="input-group">
                    <div class="input-group-btn">
                        <button tabindex="-1" class="btn btn-secondary" type="button">Search Filters</button>
                        <button tabindex="-1" data-toggle="dropdown" class="btn btn-secondary dropdown-toggle" type="button">
                            <span class="caret"></span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#"> <input type="checkbox" value="issue_title" name="filter[]">Title or Content</a>
                            <a class="dropdown-item" href="#"> <input type="checkbox" value="issue_label" name="filter[]">Labels</a>
                            <a class="dropdown-item" href="#"><input type="checkbox" value="issue_deadline" name="filter[]">Deadline</a>
<!--                            <a class="dropdown-item" name="assigned_to_user">Assigned to you</a>-->
                            <div class="dropdown-divider"></div>
                            <input type="submit" class="btn btn-secondary btn-block" value="Assigned to you" name="assigned_to_user">
                        </div>
                    </div>
                    <input type="text" class="form-control" name="search_field" placeholder="Search by title, author, labels etc.">
                </div>
            </div>
            <div class="col-lg-3">
                <input type="date" class="form-control date" name="deadline" >
            </div>
            <div class="col-lg-2">
                <input type="submit" class="btn btn-danger" value="Search!" name="search">
            </div>
        </form>

        <?php
            if ( $posts ) :
                foreach ($posts as $single_post) : setup_postdata($single_post); ?>
                    <div class="col-lg-4">
                        <div class="card card-block fixed-height">
                            <h4 class="card-title"><?php echo post()->meta($single_post->ID, 'issue_title'); ?></h4>
                            <p class="card-text">
                            <b>Label: </b>
                            <?php $categories = post()->meta($single_post->ID, 'issue_label');
                            foreach($categories as $category){
                                echo $category .", ";
                            }
                            ?><br/>
                            <b>Assigned to:</b> <?php
                            $assignees =  post()->meta($single_post->ID, 'issue_assignee');
                            foreach($assignees as $assignee){
                                echo $assignee .", ";
                            }

                            ?><br/>
                                <b>Deadine:</b> <?php echo post()->meta($single_post->ID, 'issue_deadline'); ?><br/>
                                <b>Status:</b> <?php echo post()->meta($single_post->ID, 'issue_status') ?><br/>
                                <b>Posted by: </b><?php echo post()->meta($single_post->ID, 'issue_author'); ?><br/>
                            </p>

                            <input type="hidden" name="do" value="view_issue">
                            <a href="<?php echo issues()->viewURL($single_post->ID)?>" target="_blank" class="btn btn-primary"> View Issue </a>
                        </div>
                    </div>

                <?php endforeach; ?>
       <?php endif ?>

</div>

