<?php

/**
 * BUILDER PATTERN
 * 
 * The Builder pattern is a creational design pattern that lets you construct 
 * complex objects step by step. The pattern allows you to produce different 
 * types and representations of an object using the same construction code.
 */

interface SQLQueryBuilder
{
    public function select(string $table, array $fields): SQLQueryBuilder;

    public function where(string $field, string $value, string $operator = '='): SQLQueryBuilder;

    public function limit(int $start, int $offset): SQLQueryBuilder;

    public function getSQL(): string;
}

/**
 * The Concrete Builder follows the interface and provides specific 
 * implementations of the building steps. Your program may have several 
 * variations of Builders, implemented differently.
 */
class MysqlQueryBuilder implements SQLQueryBuilder
{
    protected $query;

    protected function reset(): void
    {
        $this->query = new \stdClass();
    }

    public function select(string $table, array $fields): SQLQueryBuilder
    {
        $this->reset();
        $this->query->base = "SELECT " . implode(", ", $fields) . " FROM " . $table;
        $this->query->type = 'select';

        return $this;
    }

    public function where(string $field, string $value, string $operator = '='): SQLQueryBuilder
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete'])) {
            throw new \Exception("WHERE can only be added to SELECT, UPDATE OR DELETE");
        }
        $this->query->where[] = "$field $operator '$value'";

        return $this;
    }

    public function limit(int $start, int $offset): SQLQueryBuilder
    {
        if (!in_array($this->query->type, ['select'])) {
            throw new \Exception("LIMIT can only be added to SELECT");
        }
        $this->query->limit = " LIMIT " . $start . ", " . $offset;

        return $this;
    }

    public function getSQL(): string
    {
        $query = $this->query;
        $sql = $query->base;
        if (!empty($query->where)) {
            $sql .= " WHERE " . implode(' AND ', $query->where);
        }
        if (isset($query->limit)) {
            $sql .= $query->limit;
        }
        $sql .= ";";

        return $sql;
    }
}

/**
 * PostgresQueryBuilder works similarly but might have slightly different syntax.
 */
class PostgresQueryBuilder extends MysqlQueryBuilder
{
    public function limit(int $start, int $offset): SQLQueryBuilder
    {
        parent::limit($start, $offset);

        $this->query->limit = " LIMIT " . $offset . " OFFSET " . $start;

        return $this;
    }
}

/**
 * The Director is only responsible for executing the building steps in a 
 * particular sequence. It is helpful when producing objects according to a 
 * specific order or configuration. Strictly speaking, the Director class is 
 * optional, since the client can control builders directly.
 */
function clientCode(SQLQueryBuilder $queryBuilder)
{
    $query = $queryBuilder
        ->select("users", ["name", "email", "password"])
        ->where("id", "1")
        ->where("active", "1")
        ->limit(0, 10)
        ->getSQL();

    echo $query . PHP_EOL;
}

/**
 * The client code creates a builder object, passes it to the director and then 
 * initiates the construction process. The end result is retrieved from the 
 * builder object.
 */
echo "Testing MySQL query builder:\n";
clientCode(new MysqlQueryBuilder());

echo "\nTesting Postgres query builder:\n";
clientCode(new PostgresQueryBuilder());
