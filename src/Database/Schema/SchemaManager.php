<?php

namespace TCG\Voyager\Database\Schema;

use Illuminate\Support\Facades\Schema;

abstract class SchemaManager
{
    /**
     * @param string $tableName
     *
     * @return Table
     */
    public static function listTableDetails($tableName)
    {
        $columns = Schema::getColumns($tableName);
        $foreignKeys = Schema::getForeignKeys($tableName);

        $indexes = Schema::getIndexes($tableName);

        return new Table($tableName, $columns, $indexes, [], $foreignKeys, []);
    }

    /**
     * Describes given table.
     *
     * @param string $tableName
     *
     * @return \Illuminate\Support\Collection
     */
    public static function describeTable($tableName)
    {
        $table = static::listTableDetails($tableName);

        return collect($table->columns)->map(function ($column) use ($table) {
            $columnArr = $column;

            $columnArr['field'] = $columnArr['name'];
            $columnArr['type'] = $columnArr['type_name'];

            // Set the indexes and key
            $columnArr['key'] = null;
            if ($columnArr['indexes'] = $table->getColumnsIndexes($columnArr['name'], true)) {
                // Convert indexes to Array
                foreach ($columnArr['indexes'] as $name => $index) {
                    $columnArr['indexes'][$name] = $index;
                }

                // If there are multiple indexes for the column
                // the Key will be one with the highest priority
                $indexType = array_values($columnArr['indexes'])[0]['type'];
                $columnArr['key'] = substr($indexType, 0, 3);
            }

            return $columnArr;
        });
    }
}
