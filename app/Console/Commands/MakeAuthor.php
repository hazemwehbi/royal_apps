<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Author;

class MakeAuthor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:author {--name=} {--phone=} {--birthday=} {--address=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make An Author';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Author::create([
            'name' =>  $this->option('name'),
            'phone' =>  $this->option('phone'),
            'birthday' =>  $this->option('birthday'),
            'address' =>  $this->option('address')
        ]);
        
      echo "You added Author Successfully"; 
    }
}
