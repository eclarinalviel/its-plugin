<?php
$posts = post()->getPosts();

?>
<div class="wrap">

    <h2>Issues</h2>

    <div class="forum-list">

        <form action="" method="POST">
<!--            <input type="hidden" name="do" value="issue_search">-->
<!--            <input type="hidden" name="on_error" value="alert_and_go_back">-->
<!--            <input type="hidden" name="return_url" value="--><?php //echo issues()->listURL()?><!--">-->
<!--            <input type="hidden" name="return_url" value="--><?php //echo issues()->urlListPage()?><!--">-->

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

        <?php if ( $posts ) {
//            for($i = 0; $i < count($posts); $i++) {

                foreach ($posts as $single_post) {
                    ?>
                    <div class="col-lg-4">
                        <div class="card text-xs-center">
                            <div class="card-block">
                                <h4 class="card-title"><?php echo post()->meta($single_post->ID, 'issue_title'); ?></h4>
                                <p class="card-text">
                                    Label: <?php
                                    $cat = post()->meta($id, 'issue_label');
                                    echo $cat; ?><br/>
                                    Assigned to: <?php echo post()->meta($single_post->ID, 'issue_assignee'); ?><br/>
                                    Deadine: <?php echo post()->meta($single_post->ID, 'issue_deadline'); ?><br/>
                                    Status: <?php echo post()->meta($single_post->ID, 'issue_status') ?><br/>
                                    Posted by: <?php echo post()->meta($single_post->ID, 'issue_author'); ?><br/>
                                </p>

                                <input type="hidden" name="do" value="view_issue">
                                <a href="<?php echo issues()->viewURL($single_post->ID)?>" target="_blank" class="btn btn-primary"> View Issue </a>
                                </form>
                            </div>
                            <div class="card-footer text-muted">
                                <?php
                                $post_date = get_the_time('Y-m-d',$single_post->ID);
                                $deadline = post()->meta($id, 'issue_deadline');

                                $now = date("Y-m-d");
                                $end = date($deadline);
                                $date_percentage = date_diff( new DateTime($post_date), new DateTime($end) );
                                $date_percentage_new = date_diff( new DateTime($now), new DateTime($end) );
                                $percentage = $date_percentage_new / $date_percentage * 100;
                                $percentageRounded = round($percentage);

                                ?>
                                <progress class="progress progress-striped progress-warning" value="75" max="100">75%</progress>
                                <!--                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="--><?php //echo $percentageRounded; ?><!--"-->
                                <!--                                     aria-valuemin="0" aria-valuemax="100" style="width:--><?php //echo $percentageRounded; ?>
                            </div>
                        </div>
                    </div>

                <?php }
//            }
        } ?>
    </div>

    <?php

    // Previous/next page navigation.
    //    $links = paginate_links( array(
    //        'mid_size'              => 5,
    //        'prev_text'             =>'<<',
    //        'next_text'             => '>>',
    //        'before_page_number'    => '',
    //        'after_page_number'     => '',
    //        'end_size' => 0,
    //        'type' => 'array',
    //    ) );
    //    if ( $links ) {
    //        $r = "<div class='pagination'><ul>\n\t<li>";
    //        $r .= join("</li>\n\t<li>", $links);
    //        $r .= "</li>\n</ul>\n</div>\n";
    //        echo $r;
    //    }


    ?>
</div>

