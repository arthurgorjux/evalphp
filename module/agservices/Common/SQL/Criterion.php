<?php
namespace agservices\Common\SQL;

class Criterion {

	/** Value of the CO. */
	protected $value;

	/** Comparison value.
	 * @var        SqlEnum
	 */
	protected $comparison;

	/** Table name. */
	protected $table;

	/** Real table name */
	protected $realtable;

	/** Column name. */
	protected $column;

	public function __construct($table, $column, $value, $comparison = null)
	{
		$this->table = $table;
		$this->value = $value;
		$this->column = $column;
		$this->comparison = ($comparison === null) ? Criteria::EQUAL : $comparison;
	}

	public function toSql() {
		switch ($this->comparison) {
			case Criteria::IN:
			case Criteria::NOT_IN:
				// table.column IN (?, ?) or table.column NOT IN (?, ?)
				return $this->writeInClause();
				break;
			case Criteria::LIKE:
			case Criteria::NOT_LIKE:
				// table.column LIKE ? or table.column NOT LIKE ?  (or ILIKE for Postgres)
				return $this->writeLikeClause();
				break;
			default:
				// table.column = ? or table.column >= ? etc. (traditional expressions, the default)
				return $this->writeBasicClause();
				break;
		}
	}

	protected function writeInClause()
	{
		$sqlStart = $this->table . '.' . $this->column . $this->comparison . '(';
		$inValues = '';
		$sqlEnd   = ')';
		// $this->value must be an array of values
		foreach ((array) $this->value as $value) {
			$inValues .= ($inValues == "") ? "'".$value."'" : ','."'".$value."'";
		}
		return $sqlStart.$inValues.$sqlEnd;
	}

	protected function writeLikeClause()
	{
		$sqlStart = $this->table . '.' . $this->column . $this->comparison . "'%";
		$sqlEnd   = "%'";
		return $sqlStart . $this->value . $sqlEnd;
	}

	protected function writeBasicClause()
	{
		$sqlStart = $this->table . '.' . $this->column . $this->comparison . "'";
		$sqlEnd   = "'";
		return $sqlStart . $this->value . $sqlEnd;
	}
}
?>
