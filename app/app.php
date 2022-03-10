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
        $phql = "SELECT * FROM OneUserLikes order by id DESC LIMIT 10";

        $userLikes = $app->modelsManager->executeQuery($phql);

        $data = [];

        foreach ($userLikes as $userLike) {
            $data[] = [
                "id"   => $userLike->id,
                "user_id"   => $userLike->user_id,
                "article_id" => $userLike->article_id,
            ];
        }

        echo json_encode($data);
    }
);