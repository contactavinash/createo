<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Chintantable {
    private $CI;
    public $onlyelementjson=[];
    function __construct() {
        // Assign by reference with "&" so we don't create a copy
        $this->CI = & get_instance();
    }
    public function createelement($field,$sort,$header,$alias)
    {
        $elements = new stdClass();
        $elements->field = $field;
        $elements->sort = $sort;
        $elements->header = $header;
        $elements->alias = $alias;
        array_push($this->onlyelementjson,$elements);
        return $this->onlyelementjson;
    }
    public function query($pageno = 1, $maxlength = 20, $orderby = "", $orderorder = "", $search = "", $elements, $from, $where = " WHERE 1 ", $group = "", $having = "", $order = "", $baseurl = "http://localhost/puneetdemo/index.php/site/index", $options = array()) {
        //        QUERY
        //            1. SELECT
        //            2. FROM
        //            3. WHERE
        //            4. GROUP
        //            5. HAVING
        //            6. ORDER
        //            7. LIMIT
        //        $element->field;
        //        $element->alias;
        //        $element->sort;
        //        $element->filter;
        //        $element->filterfunction;
        if ($pageno == "") {
            $pageno = 1;
        }
        $pageno = intval($pageno);
        if ($maxlength == "") {
            $maxlength = 20;
        }
        $maxlength = intval($maxlength);
        $selectquery = "SELECT ";
        $fromquery = " " . $from . " ";
        $wherequery = " " . $where . " AND ( ";
        $groupquery = " " . $group . " ";
        $havingquery = " " . $having . " ";
        $orderquery = " ORDER BY ";
        $maxlength = intval($maxlength);
        $startingfrom = ($pageno - 1) * $maxlength;
        $searchquery = "";
        $limitquery = " LIMIT $startingfrom,$maxlength";
        foreach ($elements as $element) {
            $selectquery.= " " . $element->field . " ";
            if (isset($element->alias) && $element->alias != "") {
                $selectquery.= " AS `" . $element->alias . "` ";
            }
            $selectquery.= ", ";
            if (isset($element->filter) && $element->filter != "") {
                $wherequery.= " `" . $element->field . "` " . $element->filterfunction . " '" . $element->filter . "' AND ";
            }
            if (isset($element->sort) && $orderby != "" && $orderorder != "" && ($orderby == $element->alias || $orderby == $element->field)) {
                $orderquery.= " `" . $orderby . "` " . $orderorder . ", ";
                $element->sort = $orderorder;
            }
            if ($search != "") {
                $searchquery.= " " . $element->field . " LIKE '%" . $search . "%' OR ";
            }
        }
        $searchquery.= " 0 ";
        $selectquery.= " 1 ";
        if ($search == "") {
            $wherequery.= " 1 ) ";
        } else {
            $wherequery.= " 1 ) AND ($searchquery)";
        }
        $orderquery.= " 1 ";
        $return = new stdClass();
        $return->query = $selectquery . $fromquery . $wherequery . $groupquery . $havingquery . $orderquery . $limitquery;
        $return->queryresult = $this->CI->db->query($return->query)->result();
        $return->totalvalues = $this->CI->db->query($selectquery . $fromquery . $wherequery . $groupquery . $havingquery);
        $return->totalvalues = intval($return->totalvalues->num_rows());
        $return->pageno = $pageno;
        $return->lastpage = ceil($return->totalvalues / $maxlength);
        $return->elements = $elements;
        $return->from = $from;
        $return->where = $where;
        $return->group = $group;
        $return->having = $having;
        $return->search = $search;
        $return->startingfrom = $startingfrom;
        $return->maxlength = $maxlength;
        $return->options = $options;
        return $return;
    }
    public function createpagination() {
        echo '<nav class="chintantablepagination"><ul class="pagination"></ul></nav>';
    }
    public function createsearch($title = "", $description = "") {
        echo '<div class="loader">
        <div class="dots">Loading...</div>
            </div>
        <div class="panel-heading">
    <h3 class="panel-title">' . $title . '</h3>
</div>
<div class="panel-body">
    <div class="bootstrap-table">
        <div class="fixed-table-toolbar">
            <div class="columns columns-right btn-group pull-right">            
            <button class="btn btn-default chintantablesearchgo" type="button">Go!</button>
                <select class="maxrow form-control" style="float: left;  width: 76px;">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        <div class="pull-right search">
            <input class="form-control chintantablesearch" type="text" placeholder="Search">
        </div>
        </div>
    </div>';
    }
    public function gethighstockjson($element1, $element2, $from, $where = "", $group = "", $having = "", $order = "", $limit = "", $otherselect = "") {
        if ($where == "") {
            $where = " WHERE 1 ";
        }
        $query = "SELECT CONCAT(UNIX_TIMESTAMP($element1),'000') AS `0`, $element2 as `1` $otherselect  $from $where $group $having $order $limit";
        return $this->CI->db->query($query)->result_array();
    }
    public function todropdown($query)
    {
        foreach ($query as $row)
        {
            $return[$row->id] = $row->name;
        }
        return $return;
    }
}
/* End of file Someclass.php */
