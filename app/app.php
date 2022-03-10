<?php

/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

/**
 * Add your routes here
 */
$app->get('/', function () {
    echo $this['view']->render('index');
});

/**
 * Not found handler
 */
$app->notFound(function () use($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo $app['view']->render('404');
});

// Retrieves all robots
$app->get(
    "/api/userLike/{id}",
    function ($id) use ($app) {
        $phql = "SELECT * FROM OneUserLikes WHERE user_id = :user_id: order by id DESC LIMIT 10";

        $params = [
            'user_id' => $id
        ];

        $userLikes = $app->modelsManager->executeQuery($phql, $params);

        $data = [];

        foreach ($userLikes as $userLike) {
            $data[] = [
                "id"   => $userLike->id,
                "user_id"   => $userLike->user_id,
                "article_id" => $userLike->article_id,
            ];
        }

        $response = [
            'code' => 200,
            'message' => '请求正常',
            'data' => $data
        ];
        
        echo json_encode($response);
    }
);