<?php

    namespace ApiLog;

    use agservices\Common\SQL\Criteria as Criteria;
    use UserLog\Repository;

    class Connector {
        const NB_RESULTS = 25;

        public static function jsonToTable($data){
             $table = '
             <table class="json-table" width="100%">
             ';
             foreach ($data as $key => $value) {
                 $table .= '
                 <tr valign="top">
                 ';
                 if ( ! is_numeric($key)) {
                     $table .= '
                     <td>
                     <strong>'. $key .':</strong>
                     </td>
                     <td>
                         ';
                 } else {
                     $table .= '
                     <td colspan="2">
                     ';
                 }
                 if (is_object($value) || is_array($value)) {
                     $table .= self::jsonToTable($value);
                 } else {
                     $table .= $value;
                 }
                 $table .= '
                 </td>
                 </tr>
                ';
             }
             $table .= '
             </table>
             ';
             return $table;
        }

        public static function getListing($type) {
            $entryRepository = new Repository();

            $criteria = new Criteria();

            // Criteria : TYPE
            $criteria->add('UserLogs', 'type', $type, Criteria::EQUAL);

            $results = array();
            $entries = $entryRepository->get($criteria, 0, self::NB_RESULTS);
            if ($entries) {
                foreach ($entries as $entry) {
                    $date = $entry->getDate();
                    $datetime = $date->format('Y-m-d H:i:s');

                    $results[] = array(
                        'datetime' => $datetime,
                        'ipAddress' => $entry->getIpAddress(),
                        'country' => $entry->getCountry(),
                        'category' => $entry->getCategory(),
                        'type' => $entry->getType(),
                        'element' => $entry->getElement(),
                        'additionnalInformations' => $entry->getAdditionnalInformations(),
                    );
                }
            }

            $nbResults = $entries ? count($entries) : 0;

            return array(
                'status' => array(
                    'status' => 'success',
                    'message' => 'OK'
                ),
                'paging' => array(
                    'nbResults' => $nbResults
                ),
                'results' => $results
            );
        }

    }

?>
