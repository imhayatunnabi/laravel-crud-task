<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ServiceCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {service} {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new service class';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {

        $service = $this->argument('service');
        $model = $this->argument('model');
        $data = '$data';
        $id = '$id';
        $item = '$item';
        $path = $this->appPath($service);
        $this->createDir($path);
        if (File::exists($path)) {
            $this->error("File {$path} already exists!");

            return;
        }
        $content = '<?php'.PHP_EOL
            .'namespace App\Http\Service;'.PHP_EOL
            // . "use App\Models\{$model};" . PHP_EOL
            ."class {$service} {".PHP_EOL
            .'    // Add your custom code here'.PHP_EOL
            ."

            public function store(array $data): {$model}
            {
                return {$model}::create($data);
            }

            public function update(int $id, array $data): {$model}
            {
                {$item} = {$model}::find($id);
                {$item}->update($data);
                return {$item};
            }  ".PHP_EOL
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
    public function appPath($service)
    {
        $service = str_replace('.', '/', $service).'.php';
        $path = "app/Http/Service/{$service}";

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
