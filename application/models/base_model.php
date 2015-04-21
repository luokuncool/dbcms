<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Ionize, creative CMS
 *
 * @package        Ionize
 * @author         Ionize Dev Team
 * @license        http://doc.ionizecms.com/en/basic-infos/license-agreement
 * @link           http://ionizecms.com
 * @since          Version 0.9.0
 */

// ------------------------------------------------------------------------

/**
 * Ionize Base Model
 * Extends the Model class and provides basic ionize model functionnalities
 *
 * @package        Ionize
 * @subpackage     Models
 * @category       Model
 * @author         Ionize Dev Team
 *
 */
class Base_model extends CI_Model
{
    protected static $_inited = FALSE;

    public $db_group = 'default';

    public static $ci = NULL;

    /**
     * table name
     * @var null|string
     */
    public $table = NULL;

    /**
     * 主键名
     * @var string
     */
    public $pk_name = 'id';

    public $limit = NULL;        // Query Limit
    public $offset = NULL;        // Query Offset

    /**
     * 字段
     * @var array
     */
    protected $_list_fields = array();

    /**
     * 是否缓存
     * @var bool
     */
    public $is_cache = FALSE;

    /**
     * Constructor
     *
     * @access    public
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->driver('Cache', config_item('cache_type'));
        /*if (is_null($this->db_group))
        {
          $active_group = 'default';
          include(APPPATH . 'config/database.php');
          $this->db_group = $active_group;
        }

        $this->db = $this->load->database($this->db_group, TRUE);

        if(self::$_inited)
        {
          return;
        }
        self::$_inited = TRUE;*/

        //self::$ci =& get_instance();
    }

    /**
     * Get the model table name
     */
    public function get_table()
    {
        return $this->table;
    }

    /**
     * @param $where
     *
     * @return array
     */
    public function get($where)
    {
        $this->db->from($this->table);
        if (is_array($where)) {
            $where && $this->db->where($where);
        } elseif (is_string($where)) {
            $where && $this->db->where($where, null, false);
        }
        $data = $this->db->get()->result_array();
        return $data;
    }

    /**
     * join
     *
     * @param        $table
     * @param        $cond
     * @param string $type
     */
    public function join($table, $cond, $type = '')
    {
        $this->db->join($table, $cond, $type);
        return $this->db;
    }

    /**
     * Get a resultset Where
     *
     * @access    public
     *
     * @param    array    An associative array
     *
     * @return    array    Result set
     *
     */
    public function get_where($where = NULL)
    {
        return $this->db->get_where($this->table, $where, $this->limit, $this->offset);
    }

    /**
     * Get all the records
     *
     * @param null $table
     *
     * @return mixed
     */
    public function get_all($table = NULL)
    {
        $table = (!is_null($table)) ? $table : $this->table;

        $query = $this->db->get($table);

        return $query->result_array();
    }

    /**
     * 获取行
     *
     * @param null   $id
     * @param string $field
     * @param bool   $database 强制读取数据库
     *
     * @return array
     */
    public function get_row($id = NULL, $field = '*', $database = false)
    {
        if ($this->is_cache && !$database) {
            $cachekey = $this->table . $id;
            $cacheRow = $this->cache->get($cachekey);
        }

        if (!$cacheRow) {
            $this->db->where($this->pk_name, $id);
            $row = $this->db->get($this->table)->row_array();
        } else {
            $row = $cacheRow;
        }

        $this->load->helper('array_helper');
        $field != '*' && $row = elements(explode(',', $field), $row);
        return $row;
    }

    /**
     * Get one row_array
     *
     * @param null $where
     * @param null $table
     *
     * @return mixed
     */
    public function get_row_array($where = NULL, $table = NULL)
    {
        $table = ($table == NULL) ? $this->table : $table;
        if (is_array($where)) {
            // Perform conditions from the $where array
            foreach (array('limit', 'offset', 'order_by', 'like') as $key) {
                if (isset($where[$key])) {
                    call_user_func(array($this->db, $key), $where[$key]);
                    unset($where[$key]);
                }
            }
            if (isset($where['where_in'])) {
                foreach ($where['where_in'] as $key => $value) {
                    if (!empty($value))
                        $this->db->where_in($key, $value);
                }
                unset($where['where_in']);
            }
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        return $query->row_array();
    }

    // ------------------------------------------------------------------------


    /**
     * @param       $field
     * @param array $where
     * @param null  $table
     *
     * @return string
     *
     */
    public function get_group_concat($field, $where = array(), $table = NULL)
    {
        $table = is_null($table) ? $this->table : $table;

        $data = '';

        $this->_process_where($where, $table);

        $this->db->select('group_concat(distinct ' . $field . ') as result');
        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            if (!is_null($result['result'])) {
                $data = $result['result'];
            }
        }

        return $data;
    }


    // ------------------------------------------------------------------------


    /**
     * @param       $field
     * @param array $where
     * @param null  $table
     *
     * @return array
     *
     */
    public function get_group_concat_array($field, $where = array(), $table = NULL)
    {
        $result = $this->get_group_concat($field, $where, $table);

        if ($result != '')
            return explode(',', $result);

        return array();
    }


    // ------------------------------------------------------------------------


    /**
     * @param string|null $where
     * @param string      $field
     * @param bool        $database 是否墙强制读取数据库
     * @param string|null $table
     *
     * @return array
     */
    public function get_list($where = NULL, $field = '*', $database = FALSE, $table = NULL)
    {
        $data = array();

        $table = (!is_null($table)) ? $table : $this->table;
        $this->db->start_cache();

        // Perform conditions from the $where array
        foreach (array('where_in', 'like') as $key) {
            if (isset($where[$key])) {
                call_user_func_array(array($this->db, $key), array($where[$key]));
                unset($where[$key]);
            }
        }
        /* if (isset($where['where_in']))
         {
             foreach($where['where_in'] as $key => $value)
             {
                 $this->db->where_in($key, $value);
             }
             unset($where['where_in']);
         }*/


        if (!empty ($where)) {
            foreach ($where as $cond => $value) {
                if (is_string($cond) && in_array($cond, array('limit', 'offset', 'order_by'))) continue;
                if (is_string($cond)) {
                    $this->db->where($cond, $value);
                } else {
                    $this->db->where($value);
                }
                unset($where[$cond]);
            }
        }
        $total = $this->db->count_all_results($this->table);
        foreach (array('limit', 'offset', 'order_by') as $key) {
            if (isset($where[$key])) {
                call_user_func_array(array($this->db, $key), $where[$key]);
                unset($where[$key]);
            }
        }
        $this->db->select($this->pk_name, FALSE);

        $query = $this->db->get($table);
        if ($query->num_rows > 0)
            $data = $query->result_array();
        $this->db->stop_cache();
        $this->db->flush_cache();

        $rows = array();
        foreach ($data as $key => $value) {
            $rows[$key] = $this->get_row($value['id'], $field, $database);
        }
        $query->free_result();

        return array('total' => $total, 'rows' => $rows);
    }

    /**
     * Get the current linked childs items as a simple array from a N:M table
     *
     * @param    String         Items table name
     * @param    String         Parent table name
     * @param    Integer        Parent ID
     * @param    String         Link table prefix. Default to ''
     *
     * @return    array        items keys simple array
     *
     */
    public function get_joined_items_keys($items_table, $parent_table, $parent_id, $prefix = '')
    {
        $data = array();

        // N to N table
        $link_table = $prefix . $parent_table . '_' . $items_table;

        // Items table primary key detection
        $fields = $this->db->list_fields($items_table);
        $items_table_pk = $fields[0];

        // Parent table primary key detection
        $fields = $this->db->list_fields($parent_table);
        $parent_table_pk = $fields[0];

        $this->db->where($parent_table_pk, $parent_id);
        $this->db->select($items_table_pk);
        $query = $this->db->get($link_table);

        foreach ($query->result() as $row) {
            $data[] = $row->$items_table_pk;
        }

        return $data;
    }

    /**
     * Gets items key and value as an associative array
     *
     * @param        $items_table
     * @param        $field                index of the field to get
     * @param array  $where
     * @param null   $nothing_index        Value to display fo "no value"
     * @param null   $nothing_value
     * @param null   $order_by
     * @param string $glue
     *
     * @return array
     */
    public function get_items_select($items_table, $field, $where = array(), $nothing_index = NULL, $nothing_value = NULL, $order_by = NULL, $glue = "")
    {
        $data = array();

        // Add the Zero value item
        if (!is_null($nothing_value)) {
            $nothing_index = (is_null($nothing_index)) ? 0 : $nothing_index;
            $data = array($nothing_index => $nothing_value);
        }

        // Items table primary key detection
        $fields = $this->db->list_fields($items_table);
        $items_table_pk = $fields[0];

        // ORDER BY
        if (!is_null($order_by))
            $this->db->order_by($order_by);

        // WHERE
        if (is_array($where) && !empty($where))
            $this->db->where($where);

        // Query
        $query = $this->db->get($items_table);

        foreach ($query->result() as $row) {
            if (is_array($field)) {
                $value = array();
                foreach ($field as $f) {
                    $value[] = $row->$f;
                }
                $data[$row->$items_table_pk] = implode($glue, $value);
            } else {
                $data[$row->$items_table_pk] = $row->$field;
            }
        }

        return $data;
    }

    public function get_unique_name($name, $id_to_exclude = NULL, $table = NULL, $postfix = 1)
    {
        $this->load->helper('text_helper');

        $table = (!is_null($table)) ? $table : $this->table;

        $name = url_title(convert_accented_characters($name));

        $where = array('name' => $name);

        if (!is_null($id_to_exclude) && $id_to_exclude != FALSE)
            $where['id_' . $table . ' !='] = $id_to_exclude;

        $exists = $this->exists($where);

        if ($exists) {
            if ($postfix > 1 OR (substr($name, -2, count($name) - 2) == '-' && intval(substr($name, -1)) != 0))
                $name = substr($name, 0, -2);

            $name = $name . '-' . $postfix;

            return $this->get_unique_name($name, $id_to_exclude, $table, $postfix + 1);
        }

        return $name;
    }


    public function get_unique_field($field, $value, $id_to_exclude = NULL, $table = NULL, $postfix = 1)
    {
        $this->load->helper('text_helper');

        $table = (!is_null($table)) ? $table : $this->table;

        $value = url_title(convert_accented_characters($value));

        $where = array($field => $value);

        if (!is_null($id_to_exclude) && $id_to_exclude != FALSE)
            $where['id_' . $table . ' !='] = $id_to_exclude;

        $exists = $this->exists($where);

        if ($exists) {
            if ($postfix > 1 OR (substr($value, -2, count($value) - 2) == '-' && intval(substr($value, -1)) != 0))
                $value = substr($value, 0, -2);

            $value = $value . '-' . $postfix;

            return $this->get_unique_field($field, $value, $id_to_exclude, $table, $postfix + 1);
        }

        return $value;
    }


    public function get_keys_array($field, $where = array(), $table = NULL)
    {
        $result = array();

        $table = (!is_null($table)) ? $table : $this->table;

        $this->_process_where($where, $table);

        $this->db->select("group_concat(" . $field . " separator ',') as ids", FALSE);

        $query = $this->db->get($table);

        $data = $query->row_array();

        if (!empty($data['ids'])) {
            $result = explode(',', $data['ids']);
        }

        return $result;
    }


    /**
     * Return the max value of one given field
     *
     * @param      $field
     * @param null $table
     * @param null $where
     *
     * @return bool
     *
     */
    public function get_max($field, $table = NULL, $where = NULL)
    {
        $table = (!is_null($table)) ? $table : $this->table;

        $this->db->select_max($field, 'maximum');

        if (!is_null($where)) {
            $this->db->where($where);
        }

        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->maximum;
        }
        return FALSE;
    }


    public function simple_search($term, $field, $limit)
    {
        $data = array();

        $this->db->like($this->table . '.' . $field, $term);

        $this->db->limit($limit);

        $query = $this->db->get($this->table);

        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }

        return $data;
    }


    /**
     * Returns the first PK field nam found for the given table
     *
     */
    public function get_pk_name($table = NULL)
    {
        if (!is_null($table)) {
            $fields = $this->db->field_data($table);

            foreach ($fields as $field) {
                if ($field->primary_key) {
                    return $field->name;
                    break;
                }
            }
        } else {
            return $this->pk_name;
        }
        return FALSE;
    }


    /**
     * @param $table
     *
     * @return $this
     */
    public function set_table($table)
    {
        $this->table = $table;
        return $this;
    }


    /**
     * @param $pk_name
     *
     * @return $this
     */
    public function set_pk_name($pk_name)
    {
        $this->pk_name = $pk_name;
        return $this;
    }

    /**
     * Insert a row
     *
     * @access    public
     *
     * @param    array    An associative array of data
     *
     * @return    the last inserted id
     *
     */
    public function insert($data = NULL, $table = FALSE)
    {
        $table = (FALSE !== $table) ? $table : $this->table;

        $data = $this->clean_data($data, $table);

        $this->db->insert($table, $data);

        $insertId = $this->db->insert_id();
        //更新缓存
        if ($insertId) $this->update_cache(array($this->pk_name => $insertId));
        return $insertId;
    }

    /**
     * @param null $data
     * @param bool $table
     *
     * @return mixed
     */
    public function insert_ignore($data = NULL, $table = FALSE)
    {
        $table = (FALSE !== $table) ? $table : $this->table;

        $data = $this->clean_data($data, $table);

        $insert_query = $this->db->insert_string($table, $data);
        $insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
        $inserted = $this->db->query($insert_query);


        return $inserted;
    }

    /**
     * 更新数据表
     *
     * @param null $where
     * @param null $data
     * @param bool $table
     *
     * @return int
     */
    public function update($where = NULL, $data = NULL, $table = FALSE)
    {
        $table = (FALSE !== $table) ? $table : $this->table;
        $data = $this->clean_data($data, $table);
        if (is_array($where)) {
            $this->db->where($where);
        } else {
            $this->db->where($where, null, false);
        }
        $this->db->update($table, $data);
        $affected = $this->db->affected_rows();
        $affected && $this->update_cache($where);
        return (int)$this->db->affected_rows();
    }

    /**
     * Delete row(s)
     *
     * @param null $where Where condition. If single value, PK of the table
     * @param null $table
     *
     * @return int                Affected rows
     */
    public function delete($where = NULL, $table = NULL)
    {
        $this->update_cache($where);
        $table = !empty($table) ? $table : $this->table;
        if (is_array($where)) {
            $this->_process_where($where, $table);
        } else {
            $this->db->where($where);
        }
        $result = $this->db->delete($table);
        return (int)$this->db->affected_rows();
    }

    /**
     * Count all rows corresponding to the passed conditions
     *
     * @param array $where
     * @param null  $table
     *
     * @return int
     */
    public function count($where = array(), $table = NULL)
    {
        $table = (!is_null($table)) ? $table : $this->table;

        // Perform conditions from the $where array
        foreach (array('limit', 'offset', 'order_by', 'like') as $key) {
            if (isset($where[$key])) {
                call_user_func(array($this->db, $key), $where[$key]);
                unset($where[$key]);
            }
        }

        if (isset($where['where_in'])) {
            foreach ($where['where_in'] as $key => $value) {
                $this->db->where_in($key, $value);
            }
            unset($where['where_in']);
        }

        if (is_array($where) && !empty($where)) {
            $this->db->where($where);
        }

        $query = $this->db->count_all_results($table);

        return (int)$query;
    }

    /**
     * Count all rows in a table or count all results from the current query
     *
     * @access    public
     *
     * @param    bool    true / false
     *
     * @return    int    The number of all results
     *
     */
    public function count_all($results = FALSE)
    {
        if ($results !== FALSE) {
            $query = $this->db->count_all_results($this->table);
        } else {
            $query = $this->db->count_all($this->table);
        }
        return (int)$query;
    }

    /**
     * Count items based on filter
     *
     * @param array $where
     * @param null  $table
     *
     * @return mixed
     */
    public function count_where($where = array(), $table = NULL)
    {
        $table = (!is_null($table)) ? $table : $this->get_table();

        if (isset($where['order_by']))
            unset($where['order_by']);

        if (isset($where['like'])) {
            $this->db->like($where['like']);
            unset($where['like']);
        }
        if (!empty ($where)) {
            foreach ($where as $cond => $value) {
                if (is_string($cond)) {
                    $this->db->where($cond, $value);
                } else {
                    $this->db->where($value);
                }
            }
        }
        $this->db->from($table);
        return $this->db->count_all_results();
    }

    /**
     * Empty table
     *
     * @access    public
     * @return    void
     *
     */
    public function empty_table()
    {
        $this->db->empty_table($this->table);
    }

    /**
     * Checks if one table is empty, based on given conditions
     *
     * @param null $where
     * @param null $table
     *
     * @return bool
     */
    public function is_empty($where = NULL, $table = NULL)
    {
        $table = !is_null($table) ? $table : $this->table;

        if (is_array($where)) {
            $this->_process_where($where, $table);
        }

        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Check if a record exists in a table
     *
     * @param    array     conditions
     * @param    string    table name
     *
     * @access    public
     * @return    boolean
     *
     */
    public function exists($where = NULL, $table = NULL)
    {
        $table = (!is_null($table)) ? $table : $this->table;
        is_string($where) && $this->db->where($where, null, false);
        is_array($where) && $this->db->where($where);
        $query = $this->db->from($table)->get();

        if ($query->num_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }

    /**
     * Checks if one element with a given field name already exists
     * in the DB.
     *
     * @param      $field            Field to test on
     * @param      $value            Value of the field to test on
     * @param null $element_id       Optional element ID (in case of change of the field value)
     * @param null $table
     *
     * @return bool
     *
     */
    public function check_exists($field, $value, $element_id = NULL, $table = NULL)
    {
        $item = $this->get_row_array(array($field => $value), $table);

        if (!is_null($element_id) && $element_id != FALSE) {
            $pk_name = $this->get_pk_name($table);

            if (!empty($item) && $item[$pk_name] != $element_id)
                return TRUE;
        } else {
            if (!empty($user))
                return TRUE;
        }
        return FALSE;
    }

    /**
     * Returns the table's fields array list
     *
     * array(
     *      'field' =>      'Field name'
     *      'type' =>       'DB field type' (int, tinyint, varchar, ...)
     *      'null' =>       TRUE / FALSE
     *      'key' =>        'PRI|MUL'
     *      'extra' =>      column extra
     *      'comment' =>    column comment
     *      'privileges' => column privileges
     *      'length' =>     int / array (in case of ENUM)
     * )
     *
     * @param    String        Table name
     * @param    Boolean       With / Without primary key. Default FALSE : without.
     *
     * @return    Array        Array of fields data
     *
     */
    public function field_data($table = NULL, $with_pk = FALSE)
    {
        $data = array();

        $table = (!is_null($table)) ? $table : $this->table;

        $query = $this->db->query("SHOW FULL COLUMNS FROM " . $table);

        $fields = $query->result_array();

        foreach ($fields as $key => $field) {
            if ($with_pk === FALSE) {
                if ($field['Field'] == $this->pk_name)
                    continue;
            }

            // keys to lowercase
            $field = array_change_key_case($field, CASE_LOWER);
            $name = $field['field'];
            $data[$name] = $field;

            // isolate the DB type (remove size)

            $type = preg_split("/[\s()]+/", $field['type']);

            if ($type[0] == 'enum') {
                $enum_values = preg_replace("/[enum'()]+/", "", $field['type']);
                $type[1] = explode(',', $enum_values);
            }

            $data[$name] = array_merge(
                $data[$name],
                array(
                    'type' => $type[0],
                    'null' => $field['null'] == 'YES' ? TRUE : FALSE,
                    'length' => isset($type[1]) ? $type[1] : NULL,
                    'value' => NULL
                )
            );
        }
        return $data;
    }

    /**
     * Check for a table field
     *
     * @param      String        Table name
     * @param null $table
     *
     * @return    Boolean        True if the field is found
     *
     */
    public function has_field($field, $table = NULL)
    {
        $table = (!is_null($table)) ? $table : $this->table;
        $fields = $this->db->list_fields($table);
        if (in_array($field, $fields)) return TRUE;
        return FALSE;
    }

    /**
     * Removes from the data array the index which are not in the table
     *
     * @param      $data        The data array to clean
     * @param bool $table       Reference table. $this->table if not set.
     *
     * @return array
     */
    public function clean_data($data, $table = FALSE)
    {
        $cleaned_data = array();

        if (!empty($data)) {
            $table = ($table !== FALSE) ? $table : $this->table;

            $fields = $this->db->list_fields($table);

            $fields = array_fill_keys($fields, '');

            $cleaned_data = array_intersect_key($data, $fields);
        }
        foreach ($cleaned_data as $key => $row) {
            if (is_array($row))
                unset($cleaned_data[$key]);
        }
        return $cleaned_data;
    }

    /**
     *    Reorders the ordering field correctly after unlink of one element
     *
     *    SET @rank=0;
     *    SET @rank=0;
     *    update table set ordering = @rank:=@rank+1
     *    where ...
     *    ORDER BY ordering ASC;
     *
     */
    public function reorder($table = NULL, $where = array())
    {
        $table = (!is_null($table)) ? $table : $this->table;

        if ($this->has_field('ordering', $table)) {
            $query = $this->query("SET @rank=0");

            // Perform conditions from the $where array
            foreach (array('limit', 'offset', 'order_by', 'like') as $key) {
                if (isset($where[$key])) {
                    call_user_func(array($this->db, $key), $where[$key]);
                    unset($where[$key]);
                }
            }

            $this->db->order_by('ordering ASC');
            $this->db->set('ordering', '@rank:=@rank+1', FALSE);
            $this->db->where($where);

            return $this->db->update($table);
        }
    }


    /**
     * Correct ambiguous target fields in SQL conditions
     *
     * @param    Array     condition array
     * @param    String    Table name
     *
     * @return    Array    Corrected condition array
     *
     */
    public function correct_ambiguous_conditions($array, $table)
    {
        if (is_array($array)) {
            foreach ($array as $key => $val) {
                unset($array[$key]);
                $key = $table . '.' . $key;
                $array[$key] = $val;
            }

            return $array;
        }
    }


    /**
     *    Required method to get the database group for THIS model
     */
    public function get_database_group()
    {
        return $this->db_group;
    }

    /**
     * List fields from one table of the current DB group
     * and stores the result locally.
     *
     * @param    string
     *
     * @return    Array    List of table fields
     *
     */
    public function list_fields($table = NULL)
    {
        $table = (!is_null($table)) ? $table : $this->table;

        if (isset($this->_list_fields[$this->db_group . '_' . $table]))
            return $this->_list_fields[$this->db_group . '_' . $table];

        $this->_list_fields[$this->db_group . '_' . $table] = $this->db->list_fields($table);

        return $this->_list_fields[$this->db_group . '_' . $table];
    }

    /**
     * Processes the query condition array
     *
     * @param      $where
     * @param null $table
     */
    protected function _process_where($where, $table = NULL)
    {
        $table = !empty($table) ? $table : $this->table;

        if (!empty($where) && is_array($where)) {
            foreach (array('limit', 'offset', 'like') as $key) {
                if (isset($where[$key])) {
                    call_user_func(array($this->db, $key), $where[$key]);
                    unset($where[$key]);
                }
            }
            if (isset($where['order_by'])) {
                $this->db->order_by($where['order_by'], NULL, FALSE);
                unset($where['order_by']);
            }
            if (isset($where['where_in'])) {
                foreach ($where['where_in'] as $key => $values) {
                    $processed = FALSE;
                    foreach ($values as $k => $value) {
                        if (strtolower($value) == 'null') {
                            unset($values[$k]);
                            $this->db->where("(" . $key . " in ('" . implode("','", $values) . "') OR " . $key . " IS NULL)", NULL, FALSE);
                            $processed = TRUE;
                            break;
                        }
                    }
                    if (!$processed)
                        $this->db->where_in($key, $values, FALSE);
                }
                unset($where['where_in']);
            }
            $protect = TRUE;
            foreach ($where as $field => $value) {
                $protect = !(in_array(substr($field, -3), array(' in', ' is')));
                if ($protect)
                    $protect = !(substr($field, -5) == ' like');
                if (is_string($field)) {
                    if ($value == 'NULL' && is_string($value)) {
                        $this->db->where($field . ' IS NULL', NULL, FALSE);
                    } elseif ($field == "RAW") {
                        $this->db->where($value, NULL, FALSE);
                    } else {
                        if (strpos($field, '.') > 0) {
                            $this->db->where($field, $value, $protect);
                        } else {
                            $this->db->where($table . '.' . $field, $value, $protect);
                        }
                    }
                } else {
                    $this->db->where($value);
                }
            }
        }
    }

    /**
     * 获取最后执行语句
     * @return mixed
     */
    public function last_query()
    {
        return $this->db->last_query();
    }

    /**
     * 监测表是否存在
     *
     * @param $table
     *
     * @return mixed
     */
    public function table_exists($table)
    {
        return $this->db->table_exists($table);
    }

    /**
     * 执行sql语句
     *
     * @param $sql
     *
     * @return mixed
     */
    public function query($sql)
    {
        return $this->db->query($sql);
    }

    /**
     * 更新缓存
     *
     * @param $where
     */
    private function update_cache($where)
    {
        if (!$this->is_cache) return;
        $idsNew = $this->db->where($where)->select($this->pk_name)->get($this->table)->result_array();
        $idsNew = explode(',', get_field_list($idsNew, $this->pk_name));

        $idsOld = $this->cache->get(config_item('changedRow'));
        $ids = $idsOld[$this->table] ? array_merge($idsNew, $idsOld[$this->table]) : $idsNew;
        $ids = array_filter(array_flip(array_flip($ids)));
        $idsOld[$this->table] = $ids;
        $this->cache->delete(config_item('changedRow'));
        $this->cache->save(config_item('changedRow'), $idsOld, config_item('dataCacheTime'));
    }
}
