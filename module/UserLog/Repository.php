<?php

namespace UserLog;

use agservices\Common\SQL\Criteria;
use DateTime;

class Repository {

    public function get(Criteria $criteria = null, $from = null, $to = null) {
        if(!$criteria) {
            $criteria = new Criteria();
        }
        $criteriaSql = $criteria->getWhereClause();

        $sql = "SELECT * "
             . "FROM UserLogs "
             . "WHERE ". (($criteriaSql == "") ? "1" : $criteriaSql );

        $orderBy = $criteria->getOrderByClause();
        if(!$orderBy) {
            $criteria->addOrderBy('datetime', Criteria::DESC);
            $orderBy = $criteria->getOrderByClause();
        }
        $sql .= $orderBy;
        if (($from !== null) || ($to !== null)){
            $sql .= ' LIMIT ' . $from ;
            if($to) {
                $sql .= ',' . $to;
            }
        }
        $sql .= ';';

        $link = mysql_connect("localhost", "root", "ks164gb")
            or die("Impossible de se connecter : " . mysql_error());
        mysql_select_db('astriumgeo.trunk', $link);
        $result = mysql_query(sprintf($sql));
        if ($result) {
            while ($row = mysql_fetch_object($result)) {
                $entries[] = $this->createEntryFromDbValues($row);
            }
        }
        mysql_close($link);

        return $entries;
    }

    private function createEntryFromDbValues($databaseValues) {
        $datetime = DateTime::createFromFormat('Y-m-d H:i:s', $databaseValues->datetime);;
        $additionnalInformations = json_decode($databaseValues->additionnalInformations);
        return new Entry($databaseValues->id,
                        $datetime,
                        $databaseValues->userId,
                        $databaseValues->sessionId,
                        $databaseValues->ipAddress,
                        $databaseValues->country,
                        $databaseValues->category,
                        $databaseValues->type,
                        $databaseValues->element,
                        $additionnalInformations);
    }

}
