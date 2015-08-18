<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Task.php";
    require_once __DIR__."/../src/Category.php";

    $app = new Silex\Application();
    $app["debug"] = true;

    $server = 'mysql:host=localhost;dbname=to_do';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    date_default_timezone_set("UTC");

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig',
            array('categories' => Category::getAll()));
    });

    $app->post("/tasks", function() use ($app) {
        $description = $_POST["description"];
        $category_id = $_POST["category_id"];
        $due_date = date($_POST["due_date"]);
        $task = new Task($description, $id = null, $category_id, $due_date);
        $task->save();
        $category = Category::find($category_id);
        return $app["twig"]->render("category.html.twig",
            array("category" => $category, "tasks" =>
            $category->getTasks()));
    });

    $app->get("/categories/{id}", function($id) use ($app) {
        $category = Category::find($id);
        return $app['twig']->render('category.html.twig',
            array('category' => $category, 'tasks' =>
            $category->getTasks()));
    });

    $app->post("/deleted_tasks", function() use ($app) {
        Task::deleteAll();
        return $app['twig']->render('index.html.twig',
            array('categories' => Category::getAll()));
    });

    $app->post("/categories", function() use ($app) {
        $category = new Category($_POST["name"]);
        $category->save();
        return $app["twig"]->render("index.html.twig",
            array("categories" => Category::getAll()));
    });

    $app->post("/deleted_categories", function() use ($app) {
        Category::deleteAll();
        return $app['twig']->render('index.html.twig',
            array('categories' => Category::getAll()));
    });

    return $app;
 ?>
