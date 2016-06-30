<?php

class post
{

    static $entity;

    public function __construct()
    {

    }

    /**
     * Returns ITS category.
     *
     * @todo unit test
     */

    public function submit()
    {
        $what = in('do');
        if (empty($what)) {
            $error = "<h2>method name is empty</h2>";
            wp_send_json_error(['code' => -4443, 'message' => $error]);
        } else {
            $do_list = [
                'post_create',
                'post_edit',
                'post_delete',
                'label_create',
                'label_edit',
                'label_delete',
                'view_issue',
                'close_issue',
                'issue_search',
//                'members_create',
//                'members_remove',
            ];
            if (in_array($what, $do_list)) {
                $this->$what();     /// @Attention all the function here must end with wp_send_json_success/error()
                wp_redirect(in('return_url'));
            } else {
                $error = "You cannot call the method - '$what' because the method is not listed on 'do-list'.";
                ferror(-4444, $error);
            }
        }
        exit; // no effect...
    }


    /**
     * @return mixed
     * @todo unit test on db insert error, array (assignees), parent category by default
     */
    private function post_create($id = 0, $update = NULL)
    {
        if (!in('issue_title')) ferror(-50014, 'Title is not provided');
        if (!in('issue_description')) ferror(-50015, 'Description is not provided');

        $category = in('issue_label');
        foreach($category as $cat_id){ // get the name of each category
            $cat_name[] = get_cat_name($cat_id);
        }
        $args = array(
            'ID' => $id,
            'post_title' => in('issue_title'),
            'post_content' => in('issue_description'),
            'post_status' => 'publish',
            'post_category' => $category, //categories should be array,
            'post_author', get_current_user_id(),
        );
        $post_ID = wp_insert_post($args, true);
        //if $id is not null - For post update/edit, overwrite the previous post. if not, Create a new post
        if (isset($id) && !empty($id)) {$post_ID = $id;}
        $this->meta($post_ID, 'issue_title', in('issue_title'));
        $this->meta($post_ID, 'issue_description', in('issue_description'));
        $this->meta($post_ID, 'issue_status', in('issue_status'));
        $this->meta($post_ID, 'issue_deadline', in('issue_deadline'));
        $this->meta($post_ID, 'issue_author', in('issue_author'));
//        $this->meta($post_ID, 'issue_label', $cat_name); //saves serialize array on db (multiple values)
//        $this->meta($post_ID,'issue_assignee',in('issue_assignee')); //saves serialize array on db (multiple values)
        foreach( $cat_name as $cat ){
            $this->meta($post_ID, 'issue_label', $cat);
        }
        $assignees = in('issue_assignee');
        foreach( $assignees as $assignee ){
            $this->meta($post_ID, 'issue_assignee', $assignee);
        }

        if (is_wp_error($post_ID)) {
            return $post_ID->get_error_message();
        } else if ($post_ID == 0) {
            return "wp_insert_post() returned 0. Post data may be empty.";
        }

        return $post_ID;
    }

    /*
     * Add / Returns Post Meta
     * */
    public function meta($post_ID, $key, $value = null)
    {
        if ($value) {
            add_post_meta( $post_ID, $key, $value );
            /*  update_post_meta updates the value of existing meta key;
            *   If post_id not exists, it will call the add_post_meta function.
            * */
//            update_post_meta($post_ID, $key, $value);
            return null;
        } else {
            return get_post_meta($post_ID, $key, true);
        }

    }

    /*
     * @todo Unit testing; not empty, true
     * */
    private function label_create()
    {
        $this->parent_category();
        if (!in('new_label')) ferror(-50077, 'Label Name is not provided');
        $catarr = array(
            'cat_name' => in('new_label'),
            'category_nicename' => in('new_label'),
            'category_parent' => get_category_by_slug(ITS_CATEGORY_SLUG)->term_id
        );

        $term_ID = $this->createOrUpdateCategory($catarr);

        if (is_wp_error($term_ID)) {
            wp_send_json_error(['code' => -4100, 'message' => $term_ID->get_error_message()]);
        }

    }


    private function parent_category()
    {

        $category = get_category_by_slug(ITS_CATEGORY_SLUG);

        if (!$category) { // is category exists
            if (!function_exists('wp_insert_category')) {
                require_once(ABSPATH . "/wp-admin/includes/taxonomy.php");
            }
            $catarr = array(
                'cat_name' => ITS_CATEGORY_SLUG,
                'category_description' => 'This is Issue Tracker.',
                'category_nicename' => ITS_CATEGORY_SLUG,
            );
            $ID = wp_insert_category($catarr, true);
            if (is_wp_error($ID)) wp_die($ID->get_error_message());

        }
        return $ID;
    }

    private function createOrUpdateCategory($catarr)
    {
        if (!function_exists('wp_insert_category')) require_once(ABSPATH . "/wp-admin/includes/taxonomy.php");
        return wp_insert_category($catarr, true);
    }

    /**
     * get ID of posts & post meta of child category under parents category
     */
    public function getPosts($args = NULL)
    {
        $categories = $this->getCategories();
        foreach ($categories as $category) {
            $ids[] = $category->term_id;

        };

        if( !isset($args) && empty($args) ){ // If there's no $args passed.
            $args = array(
                'posts_per_page' => 6,
                'category__in' => $ids
            );
        }

        $posts[] = get_posts($args);
        foreach($posts as $post){
            $single_post = $post;
        }

        return $single_post;
    }

    /*
     * Get categories under parent category
     * */

    public function getCategories()
    {
        $parent = get_category_by_slug(ITS_CATEGORY_SLUG);
        $categories = get_categories(
            array(
                'hide_empty' => 0,
                'parent' => $parent->term_id,
            )
        );
        return $categories;
    }
    /*
     * Redirect to issue
     * @todo unit testing is not empty, numeric seg(2) etc.
     * */

    /**
     * @return mixed
     */
    public function getPost($post_id)
    {
        $the_post = get_post(seg(2));
        return $the_post;
    }

    public function view_issue()
    {
//        if ( ! is_numeric(seg(2)) ) ferror(9999, 'Invalid ID.');
//        if ( ! seg(2) ) ferror(9999, 'Post ID is not set..');
        $this->getPost(in('id'));
        //get the post based on post_ID on segment 2 (http://website.com/issue/view/2096)


    }

    /*
     * Edit Issue based on Post ID, Segment 2. (http://website.com/issue/edit/2096)
     *
     * */
    public function post_edit()
    {
        //get the post based on post_ID on segment 2 (http://website.com/issue/view/2096)
//        $this->getPost(in('id'));
        if (!in('id')) ferror(64231, 'Post ID is not set..');
        if (!is_numeric(in('id'))) ferror(64232, 'Invalid Post ID.');
        //delete the existing meta first
        $this->delete_meta(in('id'), 'issue_title' );
        $this->delete_meta(in('id'), 'issue_description' );
        $this->delete_meta(in('id'), 'issue_deadline' );
        $this->delete_meta(in('id'), 'issue_status' );
        $this->delete_meta(in('id'), 'issue_label' );
        $this->delete_meta(in('id'), 'issue_assignee' );
        // create the new meta values
        $this->post_create(in('id'));

    }

    private function delete_meta($post_ID, $key){
        delete_post_meta($post_ID, $key );
    }

    /*
     * Get Users
     * */
    public function getUsers(){
        return get_users();
    }

    /*
     * Close Issue
     * Check if the current user is the author of issue, If not, Closing of Issue won't work.
     * @todo unit testing & permission checks & confirmation (Using Modal or something)
     * */
    private function close_issue()
    {
        $current_user = $this->current_user();
        $post_ID = seg(2);
        $author = $this->meta($post_ID, 'issue_author');
//        var_dump($author);
        if (!is_user_logged_in()) ferror(9323, "Please login first.");
        if ($current_user->user_login == $author) { //if the current user is the author of post
            // delete the meta value first to avoid duplicate datas
            $this->delete_meta($post_ID, 'issue_status');
            $this->meta($post_ID, 'issue_status', 'close');
        } else {
            ferror(9323, "You can't close the issue you didn't posted. Only " . $author . " can close this issue");
        }
    }
    /*
     * Check the current user
     * */
    public function current_user(){
        global $current_user;
        get_currentuserinfo();

        return $current_user; // recently added
    }
    /*
     * Search Issues by Title/Content, Labels, Deadline, Assigned to the User
     * @todo unit testing
     * */
    public function issue_search(){
        // Get the categories under parent category - ITS
        $categories = $this->getCategories();
        foreach ($categories as $category) {
            $ids[] = $category->term_id;

        };

        if(in('assigned_to_user')){ // "Assigned to you" is clicked
            $current_user = $this->current_user();
            $args = array(
                'posts_per_page' => -1,
                'category__in' => $ids,
                'meta_key' => 'issue_assignee',
                'meta_value' => $current_user->user_login,
            );
        } elseif( in('search_field')) { // If search using search field

            if (in('filter')) { //  There's a filter selected
                $args = $this->search_meta(in('filter'), in('search_field'), in('deadline'));
            } else { // No filters selected;
                $args = $this->search_meta('', in('search_field'), in('deadline'));
            }

        }elseif ( in('deadline') ){ // search only by deadline
            $args = $this->search_meta('', '', in('deadline'));
        }

        $post = get_posts($args); //$this->getPosts
        return $post;
    }

    public function search_meta($meta_keys = NULL, $value = NULL, $deadline = NULL){
        if(!isset($meta_keys) || empty($meta_keys)) { // If there's no meta key passed, use this one
            $meta_keys = array('issue_title', 'issue_content', 'issue_label', 'issue_assignees', 'issue_author', 'issue_deadline');
        }

        // Get the categories under parent category - ITS
        $categories = $this->getCategories();
        foreach ($categories as $category) {
            $ids[] = $category->term_id;

        };

        // Check if atleast either $value or $deadline is not empty/null
        if( isset($value) && !empty($value) || isset($deadline) && !empty($deadline) ){
            for($i = 0; $i <= count($meta_keys); $i++){
                $result = array(
                    'posts_per_page' => -1,
                    'category__in' => $ids,
                    'meta_key' => $meta_keys[$i],
                    'meta_value' => array($value, $deadline)
                );
            }

        }
        return $result;
    }

}


$__post = null;
/**
 * @note This function caches on memory. so no matter how many times you call this function, it does not produce burden on Process.
 * @return ITS
 */
function post() {
    global $__post;
    static $__count_post = 0;
    $__count_post ++;
    if ( isset($__post) ) return $__post;
    else {
        if ( $__count_post > 1 ) {
            xlog('Fatal error: ITS object instanticated more than twice.');
//            echo 'Fatal error: ITS object instanticated more than twice.';
            return null;
        }
        else {
            xlog('Creates ITS instance. This should be done only once.');
//            echo 'Creates ITS instance. This should be done only once.';
            $__post = new post();
            return $__post;
        }
    }
}
