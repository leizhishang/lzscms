<?php
/**
 * @author Leizhishang <info@Leizhishang.com>
 * @copyright ©2016-2100 Leizhishang.com
 * @license http://www.Leizhishang.com
 */
namespace Leizhishang\Lzscms\Libraries;

use Closure;
use Illuminate\Support\Composer;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Schema\Blueprint;
/**
* 
*/
class LzscmsDb
{
	public $databaseName = '';
	
    public function __construct(Filesystem $filesystem = null)
    {
        $this->files = $filesystem ?: new Filesystem;
    }

    /**
     * Create a new table on the schema.
     *
     * @param  string    $table
     * @param  \Closure  $callback
     * @return void
     */
    public function table($table, Closure $callback)
    {
    	if(!$this->hasTable($table)) {
    		return lzs_message('is has table');
    	}
        \Schema::connection($this->databaseName)->table($table, $callback);
    }

    /**
     * Create a new table on the schema.
     *
     * @param  string    $table
     * @param  \Closure  $callback
     * @return void
     */
    public function createTable($table, Closure $callback)
    {
    	if($this->hasTable($table)) {
    		return lzs_message('is has table');
    	}
        \Schema::connection($this->databaseName)->create($table, $callback);
		return true;
    }

    /**
     * Create a new table on the schema.
     *
     * @param  string    $table
     * @param  \Closure  $callback
     * @return void
     */
    public function dropTable($table)
    {
    	if(!$this->hasTable($table)) {
    		return lzs_message('is has table');
    	}
        \Schema::connection($this->databaseName)->drop($table);
		return true;
    }

    /**
     * Rename a table on the schema.
     *
     * @param  string  $from
     * @param  string  $to
     * @return void
     */
    public function renameTable($from, $to)
    {
    	if(!$this->hasTable($from)) {
    		return lzs_message('is no has table');
    	}
    	if($this->hasTable($to)) {
    		return lzs_message('is has table '.$to);
    	}
        \Schema::connection($this->databaseName)->rename($from, $to);
		return true;
    }

    /**
     * Checks if a database table exists
     * @param string $table
     * @return boolean
     */
    public function hasTable($table)
    {
        return \Schema::connection($this->databaseName)->hasTable($table);
    }

    /**
     * Get the column listing for a given table.
     *
     * @param  string  $table
     * @return array
     */
    public function getColumnListing($table, $filed = '')
    {
        $columns =  \Schema::connection($this->databaseName)->getColumnListing($table);
        if($filed) {
        	return in_array(
	            strtolower($filed), array_map('strtolower', $columns)
	        );
        }
        return $columns;
    }

    /**
     * Determine if the given table has a given column.
     *
     * @param  string  $table
     * @param  string  $column
     * @return bool
     */
    public function hasColumn($table, $column = '')
    {
    	if(is_array($column)) {
       		return \Schema::connection($this->databaseName)->hasColumns($table, $column);
    	}
       	return \Schema::connection($this->databaseName)->hasColumn($table, $column);
    }

    //新曾列
    public function addColumn($table, $column, $columnAttribute = []) 
    {
    	if(!$this->hasTable($table)) {
    		return lzs_message('is has table');
    	}
    	if($this->hasColumn($table, $column)) {
    		return lzs_message('is has column');
    	}
    	if (count($column) !== count($column, 1)) {
    		return $this->addColumns($table, $column, $columnAttribute);
    	}
		$this->table($table, function (Blueprint $table) use($column, $columnAttribute) {
		    if(isset($columnAttribute['type']) && $columnAttribute['type']) {
		    	$_table = null;
		    	switch ($columnAttribute['type']) {
		    		case 'INT':
		    			$_table = $table->integer($column);
		    			break;
		    		case 'TINYINT':
		    			$_table = $table->tinyInteger($column);
		    			break;
		    		case 'SMALLINT':
		    			$_table = $table->smallInteger($column);
		    			break;
		    		case 'MEDIUMINT':
		    			$_table = $table->mediumInteger($column);
		    			break;
		    		case 'DECIMAL':
		    			$_table = $table->decimal($column, (int)$columnAttribute['length1'], (int)$columnAttribute['length2']);
		    			break;
		    		case 'FLOAT':
		    			$_table = $table->float($column, (int)$columnAttribute['length1'], (int)$columnAttribute['length2']);
		    			break;
		    		case 'CHAR':
		    			$_table = $table->char($column, (int)$columnAttribute['length1']);
		    			break;
		    		case 'VARCHAR':
		    			$_table = $table->string($column, (int)$columnAttribute['length1']);
		    			break;
		    		case 'TEXT':
		    			$_table = $table->text($column);
		    			break;
		    		case 'MEDIUMTEXT':
		    			$_table = $table->mediumText($column);
		    			break;
		    		case 'DATE':
		    			$_table = $table->date($column);
		    			break;
		    		case 'DATETIME':
		    			$_table = $table->dateTime($column);
		    			break;
		    		case 'IP':
		    			$_table = $table->ipAddress($column);
		    			break;
		    		default:
		    			$_table = $table->string($column, 255);
		    			break;
		    	}
		    	//指定列的默认值
		    	if(isset($columnAttribute['defaultValueType']) && $columnAttribute['defaultValueType']) {
			    	switch ($columnAttribute['defaultValueType']) {
			    		case 'NULL':		//允许该列的值为 NULL
			    			$_table->nullable();
			    			break;
			    		default:
			    			$_table->default($columnAttribute['defaultValue']);
			    			break;
			    	}
		    	}
		    	//添加注释信息
		    	if(isset($columnAttribute['comment']) && $columnAttribute['comment']) {
		    		$_table->comment($columnAttribute['comment']);
		    	}
		    	//将该列置于另一个列之后 (MySQL)
		    	if(isset($columnAttribute['after']) && $columnAttribute['after']) {
		    		$_table->after($columnAttribute['after']);
		    	}
	    	}
		});
		return true;
    }

    public function addColumns($table, $columns, $columnAttributes = []) 
    {
    	if(!$this->hasTable($table)) {
    		return lzs_message('is has table');
    	}
    	if($this->hasColumn($table, $columns)) {
    		return lzs_message('is has column');
    	}
    	foreach ($columns as $column) {
    		if(!isset($columnAttributes[$column])) continue;
    		$this->addColumn($table, $column, $columnAttributes[$column]);
    	}
    	return true;
    }

    //重命名列
    public function renameColumn($table, $from, $to) 
    {
    	if(!$this->hasTable($table)) {
    		return lzs_message('is has table');
    	}
    	if(!$this->hasColumn($table, $from)) {
    		return lzs_message('is no has column');
    	}
    	if($this->hasColumn($table, $to)) {
    		return lzs_message('is has column '.$to);
    	}
		$this->table($table, function (Blueprint $table) use($from, $to) {
		    $table->renameColumn($from, $to);
		});
		return true;
    }

    //删除列
    public function dropColumn($table, $column) 
    {
    	if(!$this->hasTable($table)) {
    		return lzs_message('is has table');
    	}
    	if(!$this->hasColumn($table, $column)) {
    		return lzs_message('is has column');
    	}
		$this->table($table, function (Blueprint $table) use($column) {
		    $table->dropColumn($column);
		});
		return true;
    }
}

?>