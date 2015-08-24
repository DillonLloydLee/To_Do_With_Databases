<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Task.php";
    require_once "src/Category.php";

    $server = "mysql:host=localhost;dbname=to_do_test";
    $username = "root";
    $password = "root";
    $DB = new PDO($server, $username, $password);

    class TaskTest extends PHPUnit_Framework_TestCase {

        protected function tearDown() {
            Task::deleteAll();
            Category::deleteAll();
        }

        function test_getId() {
            $name = "Home stuff";
            $id = null;
            $due_date = '0000-00-00';
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $test_task = new Task($description, $id, $due_date);
            $test_task->save();

            $result = $test_task->getId();

            $this->assertEquals(true, is_numeric($result));
        }

        function test_save() {
            $name = "Home stuff";
            $id = null;
            $due_date = '0000-00-00';
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $test_task = new Task($description, $id, $due_date);

            $test_task->save();

            $result = Task::getAll();
            $this->assertEquals($test_task, $result[0]);
        }
        function test_getAll() {
            $name = "Home stuff";
            $id = null;
            $due_date = '0000-00-00';
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $test_task = new Task($description, $id, $due_date);
            $test_task->save();

            $description2 = "Water the lawn";
            $test_task2 = new Task($description2, $id, $due_date);
            $test_task2->save();

            $result = Task::getAll();

            $this->assertEquals([$test_task, $test_task2], $result);
        }
        function test_deleteAll() {

            $name = "Home stuff";
            $id = null;
            $due_date = '0000-00-00';
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $test_task = new Task($description, $id, $due_date);
            $test_task->save();

            $description2 = "Water the lawn";
            $test_task2 = new Task($description2, $id, $due_date);
            $test_task2->save();

            Task::deleteAll();

            $result = Task::getAll();
            $this->assertEquals([], $result);
        }

        function test_find() {
            $name = "Home stuff";
            $id = null;
            $due_date = '0000-00-00';
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $test_task = new Task($description, $id, $due_date);
            $test_task->save();

            $description2 = "Water the lawn";
            $test_task2 = new Task($description2, $id, $due_date);
            $test_task2->save();

            $result = Task::find($test_task->getId());

            $this->assertEquals($test_task, $result);
        }

        function test_getDueDate() {
            $name = "Home stuff";
            $id = null;
            $due_date = "1984-02-32";
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $test_task = new Task($description, $id, $due_date);
            $test_task->save();

            $result = $test_task->getDueDate();

            $this->assertEquals("1984-02-32", $result);
        }

        function test_update()
        {
            $description = "Wash the dog";
            $id = 1;
            $due_date = "2015-08-24";
            $test_task = new Task($description, $id, $due_date);
            $test_task->save();

            $new_description = "Clean the dog";

            $test_task->update($new_description);

            $this->assertEquals("Clean the dog", $test_task->getDescription());
        }

        function testDeleteTask()
        {
            $description = "Wash the dog";
            $id = 1;
            $due_date = "2015-08-24";
            $test_task = new Task($description, $id, $due_date);
            $test_task->save();

            $description2 = "Water the lawn";
            $id2 = 2;
            $due_date2 = "2015-08-25";
            $test_task2 = new Task ($description2, $id2, $due_date2);
            $test_task2->save();

            $test_task->delete();

            $this->assertEquals([$test_task2], Task::getAll());
        }

        function test_addCategory() {
            $name = "Work Stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "File Reports";
            $id2 = 2;
            $due_date = '0000-00-00';
            $test_task = new Task($description, $id2, $due_date);
            $test_task->save();

            $test_task->addCategory($test_category);

            $this->assertEquals($test_task->getCategories(), [$test_category]);
        }

        function test_getCategories() {
            $name = "Work Stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $name2 = "Volunteer Stuff";
            $id2 = 3;
            $test_category2 = new Category($name2, $id2);
            $test_category2->save();

            $description = "File Reports";
            $id2 = 2;
            $due_date = '0000-00-00';
            $test_task = new Task($description, $id2, $due_date);
            $test_task->save();

            $test_task->addCategory($test_category);
            $test_task->addCategory($test_category2);

            $this->assertEquals($test_task->getCategories(), [$test_category, $test_category2]);
        }

        function testDelete()
        {
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "File reprts";
            $id2 = 2;
            $due_date = '0000-00-00';
            $test_task = new Task($description, $id2, $due_date);
            $test_task->save();

            $test_task->addCategory($test_category);
            $test_task->delete();

            $this->assertEquals([], $test_category->getTasks());
        }

        function test_completeToggle() {
            $description = "File reprts";
            $id2 = 2;
            $due_date = '0000-00-00';
            $test_task = new Task($description, $id2, $due_date);
            $test_task->save();

            $result = $test_task->completeToggle();

            $this->assertEquals("true", $result);
        }


    }















 ?>
