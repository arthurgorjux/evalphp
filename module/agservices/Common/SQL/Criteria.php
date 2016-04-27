<?php

namespace agservices\Common\SQL;

class Criteria
{

	/** Comparison type. */
	const EQUAL = "=";
	/** Comparison type. */
	const NOT_EQUAL = "<>";
	/** Comparison type. */
	const GREATER_THAN = ">";
	/** Comparison type. */
	const LESS_THAN = "<";
	/** Comparison type. */
	const GREATER_EQUAL = ">=";
	/** Comparison type. */
	const LESS_EQUAL = "<=";
	/** Comparison type. */
	const LIKE = " LIKE ";
	/** Comparison type. */
	const NOT_LIKE = " NOT LIKE ";
	/** Comparison type. */
	const IN = " IN ";
	/** Comparison type. */
	const NOT_IN = " NOT IN ";

	/** "Order by" qualifier - ascending */
	const ASC = "ASC";

	/** "Order by" qualifier - descending */
	const DESC = "DESC";
	/**
	 * Storage for Criterions expected to be combined
	 * @var        array
	 */
	protected $criterions = array();

	/**
	 * Storage for Order by clauses
	 * @var        array
	 */
	protected $orderByColumns = array();


	/**
	 * Add a new criterion to the criteria
	 *
	 * @param  String $table      The table which the criterion will target
	 * @param  String $field      The field to run the comparison on
	 * @param  mixed $value       The value to test against
	 * @param  String $comparator A String
	 * @access public
	 */
	function add($table, $field, $value, $comparator){
		$this->criterions[] = new Criterion($table, $field, $value, $comparator);
	}

	/**
	 * Translates the criterions to an SQL Where clause
	 *
	 * @return String the text equivalent of the criteria
	 * @access public
	 */
	function getWhereClause(){
		$whereClause = '';
		foreach($this->criterions as $aCriterion ) {
			$whereClause .= ($whereClause == "") ? '': ' AND ';
			$whereClause .= $aCriterion->toSql();
		}

		return $whereClause;
	}

	/**
	 * Translates the orderByColumns to an SQL Order By clause
	 *
	 * @return String the text equivalent of the criteria
	 * @access public
	 */
	function getOrderByClause(){
		$orderByClause = '';

		foreach($this->orderByColumns as $anOrderBy ) {
			$orderByClause .= ($orderByClause == "") ? '': ', ';
			$orderByClause .= $anOrderBy;
		}
		$sql = ($orderByClause ? " ORDER BY ".$orderByClause : "");
		return $sql;
	}


	/**
	 * Add order by column
	 *
	 * @param string $name  The name of the column to order by.
	 * @param string $order The order to use
	 */
	public function addOrderBy($name, $order) {
		$this->orderByColumns[] = $name . ' ' . $order;
		return $this;
	}

	/**
	 * Add order by column name, explicitly specifying ascending.
	 *
	 * @param      string $name The name of the column to order by.
	 * @return     A modified Criteria object.
	 */
	public function addAscendingOrderByColumn($name)
	{
		self::addOrderBy($name,self::ASC);
		return $this;
	}

	/**
	 * Add order by column name, explicitly specifying descending.
	 *
	 * @param      string $name The name of the column to order by.
	 * @return     Criteria  A modified Criteria object.
	 */
	public function addDescendingOrderByColumn($name)
	{
		self::addOrderBy($name,self::DESC);
		return $this;
	}

	/**
	 * Get order by columns.
	 *
	 * @return     array An array with the name of the order columns.
	 */
	public function getOrderByColumns()
	{
		return $this->orderByColumns;
	}


}
?>
