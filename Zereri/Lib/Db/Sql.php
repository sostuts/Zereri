<?php
namespace Zereri\Lib\Db;

class Sql
{
    /**sql语句
     *
     * @var string | array
     */
    private $sql;


    /**数据表名
     *
     * @var string
     */
    private $table;


    /**sql增删查改操作
     *
     * @var string
     */
    private $crud;


    /**sql where语句
     *
     * @var string
     */
    private $where;


    /**预处理参数对应的数据
     *
     * @var array
     */
    private $values;


    /**指定的列名
     *
     * @var string | array
     */
    private $columns;


    /**orderby语句
     *
     * @var string
     */
    private $orderby;


    /**limit语句
     *
     * @var string
     */
    private $limit;


    /**groupby语句
     *
     * @var string
     */
    private $groupby;


    /**having语句
     *
     * @var string
     */
    private $having;


    /**inner join 语句
     *
     * @var array
     */
    private $innerjoin;


    /**left join 语句
     *
     * @var string
     */
    private $leftjoin;


    /**聚合函数列名
     *
     * @var array
     */
    private $aggregation;


    public function __construct($table)
    {
        $this->table = $table;
    }


    /**组建原生SQL
     *
     * @param       $sql
     * @param array $values
     *
     * @return array
     */
    public function raw($sql, array $values)
    {
        return (new Database())->select($sql, $values);
    }


    /**组合inner join语句(数组)
     *
     * @param $table
     * @param $first_column
     * @param $sign
     * @param $last_column
     *
     * @return $this
     */
    public function join($table, $first_column, $sign = '', $last_column = '')
    {
        $this->innerjoin[] = "inner join $table on $first_column $sign $last_column";

        return $this;
    }


    /**组合left join语句
     *
     * @param $table
     * @param $first_column
     * @param $sign
     * @param $last_column
     *
     * @return $this
     */
    public function leftJoin($table, $first_column, $sign = '', $last_column = '')
    {
        $this->leftjoin .= "left join $table on $first_column $sign $last_column ";

        return $this;
    }


    /**组合where语句
     *
     * @param        $column
     * @param        $sign
     * @param        $val
     * @param string $prefix
     * @param string $suffix
     *
     * @return $this
     */
    public function where($column, $sign, $val, $prefix = '', $suffix = '')
    {
        $this->where .= "$prefix $column $sign ? $suffix ";
        $this->values[] = $val;

        return $this;
    }


    /**组合where语句的 或 条件
     *
     * @param $column
     * @param $sign
     * @param $val
     *
     * @return $this
     */
    public function orWhere($column, $sign, $val)
    {
        $this->where($column, $sign, $val, 'or');

        return $this;
    }


    /**组合where语句的 且 条件
     *
     * @param $column
     * @param $sign
     * @param $val
     *
     * @return $this
     */
    public function andWhere($column, $sign, $val)
    {
        $this->where($column, $sign, $val, 'and');

        return $this;
    }


    /**优先判断两个 或 条件的where语句
     *
     * @param array $first_params
     * @param array $last_params
     *
     * @return $this
     */
    public function whereOrWhere(array $first_params, array $last_params)
    {
        $this->whereToWhere($first_params, $last_params, 'or');

        return $this;
    }


    /**优先判断两个 且 条件的where语句
     *
     * @param array $first_params
     * @param array $last_params
     *
     * @return $this
     */
    public function whereAndWhere(array $first_params, array $last_params)
    {
        $this->whereToWhere($first_params, $last_params, 'and');

        return $this;
    }


    /**组合两个where语句
     *
     * @param array $first_params
     * @param array $last_params
     * @param       $connect_sign
     */
    protected function whereToWhere(array $first_params, array $last_params, $connect_sign)
    {
        $this->where($first_params[0], $first_params[1], $first_params[2], '(')->where($last_params[0], $last_params[1], $last_params[2], $connect_sign, ')');
    }

    /**为where语句添加and字句，配合whereToWhere使用
     *
     * @return $this
     */
    public function _and()
    {
        $this->where .= ' and ';

        return $this;
    }

    /**为where语句添加or字句，配合whereToWhere使用
     *
     * @return $this
     */
    public function _or()
    {
        $this->where .= ' or ';

        return $this;
    }


    /**组合between语句
     *
     * @param $column
     * @param $start
     * @param $end
     *
     * @return $this
     */
    public function whereBetween($column, $start, $end)
    {
        $this->between($column, $start, $end);

        return $this;
    }


    /**组合not between语句
     *
     * @param $column
     * @param $start
     * @param $end
     *
     * @return $this
     */
    public function whereNotBetween($column, $start, $end)
    {
        $this->between($column, $start, $end, 'not');

        return $this;
    }


    /**where-between
     *
     * @param        $column
     * @param        $start
     * @param        $end
     * @param string $side
     */
    protected function between($column, $start, $end, $side = '')
    {
        $this->where .= "$column $side between ? and ? ";
        $this->values[] = $start;
        $this->values[] = $end;
    }


    /**组合in语句
     *
     * @param       $column
     * @param array $values
     *
     * @return $this
     */
    public function whereIn($column, array $values)
    {
        $this->in($column, $values);

        return $this;
    }


    /**组合not in语句
     *
     * @param       $column
     * @param array $values
     *
     * @return $this
     */
    public function whereNotIn($column, array $values)
    {
        $this->in($column, $values, 'not');

        return $this;
    }


    /**where-in
     *
     * @param        $column
     * @param array  $values
     * @param string $side
     */
    protected function in($column, array $values, $side = '')
    {
        $this->where .= "$column $side in (" . $this->getQuestionMark($values) . ") ";
        $this->values = array_merge($this->values ?: [], $values);
    }


    /**组合null语句
     *
     * @param $column
     *
     * @return $this
     */
    public function whereNull($column)
    {
        $this->null($column);

        return $this;
    }


    /**组合not null语句
     *
     * @param $column
     *
     * @return $this
     */
    public function whereNotNull($column)
    {
        $this->null($column, 'not');

        return $this;
    }


    /**where-null
     *
     * @param        $column
     * @param string $side
     */
    protected function null($column, $side = '')
    {
        $this->where .= "$column is $side null ";
    }


    /**组合orderby语句
     *
     * @param array ...$columns
     *
     * @return $this
     */
    public function orderBy(...$columns)
    {
        $this->orderby = 'order by ' . implode(',', $columns);

        return $this;
    }


    /**组合groupby语句
     *
     * @param array ...$columns
     *
     * @return $this
     */
    public function groupBy(...$columns)
    {
        $this->groupby = 'group by ' . implode(',', $columns);

        return $this;
    }


    /**组合having语句
     *
     * @param $column
     * @param $sign
     * @param $value
     *
     * @return $this
     */
    public function having($column, $sign, $value)
    {
        $this->having = "having $column $sign $value";

        return $this;
    }


    /**原生having语句
     *
     * @param $having
     *
     * @return $this
     */
    public function havingRaw($having)
    {
        $this->having = "having $having";

        return $this;
    }


    /**组合limit语句
     *
     * @param $skip
     * @param $take
     *
     * @return $this
     */
    public function limit($skip, $take)
    {
        $this->limit = "limit $skip,$take ";

        return $this;
    }


    /**聚合count
     *
     * @param string $alias
     *
     * @return $this
     */
    public function count($alias = '')
    {
        $this->aggregateFunc('count(*)', $alias);

        return $this;
    }


    /**聚合最大值
     *
     * @param        $column
     * @param string $alias
     *
     * @return $this
     */
    public function max($column, $alias = '')
    {
        $this->aggregateFunc("max($column)", $alias);

        return $this;
    }


    /**聚合最小值
     *
     * @param        $column
     * @param string $alias
     *
     * @return $this
     */
    public function min($column, $alias = '')
    {
        $this->aggregateFunc("min($column)", $alias);

        return $this;
    }


    /**聚合平均值
     *
     * @param        $column
     * @param string $alias
     *
     * @return $this
     */
    public function avg($column, $alias = '')
    {
        $this->aggregateFunc("avg($column)", $alias);

        return $this;
    }


    /**聚合总和
     *
     * @param        $column
     * @param string $alias
     *
     * @return $this
     */
    public function sum($column, $alias = '')
    {
        $this->aggregateFunc("sum($column)", $alias);

        return $this;
    }


    /**聚合去重
     *
     * @param        $column
     * @param string $alias
     *
     * @return $this
     */
    public function concat($column, $alias = '')
    {
        $this->aggregateFunc("group_concat($column)", $alias);

        return $this;
    }


    /**聚合函数
     *
     * @param        $aggregation
     * @param string $alias
     */
    protected function aggregateFunc($aggregation, $alias)
    {
        $this->aggregation[] = "$aggregation $alias";
    }


    /**事务开始
     *
     * @return $this
     */
    public function beginTransaction()
    {
        (new Database())->query("set autocommit=0", []);

        return $this;
    }


    /**回滚事务
     *
     * @return $this
     */
    public function rollback()
    {
        (new Database())->query("rollback", []);

        return $this;
    }


    /**
     * 提交事务
     */
    public function commit()
    {
        return (new Database())->query("commit", []);
    }


    /**查询操作
     *
     * @param string $columns
     *
     * @return array
     */
    public function select($columns = '*')
    {
        $this->crud(__FUNCTION__);

        if (is_array($columns)) {
            $this->columns = implode(",", $columns);
        } else {
            $this->columns = $columns;
        }

        return $this->execSql();
    }


    /**插入操作1
     *
     * @param $all_data
     *
     * @return array
     */
    public function insert($all_data)
    {
        $this->crud(__FUNCTION__);

        //一维数组
        if (!isset($all_data[0])) {
            $this->eachInsert($all_data);
        } else {
            foreach ($all_data as $key => $each_data) {
                $this->eachInsert($each_data, $key);
            }
        }

        return $this->execSql();
    }


    /**组建单个插入语句
     *
     * @param     $data
     * @param int $key
     */
    private function eachInsert($data, $key = 0)
    {
        $this->columns[ $key ] = implode(',', array_keys($data));
        $this->values[ $key ] = array_values($data);
    }


    /**插入操作2
     *
     * @param array $columns
     * @param array ...$all_data
     *
     * @return array
     */
    public function add(array $columns, ...$all_data)
    {
        $this->crud(__FUNCTION__);

        $this->columns = implode(',', $columns);
        $this->values = $all_data;

        return $this->execSql();
    }


    /**更改操作
     *
     * @param array $data
     *
     * @return array
     */
    public function update(array $data)
    {
        $this->crud(__FUNCTION__);

        $column_val = $this->getUpdateInfo($data);
        $this->columns = implode(',', $this->columns);
        $this->values = array_merge($column_val, $this->values);

        return $this->execSql();
    }


    /**提取update数组的字段与值
     *
     * @param $data
     *
     * @return array
     */
    protected function getUpdateInfo(&$data)
    {
        $column_val = [];
        foreach ($data as $column => $value) {
            $this->columns[] = $column . '=?';
            $column_val[] = $value;
        }

        return $column_val;
    }


    /**删除操作
     *
     * @return array
     */
    public function delete()
    {
        $this->crud(__FUNCTION__);

        return $this->execSql();
    }


    /**字段值增加
     *
     * @param     $column
     * @param int $num
     *
     * @return array
     */
    public function increment($column, $num = 1)
    {
        return $this->commonCrement($column, $num, "+");
    }


    /**字段值减少
     *
     * @param     $column
     * @param int $num
     *
     * @return array
     */
    public function decrement($column, $num = 1)
    {
        return $this->commonCrement($column, $num, "-");
    }


    /**字段增减公共操作
     *
     * @param $column
     * @param $num
     * @param $operation
     *
     * @return array
     */
    protected function commonCrement($column, $num, $operation)
    {
        $this->crud("update");

        $this->columns = "$column = $column $operation $num";

        return $this->execSql();
    }


    /**定义当前curd操作
     *
     * @param $method
     */
    private function crud($method)
    {
        $this->crud = $method;
    }


    /**返回sql语句以及参数
     *
     * @return array
     */
    protected function execSql()
    {
        if ('select' === $this->crud) {
            return (new Database("select"))->select($this->buildSql()->sql, $this->values ?: []);
        }

        return (new Database())->{in_array($this->crud, ['insert', 'add']) ? $this->crud : 'query'}($this->buildSql()->sql, $this->values ?: []);
    }


    /**组合sql语句
     *
     * @return $this
     */
    protected function buildSql()
    {
        switch ($this->crud) {
            case 'select':
                $this->sql = $this->selectSql();
                break;
            case 'insert':
                foreach ($this->columns as $key => $column) {
                    $this->sql[ $key ] = $this->insertSql($key, $column);
                }
                break;
            case 'add':
                $this->sql = $this->addSql();
                break;
            case 'update':
                $this->sql = $this->updateSql();
                break;
            case 'delete':
                $this->sql = $this->deleteSql();
                break;
        }

        return $this;
    }

    /**SQL查询语句
     *
     * @return string
     */
    protected function selectSql()
    {
        return "select " . $this->sqlColumns() . " from " . $this->joinTable() . $this->sqlWhere() . " {$this->groupby} {$this->having} {$this->orderby} {$this->limit}";
    }


    /**返回完整的列名
     *
     * @return array|string
     */
    protected function sqlColumns()
    {
        return $this->aggregation ? ($this->columns ? $this->columns . "," : "") . implode(",", $this->aggregation) : $this->columns;
    }


    /**返回完整的where语句
     *
     * @return string
     */
    protected function sqlWhere()
    {
        return $this->where ? " where {$this->where} " : "";
    }


    /**是否使用join语句
     *
     * @return string
     */
    protected function joinTable()
    {
        if ($this->innerjoin) {
            return $this->innerJoinTable();
        } elseif ($this->leftjoin) {
            return $this->leftJoinTable();
        } else {
            return $this->table;
        }
    }


    /**返回inner join语句
     *
     * @return string
     */
    protected function innerJoinTable()
    {
        if (count($this->innerjoin) === 1) {
            return $this->singleInnerJoin();
        } else {
            return $this->multipleInnerJoin();
        }
    }


    /**单表 inner join
     *
     * @return string
     */
    protected function singleInnerJoin()
    {
        return "{$this->table} {$this->innerjoin[0]}";
    }


    /**多表 inner join
     *
     * @return string
     */
    protected function multipleInnerJoin()
    {
        $last_join = array_pop($this->innerjoin);
        foreach ($this->innerjoin as $each_join) {
            $this->table = "($this->table $each_join)";
        }

        return "$this->table $last_join";
    }


    /**返回left join语句
     *
     * @return string
     */
    protected function leftJoinTable()
    {
        return "$this->table $this->leftjoin";
    }


    /**SQL插入语句1
     *
     * @param $key
     * @param $column
     *
     * @return string
     */
    protected function insertSql($key, $column)
    {
        return "insert into {$this->table}({$column}) values(" . $this->getQuestionMark($this->values[ $key ]) . ')';
    }


    /**SQL插入语句2
     *
     * @return string
     */
    protected function addSql()
    {
        return "insert into {$this->table}({$this->columns}) values(" . $this->getQuestionMark($this->values[0]) . ")";
    }


    /**SQL更改语句
     * @return string
     */
    protected function updateSql()
    {
        return "update {$this->table} set {$this->columns} where {$this->where}";
    }


    /**SQL删除语句
     *
     * @return string
     */
    protected function deleteSql()
    {
        return "delete from {$this->table} where {$this->where}";
    }


    /**获取代替参数的问号
     *
     * @param array $values
     *
     * @return string
     */
    protected function getQuestionMark(array $values)
    {
        $count = count($values);

        return rtrim(str_repeat('?,', $count), ",");
    }
}