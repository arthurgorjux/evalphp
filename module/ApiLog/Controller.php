<?php

    namespace ApiLog;

    use Silex\Application;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\JsonResponse;

    class Controller {

        private $app = null;

        public function __construct($app) {
            $this->app = $app;
        }

        public function homePage() {
            $response = array("status" => "success", "message" => "API for UserLogs");
            return new JsonResponse($response);
        }

        public function get($type = null) {
            if (empty($type)) {
                $this->app->abort(204, "No content for this request");
            }

            /**
             * @TODO
             *
             * Appeler la methode "getListing" de la classe "Connector" (/module/ApiLog/Connector.php)
             */
             $data = Connector::getListing($type);

            if (!$data) {
                $this->app->abort(204, "No content for this request");
            }

            //turn json to html
            $html = Connector::jsonToTable($data);
            return new Response($html);
        }

    }

?>
