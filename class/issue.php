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

    /*
     * View Post URL
     * */
    public function viewURL($slug)
    {
        return $this->urlIssueView($slug);
    }
    public function urlIssueView($slug)
    {
        return home_url("/issue/view/$slug");
    }
    /*
     * Edit Post URL or should we use WP-admin for edit?
     * */
    public function editURL($slug)
    {
        return $this->urlIssueEdit($slug);
    }
    public function urlIssueEdit($slug)
    {
        return home_url("/issue/edit/$slug");

    }
    /*
     * Search URL
     * */
    public function listURL()
    {
        return $this->urlIssueList();
    }
    public function urlIssueList()
    {
        return home_url("/issue/list/");
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
    public function listURLPage()
    {
        return $this->urlListPage();
    }

    public function urlListPage() {
        return home_url('wp-admin/admin.php?page=issue-tracker-plugin%2Ftemplate%2Fissue-list.php');
    }

    public function urlCategoryPage() {
        return home_url('wp-admin/admin.php?page=issue-tracker-plugin%2Ftemplate%2Flabels.php');
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
            $this->setNone404(); // To prevent "Failed to load resource: the server responded with a status of 404 (Not Found)"


            if (seg(0) == 'issue' && seg(1) == 'view' && is_numeric(seg(2))) {
                // http://abc.com/issue/view/(0-9)/
                return $this->loadTemplate('issue-view.php');
            }else if (seg(0) == 'issue' && seg(1) == 'edit' && is_numeric(seg(2))) {
                // http://abc.com/issue/edit/(0-9)/
                return $this->loadTemplate('issue-edit.php');
            } else if (seg(0) == 'issue' && seg(1) == 'list' && seg(2) == NULL) {
                // http://abc.com/issue/list/
                return $this->loadTemplate('issue-search-result.php');
            }
        }, 0.01);

    }

    public function setNone404() {
        global $wp_query;
        if ( $wp_query->is_404 ) {
            status_header( 200 );
            $wp_query->is_404=false;
        }
    }


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
