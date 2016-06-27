<?php $posts = issues()->getPostsId(); ?>
<div class="wrap">

    <h2>Issues</h2>

    <div class="forum-list">
        <div class="col-lg-6 input-group">
            <div class="input-group-btn">
                <button type="button" class="btn btn-secondary">Action</button>
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Filters: </a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                    <div role="separator" class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Separated link</a>
                </div>
            </div>
            <input type="text" class="form-control" aria-label="Text input with segmented button dropdown">
        </div>
        <div class="col-lg-6">
            <input type="submit" class="btn btn-danger" value="Search!">
        </div>


        <?php if ( $posts ) {
            for($i = 0; $i < count($posts); $i++) {

                foreach ($posts[$i] as $key => $id) {
                    ?>
                    <div class="col-lg-4">
                        <div class="card text-xs-center">
                            <div class="card-block">
                                <h4 class="card-title"><?php echo issues()->meta($id, 'issue_title'); ?></h4>
                                <p class="card-text">
                                    Label: <?php
                                    $cat = issues()->meta($id, 'issue_label');
                                    echo $cat; ?><br/>
                                    Assigned to: <?php echo issues()->meta($id, 'issue_assignee'); ?><br/>
                                    Deadine: <?php echo issues()->meta($id, 'issue_deadline'); ?><br/>
                                    Status: <?php echo issues()->meta($id, 'issue_status') ?><br/>
                                    Posted by: <?php echo issues()->meta($id, 'issue_author'); ?><br/>
                                </p>

<!--                                <form action="--><?php //echo issues()->doURL('issue_view')?><!--" method="post">-->
                                    <input type="hidden" name="do" value="view_issue">
<!--                                    <input type="hidden" name="id" value="--><?php //echo $id; ?><!--">-->
<!--                                    <input type="hidden" name="on_error" value="alert_and_go_back">-->
<!--                                    <input type="hidden" name="return_url" value="--><?php //echo urlencode( url_issue_page() )?><!--">-->
<!--                                    <input type="submit" value="View Issue" class="btn btn-primary">-->
                                <a href="<?php echo issues()->listURL($id)?>" target="_blank" class="btn btn-primary"> View Issue </a>
                                </form>
                            </div>
                            <div class="card-footer text-muted">
                                <?php
                                $post_date = get_the_time('Y-m-d',$id);
                                $deadline = issues()->meta($id, 'issue_deadline');

                                $now = date("Y-m-d");
                                $end = date($deadline);
                                $date_percentage= date_diff( new DateTime($post_date), new DateTime($end) );
                                $date_percentage_new = date_diff( new DateTime($now), new DateTime($end) );
                                //                                var_dump(($date_percentage->d / $date_percentage_new->d)*100);
                                ?>
                                <progress class="progress" value="<?php  ?>" max="100">0%</progress>
                            </div>
                        </div>
                    </div>


                <?php }
                }
            }
        ?>


    </div>
</div>

