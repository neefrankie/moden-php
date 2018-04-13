<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

// $config['db']['host'] = 'localhost';
// $config['db']['user'] = 'sampadm';
// $config['db']['pass'] = 'secret';
// $config['db']['dbname'] = 'sampdb';

$loader = new Twig_Loader_Filesystem('views');

$app = new \Slim\App(['settings' => $config]);
$container = $app->getContainer();
$container['logger'] = function ($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler('logs/app.log');
    $logger->pushHandler($file_handler);
    return $logger;
};
$container['view'] = new Twig_Environment($loader);

// $container['db'] = function ($c) {
//     $db = $c['settings']['db'];
//     $pdo = new PDO(
//         sprintf(
//             'mysql:host=%s;dbname=%s;port=3306;charset=utf8',
//             $db['host'],
//             $db['dbname']
//         ),
//         $db['user'],
//         $db['pass']
//     );

//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//     return $pdo;
// };

$app->get('/', function (Request $request, Response $response) {
    $body = $this->view->render('index.html');
    $response->getBody()->write($body);
});

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $this->logger->addInfo('Something interesting happened');
    $name = $args['name'];
    $body = $this->view->render('hello.html', [
        'name' => $name
    ]);
    $response->getBody()->write($body);

    return $response;
});

// $app->get('/user/{id}', function (Request $request, Response $response, array $args) {
//     $sql = 'SELECT user_name, email FROM cmstmp01.userinfo WHERE user_id = :id';
//     $stmt = $this->db->prepare($sql);
//     $id = $args['id'];
//     $stmt->bindValue(":id", $id);
//     $stmt->execute();

//     $result = $stmt->fetchAll();

//     $response->getBody()->write(json_encode($result[0]));

//     return $response;
// });

$app->run();
