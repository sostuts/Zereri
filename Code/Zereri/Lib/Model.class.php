<?php
namespace Zereri\Lib;

class Model
{
    /**DB实例
     *
     * @var SQL Object
     */
    protected $instance;


    public static function __callStatic($func, $arguments)
    {
        $model_name = get_called_class();

        return (new $model_name)->dbInstance($func, $arguments);
    }


    /**实例化SQL类
     *
     * @param $func
     * @param $arguments
     *
     * @return mixed
     */
    public function dbInstance($func, $arguments)
    {
        $this->instance = $this->newInstance();

        if ($this->isMethodExists($func)) {
            return $this->{$func}($arguments);
        } else {
            return $this->instance->{$func}(...$arguments);
        }
    }


    /**实例化DB类
     *
     * @return Sql
     */
    protected function newInstance()
    {
        return Factory::newSql($this->getTableName());
    }


    /**本类是否存在该方法
     *
     * @param $func
     *
     * @return bool
     */
    protected function isMethodExists($func)
    {
        return method_exists($this, $func);
    }


    /**获取模型中的表名
     *
     * @param string $model
     *
     * @return string
     */
    protected function getTableName($model = '')
    {
        $instance = $model ? (new $model) : $this;

        return isset($instance->table) ? $instance->table : $this->classNameGetTableName($model);
    }


    /**命名空间获取表名
     *
     * @return string
     */
    protected function classNameGetTableName($model)
    {
        $pieces = explode("\\", $model ?: get_called_class());

        return strtolower(end($pieces));
    }


    /**多对多
     *
     * @param $rules string 对应的关系规则名
     *
     * @return SQL
     */
    protected function belongsToMany($rules)
    {
        $this->relateCommon($rules, "leftJoin");

        return $this->instance;
    }


    /**一对多关联
     *
     * @param $rules
     *
     * @return SQL
     */
    protected function hasMany($rules)
    {
        $this->relateCommon($rules, "join");

        return $this->instance;
    }


    /**一对一关联
     *
     * @param $rules
     *
     * @return $this
     */
    protected function hasOne($rules)
    {
        return $this->hasMany($rules)->groupBy($this->getRealColumn(array_values($this->$rules[0])[0][0])); //对外键groupby
    }


    /**从model中获取对应的表名
     *
     * @param $model
     *
     * @return string
     */
    private function getTableNameInModel($model)
    {
        return $this->getTableName($this->wholeModelName($model));
    }


    /**整合命名空间
     *
     * @param $model string
     *
     * @return string
     */
    private function wholeModelName($model)
    {
        return '\App\Models\\' . $model;
    }


    /**关联的公众操作
     *
     * @param $rules
     * @param $operation
     */
    protected function relateCommon($rules, $operation)
    {
        foreach ($this->$rules[0] as $model => $columns) {
            $this->instance->{$operation}($this->getTableNameInModel($model), $this->getRealColumn($columns[0]), '=', $this->getRealColumn($columns[1]));
        }
    }


    /**从关联规则获取真实字段
     *
     * @param $column
     *
     * @return string
     */
    protected function getRealColumn($column)
    {
        $pieses = explode(".", $column);

        return $this->getTableNameInModel($pieses[0]) . "." . $pieses[1];
    }
}