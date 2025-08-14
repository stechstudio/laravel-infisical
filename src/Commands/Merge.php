<?php

namespace STS\Infisical\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;
use STS\Infisical\Facades\Infisical;

class Merge extends Command
{
    protected $signature = 'infisical:merge {env? : Infisical environment slug}';

    protected $description = 'Retrieve and merge Infisical environment variables onto the .env file';

    public function handle()
    {
        $environment = Infisical::environment($this->argument('env'));

        $result = Process::run(array_filter([
            'infisical',
            'export',
            "--env=$environment",
            config('infisical.token') ? "--token=".config('infisical.token') : null,
        ]));

        if (!$result->successful()) {
            $this->error('Failed to export environment variables from Infisical.');
            $this->error($result->errorOutput());
            return 1;
        }

        // Do a quick sanity check on the output
        if (!Str::contains($result->output(), 'APP_KEY')) {
            $this->error('Infisical did not provide an APP_KEY, which is required for Laravel apps.');
            return 1;
        }

        // Base .env file is optional, but if it exists, we will merge with it
        $env = file_exists(base_path('.env'))
            ? file_get_contents(base_path('.env'))
            : '';

        // Cleanup existing Infisical variables if they exist
        $env = trim(preg_replace('/# ----- INFISICAL ENV BELOW -----.*$/s', '', $env));

        $output = $env."\n\n# ----- INFISICAL ENV BELOW -----\n\n".$result->output();

        file_put_contents(base_path('.env'), $output);

        $this->info("Environment [$environment] variables merged successfully.");
    }
}