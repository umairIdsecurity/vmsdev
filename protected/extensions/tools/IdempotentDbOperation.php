<?php


/**
 * Class IdempotentOperation
 * Provides idempotent operations
 *
 * @author Yuri Vodolazsky
 */
class IdempotentDbOperation
{

    /**
     * Array of CDbTableSchema entities
     * Keys are the names of the tables
     *
     * @var array
     */
    protected $tableSchemes = array();

    /**
     * Required for executing SQL commands via migration->execute in order to see console output
     *
     * @var CDbMigration
     */
    protected $migration;


    /**
     * @param CDbMigration $migration
     */
    public function __construct(CDbMigration $migration)
    {
        Yii::app()->db->schema->refresh();
        $this->migration = $migration;
    }

    /**
     * Add column if not exists
     *
     * @param string $table
     * @param string $column
     * @param string $columnDefinition
     * @param string $additionalConstraint Can be used for creating foreign key
     * @throws Exception
     */
    public function addColumn($table, $column, $columnDefinition, $additionalConstraint = null)
    {
        if ( ! $this->isColumnPresent($table, $column)) {

            $this->migration->execute("ALTER TABLE $table ADD COLUMN $column $columnDefinition;");

            if ( ! is_null($additionalConstraint)) {
                $this->migration->execute("ALTER TABLE $table $additionalConstraint;");
            }
        }
    }

    /**
     * Add column if not exists
     *
     * @param string $table
     * @param string $column
     * @param string $columnDefinition
     * @param string $additionalConstraint Can be used for creating foreign key
     * @param null $fkSymbol
     */
    public function dropAndAddColumn($table, $column, $columnDefinition, $additionalConstraint = null, $fkSymbol = null)
    {
        $this->dropColumn($table, $column, $fkSymbol);

        Yii::app()->db->schema->refresh();

        $this->migration->execute("ALTER TABLE $table ADD COLUMN $column $columnDefinition;");

        if ( ! is_null($additionalConstraint)) {
            $this->migration->execute("ALTER TABLE $table $additionalConstraint;");
        }
    }

    /**
     * Drop column if exists
     *
     * @param string $table
     * @param string $column
     * @param string $fkSymbol Can be used for deleting column's foreign key
     * @throws Exception
     */
    public function dropColumn($table, $column, $fkSymbol = null)
    {
        if ($this->isColumnPresent($table, $column)) {

            if ( ! is_null($fkSymbol) && $this->_hasForeignKey($table, $column)) {
                $this->migration->execute("ALTER TABLE $table  DROP FOREIGN KEY $fkSymbol;");
            }

            $this->migration->execute("ALTER TABLE $table DROP COLUMN $column;");
            unset($this->tableSchemes[$table]);
        }
    }

    /**
     * Modify column if exists
     *
     * @param string $table
     * @param string $column
     * @param string $columnDefinition
     * @throws Exception
     */
    public function modifyColumn($table, $column, $columnDefinition)
    {
        if ($this->isColumnPresent($table, $column)) {
            $this->migration->execute("ALTER TABLE $table MODIFY COLUMN $column $columnDefinition;");
        }
    }

    /**
     * Create table if not exists
     * Insert data in table if provided
     *
     * @param string $table
     * @param string $tableDefinition
     * @param string $tableData
     */
    public function createTable($table, $tableDefinition, $tableData = null)
    {
        if ( ! $this->_isTablePresent($table)) {

            $this->migration->execute($tableDefinition);

            if ( ! is_null($tableData)) {
                $this->migration->execute($tableData);
            }
        }
    }

    /**
     * Check if column in table already exists
     *
     * @param string $table
     * @param string $column
     * @return bool
     * @throws Exception
     */
    public function isColumnPresent($table, $column)
    {
        if ($this->_isTablePresent($table)) {
            $tableScheme = $this->_getTableScheme($table);
            return isset($tableScheme->columns[$column]);
        }

        throw new Exception("Trying to check column '$column' in nonexistent table '$table'");
    }

    /**
     * Get foreign keys array for column
     *
     * @param string $table
     * @param string $column
     * @return array
     */
    protected function _getForeignKey($table, $column)
    {
        $tableScheme = $this->_getTableScheme($table);

        if (array_key_exists($column, $tableScheme->foreignKeys)) {
            return $tableScheme->foreignKeys[$column];
        }

        return array();
    }

    /**
     * @param string $table
     * @param string $column
     * @return bool
     */
    protected function _hasForeignKey($table, $column)
    {
        return count($this->_getForeignKey($table, $column)) > 0;
    }

    /**
     * Search table scheme in cached array and return it
     * Load and put in cache if not found
     *
     * @param string $table
     * @return CDbTableSchema|null
     */
    protected function _getTableScheme($table)
    {
        if ( ! array_key_exists($table, $this->tableSchemes)) {
            $this->tableSchemes[$table] = Yii::app()->db->schema->getTable($table);
        }

        return $this->tableSchemes[$table];
    }

    /**
     * Check if table already exists
     *
     * @param string $table
     * @return bool
     */
    protected function _isTablePresent($table)
    {
        return ! is_null($this->_getTableScheme($table));
    }
}