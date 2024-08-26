<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RepositoyCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {repository} {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new repository class';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {

        $repository = $this->argument('repository');
        $model = $this->argument('model');
        $data = '$data';
        $id = '$id';
        $item = '$item';
        $path = $this->appPath($repository);
        $this->createDir($path);
        if (File::exists($path)) {
            $this->error("File {$path} already exists!");

            return;
        }
        $content = '<?php'.PHP_EOL
            .'namespace App\Http\Repository;'.PHP_EOL
            // . "use App\Models\{$model};" . PHP_EOL
            ."class {$repository} {".PHP_EOL
            .'    // Add your custom code here'.PHP_EOL
            ."

            public function store(array $data): {$model}
            {
                return {$model}::create([$data]);
            }

            public function update(int $id, array $data): {$model}
            {
                {$item} = {$model}::find($id);
                {$item}->update([$data]);
                return {$item};
            }
            ".PHP_EOL
            .'}';
        File::put($path, $content);
        $this->info("File {$path} created.");
    }

    /**
     * Get the view full path.
     *
     * @param  string  $view
     * @return string
     */
    public function appPath($repository)
    {
        $repository = str_replace('.', '/', $repository).'.php';
        $path = "app/Http/Repository/{$repository}";

        return $path;
    }

    /**
     * Create view directory if not exists.
     */
    public function createDir($path)
    {
        $dir = dirname($path);
        if (! file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }
}
