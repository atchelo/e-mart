<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ZipArchive;

class MakeZip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:zip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will create zip of project (ONLY FOR DEVELOPERS) ';

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
        try {

            $pathdir = base_path('/');

// Enter the name to creating zipped directory
            $zipcreated = "emart.zip";

// Create new zip class
            $zip = new ZipArchive;

            if ($zip->open($zipcreated, ZipArchive::CREATE) === true) {

                // Store the path into the variable
                $dir = opendir($pathdir);

                while ($file = readdir($dir)) {
                    if (is_file($pathdir . $file)) {
                        $zip->addFile($pathdir . $file, $file);
                    }
                }
                $zip->close();
            }

            // $file->move(base_path('/'), $zipcreated);

            $this->info('Done !');

        } catch (\Exception $e) {

            die($e->getMessage());

        }
    }
}
