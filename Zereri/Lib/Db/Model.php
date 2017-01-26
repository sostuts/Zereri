<?php
namespace Zereri\Lib\Db;


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

        return (new $model_name)->getSqlInstance($func, $arguments);
    }


    public function getSqlInstance($func, $arguments)
    {
        $this->instance = $this->newSqlInstance();

        if ($this->isMethodExists($func)) {
            return $this->{$func}($arguments);
        } else {
            return $this->instance->{$func}(...$arguments);
        }
    }


    protected function newSqlInstance()
    {
        return \Factory::newSql($this->getTableName());
    }


    protected function isMethodExists($func)
    {
        return method_exists($this, $func);
    }


    protected function getTableName($model_class = '')
    {
        if ($table_name = $this->getTableNameFromModelAttributeOrNotReturnFalse($model_class)) {
            return $table_name;
        }

        return $this->getTableNameByExplodeNameSpace($model_class);
    }


    protected function getTableNameFromModelAttributeOrNotReturnFalse($model_class)
    {
        $instance = $model_class ? (new $model_class) : $this;

        return $instance->getTable();
    }


    protected function getTableNameByExplodeNameSpace($model_class)
    {
        $pieces = explode("\\", $model_class ?: get_called_class());

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
        return $this->hasMany($rules)->groupBy($this->getRealColumnFromRelateRule(array_values($this->$rules[0])[0][0])); //对外键groupby
    }


    private function getTableNameInModel($model)
    {
        return $this->getTableName($this->getWholeModelClassName($model));
    }


    private function getWholeModelClassName($model)
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
        foreach ($this->{$rules[0]} as $model => $columns) {
            $this->instance->{$operation}($this->getTableNameInModel($model), $this->getRealColumnFromRelateRule($columns[0]), '=', $this->getRealColumnFromRelateRule($columns[1]));
        }
    }


    protected function getRealColumnFromRelateRule($column)
    {
        $pieses = explode(".", $column);

        return $this->getTableNameInModel($pieses[0]) . "." . $pieses[1];
    }


    public function getTable()
    {
        return isset($this->table) ? $this->table : false;
    }
}