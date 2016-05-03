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

        /**
         * @TODO
         *
         * 1/ Gérer la connection MySQL au serveur (informations de connexion ci-dessous)
         * host : localhost
         * database : evalphp_site
         * user : evalphp
         * password : yxzITfuKlSv9oFjLTJch
         *
         * 2/ Boucler sur les résultats obtenus en remplissant le tableau "$entries" grâce à la méthode "createEntryFromDbValues()" ci-après
         */

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
