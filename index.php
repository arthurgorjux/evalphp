<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET");

    define("ENABLE_HTML_COMPRESSION", false);
    define("APPLICATION_MEMORY_LIMIT", "256M");
    require_once 'module/ApiLog.php';
    require_once 'module/UserLog.php';
    require_once 'module/agservices.php';
    require_once __DIR__.'/vendor/autoload.php';

    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\JsonResponse;

    use ApiLog\Controller;

    $app = new Silex\Application();

    $app->register(new Silex\Provider\ServiceControllerServiceProvider());

    $app['debug'] = false;

    $app['api.controller'] = $app->share(function() use ($app) {
        return new Controller($app);
    });

    // Default requests
    $app->get('/', "api.controller:homePage");
    $app->get('/v1/', "api.controller:homePage");

    // GET request
    $app->get('/v1/log/get/{type}', "api.controller:get");

    $app->error(function (\Exception $e, $code) {
        switch ($code) {
            case 404:
                $response = array("statusCode" => "404", "error" => "HTTP 404", "message" => "Requested page does not exist");
                break;
            case 204:
                $response = array("statusCode" => "204", "error" => "HTTP 204", "message" => "No content for this request");
                break;
            case 403:
                $response = array("statusCode" => "403", "error" => "HTTP 403", "message" => "Forbidden access");
                break;
            case 401:
                $response = array("statusCode" => "401", "error" => "HTTP 401", "message" => "Access denied");
                break;
            case 500:
                $response = array("statusCode" => "500", "error" => "HTTP 500", "message" => "Internal server error");
                break;
            default:
                $response = array("statusCode" => "default", "error" => "Silex error", "message" => "An error accured<br /><br /><pre>" . $e . "</pre>");
        }

        return new JsonResponse($response);
    });

    $app->run();

?>
