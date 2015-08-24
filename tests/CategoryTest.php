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
            Task::deleteAll();
        }
        function testGetTasks() {
            $name = "Work stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $due_date = '0000-00-00';

            $description = "Email client";
            $test_task = new Task($description, $id, $due_date);
            $test_task->save();

            $description2 = "Meet with boss";
            $test_task2 = new Task($description2, $id, $due_date);
            $test_task2->save();

            $test_category->addTask($test_task);
            $test_category->addTask($test_task2);

            $this->assertEquals($test_category->getTasks(),
            [$test_task, $test_task2]);
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

        function test_update() {
            $name = "Work Stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $test_category->update("Home Stuff");

            $this->assertEquals("Home Stuff", $test_category->getName());
        }

        function test_deleteCategory() {
            $name = "Work Stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $name2 = "Home Stuff";
            $id2 = 2;
            $test_category2 = new Category($name2, $id2);
            $test_category2->save();

            $test_category->delete();

            $this->assertEquals([$test_category2], Category::getAll());
        }

        function test_addTask() {
            $name = "Work Stuff!!!!!";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "File repoooorts";
            $id2 = 2;
            $due_date = '0000-00-00';
            $test_task = new Task($description, $id2, $due_date);
            $test_task->save();

            $test_category->addTask($test_task);

            $this->assertEquals($test_category->getTasks(), [$test_task]);
        }

        function testDelete()
        {
            $name = "wWOrkd styuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "File reports";
            $id2 = 2;
            $due_date = '0000-00-00';
            $test_task = new Task ($description, $id2, $due_date);
            $test_task->save();

            $test_category->addTask($test_task);
            $test_category->delete();

            $this->assertEquals([], $test_task->getCategories());

        }
    }
 ?>
