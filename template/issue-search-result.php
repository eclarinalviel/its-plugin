<?php
get_header();
//    $posts = post()->issue_search();
$posts = post()->search_posts();
var_dump($posts);
?>
<div class="wrap">

    <h2>Issues</h2>

    <div class="forum-list">

<!--        <form method="post" action="--><?php //echo home_url( '/issue/list' ); ?><!--">-->
<!--        <form action="?" method="GET">-->
<!--            <input type="hidden" name="do" value="issue_search">-->
<!--            <input type="hidden" name="on_error" value="alert_and_go_back">-->
<!--            <input type="hidden" name="return_url" value="--><?php //echo issues()->listURL()?><!--?>">-->

            <div class="col-lg-8 input-group">
                <div class="input-group">
                    <div class="input-group-btn">
                        <button tabindex="-1" class="btn btn-secondary" type="button">Filters</button>
                        <button tabindex="-1" data-toggle="dropdown" class="btn btn-secondary dropdown-toggle" type="button">
                            <span class="caret"></span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#"> <input type="checkbox" value="title" name="filter[]">Title or Content</a>
                            <a class="dropdown-item" href="#"> <input type="checkbox" value="label" name="filter[]">Labels</a>
                            <a class="dropdown-item" href="#"><input type="checkbox" value="deadline" name="filter[]">Deadline</a>
                            <a class="dropdown-item" href="#"><input type="checkbox" value="assigned" name="filter[]">Assigned to you</a>
                        </div>
                    </div>
                    <input type="text" class="form-control" name="search_field" placeholder="Search by title, content, labels, deadline(e.g. 2016/06/30)">
                </div>
            </div>
            <div class="col-lg-4">
                <input type="submit" class="btn btn-danger" value="Search!">
            </div>
        </form>

        <?php        ?>
                    <div class="col-lg-4">
                        <div class="card text-xs-center">
                            <div class="card-block">
                                <h4 class="card-title"><?php  ?></h4>
                                <p class="card-text">
                                    Label: <?php
                                    $cat = post()->meta($id, 'issue_label');
                                    echo $cat; ?><br/>
                                    Assigned to: <?php  ?><br/>
                                    Deadine: <?php  ?><br/>
                                    Status: <?php  ?><br/>
                                    Posted by: <?php ?><br/>
                                </p>

                                <input type="hidden" name="do" value="view_issue">
                                <a href="<?php echo issues()->viewURL($id)?>" target="_blank" class="btn btn-primary"> View Issue </a>
                                </form>
                            </div>
                            <div class="card-footer text-muted">
                                <?php
                                $post_date = get_the_time('Y-m-d',$id);
                                $deadline = post()->meta($id, 'issue_deadline');

                                $now = date("Y-m-d");
                                $end = date($deadline);
                                $date_percentage = date_diff( new DateTime($post_date), new DateTime($end) );
                                $date_percentage_new = date_diff( new DateTime($now), new DateTime($end) );
                                $percentage = $date_percentage_new / $date_percentage * 100;
                                $percentageRounded = round($percentage);

                                ?>
                                <progress class="progress progress-striped progress-warning" value="75" max="100">75%</progress>
                            </div>
                        </div>
                    </div>

                <?php  ?>
    </div>

</div>
<?php get_footer(); ?>

