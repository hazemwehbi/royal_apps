<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Book;

use App\Author;

class MakeBook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:book {title} {author_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make A Book';

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
      $author = Author::where('name',$this->argument('author_name'))->first();
      
      
      Book::create([
            'title' => $this->argument('title'),
            'author_id' => $author['id']
        ]);
        
      echo "You added Book Successfully"; 
    }
}
