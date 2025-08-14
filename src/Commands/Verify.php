<?php

namespace STS\Infisical\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;
use STS\Infisical\Facades\Infisical;

class Verify extends Command
{
    protected $signature = 'infisical:verify {env? : Infisical environment slug}';

    protected $description = 'Verify we can connect to Infisical and retrieve environment variables';

    public function handle()
    {
        $result = Process::run(array_filter([
            'infisical',
            'secrets',
            'get',
            'APP_KEY',
            '--plain',
            "--env=".Infisical::environment($this->argument('env')),
            config('infisical.token') ? "--token=".config('infisical.token') : null,
        ]));

        if ($result->successful() && !empty($result->output())) {
            $this->info('Successfully connected to Infisical and retrieved APP_KEY.');
            return 0;
        }

        if ($result->successful() && empty($result->output())) {
            $this->warn('Successfully connected to Infisical but APP_KEY appears to be missing. Ensure APP_KEY is set in your Infisical environment.');
            return 1;
        }

        $this->error('Failed to export environment variables from Infisical.');
        $this->error($result->errorOutput());
        return 1;
    }
}