<?php

class TestsFinished_Task
{
    public function __construct()
    {
        Bundle::start('composer');
    }

    public function run($arguments)
    {
        print date("Y-m-d H:i:s") . " | Running testsfinished\n";
        foreach (IoC::resolve('queue')->get_test_results() as $result) {
            print date("Y-m-d H:i:s") . " | Found finished test " . $result->id . "\n";
            $test = Test::find($result->id);

            $test->passing = (int)((bool)$result->passed);
            $test->last_run = date('Y-m-d H:i:s');
            $test->save();
            $screenshot = $result->screenshot;

            Test\Log::create(array(
                'test_id' => $test->id,
                'message' => $result->msg,
                'passed' => $result->passed,
                'screenshot' => $screenshot,
            ));

            IoC::resolve('queue')->remove_queued_test($test->id);
            $test->notify();
        }
        exit(0);
    }    
}