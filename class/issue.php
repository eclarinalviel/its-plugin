<?php
/**
 * Class ITS
 *
 * @file issue.php
 *
 *
 *
 */
class issues {

    static $entity;

    public function __construct()
    {

    }

    /**
     * Returns ITS category.
     *
     * @todo unit test
     */


    public function doURL($method)
    {
        return home_url("?do=$method");
    }


    public function submit()
    {
        $what = in('do');
        if ( empty($what) ) {
            $error = "<h2>method name is empty</h2>";
            wp_send_json_error([ 'code' => -4443, 'message' => $error ]);
        }
        else {
            $do_list = [
                'post_create',
                'post_edit',
                'post_delete',
                'label_create',
                'label_edit',
                'label_delete',
                'view_issue'
//                'milestone_create',
//                'milestone_edit',
//                'milestone_delete',
            ];
            if ( in_array( $what, $do_list ) ) {
                $this->$what();     /// @Attention all the function here must end with wp_send_json_success/error()
                wp_redirect( in('return_url') );
            }
            else {
                $error = "You cannot call the method - '$what' because the method is not listed on 'do-list'.";
                ferror( -4444, $error );
            }
        }
        exit; // no effect...
    }


    /**
     * @return mixed
     * @todo unit test on db insert error
     */
    private function post_create()
    {
        if ( ! in('issue_title') ) ferror(-50014, 'Title is not provided');
        if ( ! in('issue_description') ) ferror(-50015, 'Description is not provided');
        $category = get_cat_ID( in('issue_label') );
        $args = array(
            'post_title' => in('issue_title'),
            'post_content' =>in('issue_description'),
            'post_status' => 'publish',
            'post_category' =>  [$category], //categories should be array,
            'post_author', get_current_user_id(),
        );

        $post_ID = wp_insert_post( $args, true );
        $this->meta($post_ID, 'issue_title', in('issue_title'));
        $this->meta($post_ID, 'issue_description', in('issue_description'));
        $this->meta($post_ID, 'issue_label', in('issue_label'));
        $this->meta($post_ID, 'issue_status', in('issue_status'));
        $this->meta($post_ID, 'issue_deadline', in('issue_deadline')); //deadline
        $this->meta($post_ID, 'issue_assignee', in('issue_assignee'));
        $this->meta($post_ID, 'issue_author', in('issue_author'));

        if ( is_wp_error( $post_ID ) ) {
            return $post_ID->get_error_message();
        }
        else if ( $post_ID  == 0 ) {
            return "wp_insert_post() returned 0. Post data may be empty.";
        }

//        $this->meta( $post_ID, 'template', in('template') );
//        $this->url_redirect();

//        wp_send_json_success();

        return $post_ID;
    }

    /*
     * Add / Returns Post Meta
     * */
    public function meta($post_ID, $key, $value = null)
    {
        if ( $value ) {
//            delete_term_meta( $post_ID, $key );
            add_post_meta( $post_ID, $key, $value, true );
            return null;
        }
        else {
            return get_post_meta($post_ID, $key, true);
        }

    }
    /*
     * @todo Unit testing; if lowercase, not empty, true
     * */
    private function label_create() {
        issues()->parent_category();
        if ( ! in('new_label') ) ferror(-50077, 'Label Name is not provided');
        $catarr = array(
            'cat_name' =>in('new_label'),
            'category_nicename' => in('new_label'),
            'category_parent' => get_category_by_slug( ITS_CATEGORY_SLUG )->term_id
        );

        $term_ID = $this->createOrUpdateCategory( $catarr );

        if ( is_wp_error( $term_ID ) ) {
            wp_send_json_error( ['code'=>-4100, 'message'=>$term_ID->get_error_message()] );
        }

//        $this->meta( $term_ID, 'template', in('template') );
//        $this->url_redirect();

//        wp_send_json_success();
    }



    private function parent_category() {

        $category = get_category_by_slug(ITS_CATEGORY_SLUG);

        if ( ! $category ) { // is category exists
            if ( ! function_exists('wp_insert_category') ){
                require_once( ABSPATH . "/wp-admin/includes/taxonomy.php" );
            }
            $catarr = array(
                'cat_name' => ITS_CATEGORY_SLUG,
                'category_description' => 'This is Issue Tracker.',
                'category_nicename' => ITS_CATEGORY_SLUG,
            );
            $ID = wp_insert_category($catarr, true);
            if ( is_wp_error($ID) ) wp_die( $ID->get_error_message() );

        }
        return $ID;
    }

    private function createOrUpdateCategory( $catarr ) {
        if ( ! function_exists('wp_insert_category') ) require_once (ABSPATH . "/wp-admin/includes/taxonomy.php");
        return wp_insert_category( $catarr, true );
    }

    /**
 * get ID of posts & post meta of child category under parents category
 */
    public function getPostsId()
    {
        $the_post = array();
        $parent = get_category_by_slug( ITS_CATEGORY_SLUG )->term_id;
        $categories = get_categories(
            array(
                'hide_empty' => 0,
                'parent' => $parent
            )
        );

        foreach($categories as $category){
            $posts[] = get_posts( array(
                'category' => $category->term_id,
                'fields' => 'ids' // to get only post_ids
            ));
        };
        return $posts;
    }

    /**
     * get specific post based on ID
     */
    public function getPost($post_id)
    {
        $the_post = get_post(seg(2));
        return $the_post;

    }
    /*
     * Redirect to issue
     * @todo unit testing is not empty, numeric seg(2) etc.
     * */

    public function view_issue()
    {
//        if ( ! is_numeric(seg(2)) ) ferror(9999, 'Invalid ID.');
//        if ( ! seg(2) ) ferror(9999, 'Post ID is not set..');
        $this->getPost(in('id'));
    }

    /**
     * It redirect current page to the page of $_REQUEST['url_redirect'].
     *
     * @note it does not do anything if $_REQUEST['url_redirect'] is empty.
     *
     */
    private function url_redirect()
    {
        if ( ! function_exists('wp_redirect') ) require_once (ABSPATH . "/wp-includes/pluggable.php");
        wp_redirect( in('return_url') );
    }

    public function listURL($slug)
    {
        return $this->urlIssueList($slug);
    }

    public function urlIssueList($slug)
    {
        return home_url("/issue/view/$slug");
    }

    /**
     * @deprecated - use urlAdminPage()
     *
     */
    public function adminURL()
    {
        return $this->urlAdminPage();
    }

    public function urlAdminPage() {
        return home_url('wp-admin/admin.php?page=issue-tracker-plugin%2Ftemplate%2Fadmin.php');
    }


    private function loadTemplate($file)
    {
        $new_template = locate_template( array( $file ) );
        if ( '' != $new_template ) {
            return $new_template ;
        }
        else {
            return DIR_ITS . "template/$file";
        }
    }


    /*
     * @todo Add more unit tests and criterias? for this.
     * Checks your segment
     * */
    public function addFilters()
    {
        add_filter('template_include', function ($template) {
            // http://abc.com/issue/view/(0-9)/
            if (seg(0) == 'issue' && seg(1) != NULL && is_numeric(seg(2))) {
//               echo "HERE";
                return $this->loadTemplate('issue-view.php');
            }
//
        }, 0.01);

    }
//    public function viewURL()
//    {
//        return $this->urlViewPage();
//    }
//    public function urlViewPage()
//    {
//        return home_url('wp-admin/admin.php?page=issue-tracker-plugin%2Ftemplate%2Fadmin.php&amp;template=issueView');
////        return home_url('wp-admin/admin.php?page=issue-tracker-plugin%2Ftemplate%2Fissue-view.php');
//    }



}


$__issues = null;
/**
 * @note This function caches on memory. so no matter how many times you call this function, it does not produce burden on Process.
 * @return ITS
 */
function issues() {
    global $__issues;
    static $__count_issues = 0;
    $__count_issues ++;
    if ( isset($__issues) ) return $__issues;
    else {
        if ( $__count_issues > 1 ) {
            xlog('Fatal error: ITS object instanticated more than twice.');
//            echo 'Fatal error: ITS object instanticated more than twice.';
            return null;
        }
        else {
            xlog('Creates ITS instance. This should be done only once.');
//            echo 'Creates ITS instance. This should be done only once.';
            $__issues = new issues();
            return $__issues;
        }
    }
}
