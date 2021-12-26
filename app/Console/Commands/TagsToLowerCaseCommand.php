<?php

namespace App\Console\Commands;

use App\Jobs\TagsToLowerCaseJob;
use Illuminate\Console\Command;

class TagsToLowerCaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tags:lowercase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Traverse all tags and sets them to lowercase';

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
     * @return int
     */
    public function handle()
    {
        dispatch(new TagsToLowerCaseJob);
        return 0;
    }
}
