<?php

declare (strict_types=1);

namespace SeanPhp\db\builder;

use ClickHouseDB\Query\Query as ClickHouseQuery;

use SeanPhp\db\connector\Clickhouse as Connection;
use ClickHouseDB\Exception\DatabaseException as Exception;
use SeanPhp\db\Clickhouse as Query;

class Clickhouse
{
    // connection对象实例
    protected $connection;
    // 最后插入ID
    protected $insertId = [];
    // 查询表达式
    protected $exp = ['<>' => 'ne', '=' => 'eq', '>' => 'gt', '>=' => 'gte', '<' => 'lt', '<=' => 'lte', 'in' => 'in', 'not in' => 'nin', 'nin' => 'nin', 'mod' => 'mod', 'exists' => 'exists', 'null' => 'null', 'notnull' => 'not null', 'not null' => 'not null', 'regex' => 'regex', 'type' => 'type', 'all' => 'all', '> time' => '> time', '< time' => '< time', 'between' => 'between', 'not between' => 'not between', 'between time' => 'between time', 'not between time' => 'not between time', 'notbetween time' => 'not between time', 'like' => 'like', 'near' => 'near', 'size' => 'size'];

    /**
     * 架构函数
     * @access public
     * @param Connection $connection 数据库连接对象实例
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * 获取当前的连接对象实例
     * @access public
     * @return Connection
     */
    public function getConnection(): Connection
    {
        return $this->connection;
    }

    /**
     * 生成查询过滤条件
     * @access public
     * @param Query $query 查询对象
     * @param mixed $where
     * @return string
     */
    public function parseWhere(Query $query, array $where): string
    {
        if (empty($where)) {
            $where = [];
        }
        var_dump($where);

        $whereStr = '';


        return $whereStr;
    }

    /**
     * 日期时间条件解析
     * @access protected
     * @param Query $query 查询对象
     * @param string $value
     * @param string $key
     * @return string
     */
    protected function parseDateTime(Query $query, $value, $key)
    {
        // 获取时间字段类型
        $type = $query->getFieldType($key);

        if ($type) {
            if (is_string($value)) {
                $value = strtotime($value) ?: $value;
            }

            if (is_int($value)) {
                if (preg_match('/(datetime|timestamp)/is', $type)) {
                    // 日期及时间戳类型
                    $value = date('Y-m-d H:i:s', $value);
                } elseif (preg_match('/(date)/is', $type)) {
                    // 日期及时间戳类型
                    $value = date('Y-m-d', $value);
                }
            }
        }

        return $value;
    }

    /**
     * 获取最后写入的ID 如果是insertAll方法的话 返回所有写入的ID
     * @access public
     * @return mixed
     */
    public function getLastInsID()
    {
        return $this->insertId;
    }

    /**
     * 生成insert BulkWrite对象
     * @access public
     * @param Query $query 查询对象
     * @return BulkWrite
     */
    public function insert(Query $query): BulkWrite
    {
        // 分析并处理数据
        $options = $query->getOptions();

        $data = $this->parseData($query, $options['data']);

        $bulk = new BulkWrite;

        if ($insertId = $bulk->insert($data)) {
            $this->insertId = $insertId;
        }

        $this->log('insert', $data, $options);

        return $bulk;
    }

    /**
     * 生成insertall BulkWrite对象
     * @access public
     * @param Query $query 查询对象
     * @param array $dataSet 数据集
     * @return BulkWrite
     */
    public function insertAll(Query $query, array $dataSet): BulkWrite
    {
        $bulk = new BulkWrite;
        $options = $query->getOptions();

        $this->insertId = [];
        foreach ($dataSet as $data) {
            // 分析并处理数据
            $data = $this->parseData($query, $data);
            if ($insertId = $bulk->insert($data)) {
                $this->insertId[] = $insertId;
            }
        }

        $this->log('insert', $dataSet, $options);

        return $bulk;
    }

    /**
     * 生成update BulkWrite对象
     * @access public
     * @param Query $query 查询对象
     * @return BulkWrite
     */
    public function update(Query $query): BulkWrite
    {
        $options = $query->getOptions();

        $data = $this->parseSet($query, $options['data']);
        $where = $this->parseWhere($query, $options['where']);

        if (1 == $options['limit']) {
            $updateOptions = ['multi' => false];
        } else {
            $updateOptions = ['multi' => true];
        }

        $bulk = new BulkWrite;

        $bulk->update($where, $data, $updateOptions);

        $this->log('update', $data, $where);

        return $bulk;
    }

    /**
     * 生成delete BulkWrite对象
     * @access public
     * @param Query $query 查询对象
     * @return BulkWrite
     */
    public function delete(Query $query): BulkWrite
    {
        $options = $query->getOptions();
        $where = $this->parseWhere($query, $options['where']);

        $bulk = new BulkWrite;

        if (1 == $options['limit']) {
            $deleteOptions = ['limit' => 1];
        } else {
            $deleteOptions = ['limit' => 0];
        }

        $bulk->delete($where, $deleteOptions);

        $this->log('remove', $where, $deleteOptions);

        return $bulk;
    }

    /**
     * 生成Mongo查询对象
     * @access public
     * @param  Query $query 查询对象
     * @param  bool $one 是否仅获取一个记录
     * @return ClickHouseQuery
     */
    public function select(Query $query, bool $one = false)
    {
        $options = $query->getOptions();

        $where = $this->parseWhere($query, $options['where']);

        if ($one) {
            $options['limit'] = 1;
        }

        var_dump($where);

        $query = $this->connection->select();

//        $query = new ClickHouseQuery($where, $options);

//        $this->log('find', $where, $options);

        return $query;
    }

    /**
     * 生成Count命令
     * @access public
     * @param Query $query 查询对象
     * @return Command
     */
    public function count(Query $query): Command
    {
        $options = $query->getOptions();

        $cmd['count'] = $options['table'];
        $cmd['query'] = (object)$this->parseWhere($query, $options['where']);

        foreach (['hint', 'limit', 'maxTimeMS', 'skip'] as $option) {
            if (isset($options[$option])) {
                $cmd[$option] = $options[$option];
            }
        }

        $command = new Command($cmd);
        $this->log('cmd', 'count', $cmd);

        return $command;
    }

    /**
     * 聚合查询命令
     * @access public
     * @param Query $query 查询对象
     * @param array $extra 指令和字段
     * @return Command
     */
    public function aggregate(Query $query, array $extra): Command
    {
        $options = $query->getOptions();
        [$fun, $field] = $extra;

        if ('id' == $field && $this->connection->getConfig('pk_convert_id')) {
            $field = '_id';
        }

        $group = isset($options['group']) ? '$' . $options['group'] : null;

        $pipeline = [
            ['$match' => (object)$this->parseWhere($query, $options['where'])],
            ['$group' => ['_id' => $group, 'aggregate' => ['$' . $fun => '$' . $field]]],
        ];

        $cmd = [
            'aggregate' => $options['table'],
            'allowDiskUse' => true,
            'pipeline' => $pipeline,
            'cursor' => new \stdClass,
        ];

        foreach (['explain', 'collation', 'bypassDocumentValidation', 'readConcern'] as $option) {
            if (isset($options[$option])) {
                $cmd[$option] = $options[$option];
            }
        }

        $command = new Command($cmd);

        $this->log('aggregate', $cmd);

        return $command;
    }

    /**
     * 多聚合查询命令, 可以对多个字段进行 group by 操作
     *
     * @param Query $query 查询对象
     * @param array $extra 指令和字段
     * @return Command
     */
    public function multiAggregate(Query $query, $extra): Command
    {
        $options = $query->getOptions();

        [$aggregate, $groupBy] = $extra;

        $groups = ['_id' => []];

        foreach ($groupBy as $field) {
            $groups['_id'][$field] = '$' . $field;
        }

        foreach ($aggregate as $fun => $field) {
            $groups[$field . '_' . $fun] = ['$' . $fun => '$' . $field];
        }

        $pipeline = [
            ['$match' => (object)$this->parseWhere($query, $options['where'])],
            ['$group' => $groups],
        ];

        $cmd = [
            'aggregate' => $options['table'],
            'allowDiskUse' => true,
            'pipeline' => $pipeline,
            'cursor' => new \stdClass,
        ];

        foreach (['explain', 'collation', 'bypassDocumentValidation', 'readConcern'] as $option) {
            if (isset($options[$option])) {
                $cmd[$option] = $options[$option];
            }
        }

        $command = new Command($cmd);
        $this->log('group', $cmd);

        return $command;
    }

    /**
     * 生成distinct命令
     * @access public
     * @param Query $query 查询对象
     * @param string $field 字段名
     * @return Command
     */
    public function distinct(Query $query, $field): Command
    {
        $options = $query->getOptions();

        $cmd = [
            'distinct' => $options['table'],
            'key' => $field,
        ];

        if (!empty($options['where'])) {
            $cmd['query'] = (object)$this->parseWhere($query, $options['where']);
        }

        if (isset($options['maxTimeMS'])) {
            $cmd['maxTimeMS'] = $options['maxTimeMS'];
        }

        $command = new Command($cmd);

        $this->log('cmd', 'distinct', $cmd);

        return $command;
    }

    /**
     * 查询所有的collection
     * @access public
     * @return Command
     */
    public function listcollections(): Command
    {
        $cmd = ['listCollections' => 1];
        $command = new Command($cmd);

        $this->log('cmd', 'listCollections', $cmd);

        return $command;
    }

    /**
     * 查询数据表的状态信息
     * @access public
     * @param Query $query 查询对象
     * @return Command
     */
    public function collStats(Query $query): Command
    {
        $options = $query->getOptions();

        $cmd = ['collStats' => $options['table']];
        $command = new Command($cmd);

        $this->log('cmd', 'collStats', $cmd);

        return $command;
    }

    protected function log($type, $data, $options = [])
    {
        $this->connection->mongoLog($type, $data, $options);
    }
}
