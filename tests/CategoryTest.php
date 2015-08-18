<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Category.php";
    require_once "src/Task.php";

    $server = 'mysql:host=localhost;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CategoryTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown() {
            Category::deleteAll();
        }
        function testGetTasks()
        {
            $name = "Work stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $test_category_id = $test_category->getId();

            $description = "Email client";
            $test_task = new Task($description, $id, $test_category_id);
            $test_task->save();

            $description2 = "Meet with boss";
            $test_task2 = new Task($description2, $id, $test_category_id);
            $test_task2->save();

            $result = $test_category->getTasks();

            $this->assertEquals([$test_task, $test_task2], $result);
        }
        function test_getName()
        {
            $name = "Work stuff";
            $test_category = new Category($name);

            $result = $test_category->getName();

            $this->assertEquals($name, $result);
        }
        function test_save() {
            $name = "Work stuff";
            $test_category = new Category($name);
            $test_category->save();

            $result = Category::getAll();

            $this->assertEquals($test_category, $result[0]);
        }
        function test_getAll() {
            $name = "Work stuff";
            $name2 = "Home stuff";
            $test_category = new Category($name);
            $test_category->save();
            $test_category2 = new Category($name2);
            $test_category2->save();

            $result = Category::getAll();

            $this->assertEquals([$test_category, $test_category2], $result);
        }
        function test_deleteAll() {
            $name = "Wash the dog";
            $name2 = "Home stuff";
            $test_category = new Category($name);
            $test_category->save();
            $test_category2 = new Category($name2);
            $test_category2->save();

            Category::deleteAll();
            $result = Category::getAll();

            $this->assertEquals([], $result);
        }
        function test_find() {
            $name = "Wash the dog";
            $name2 = "Home stuff";
            $test_category = new Category($name);
            $test_category->save();
            $test_category2 = new Category($name2);
            $test_category2->save();

            $result = Category::find($test_category->getId());

            $this->assertEquals($test_category, $result);
        }
    }
 ?>
