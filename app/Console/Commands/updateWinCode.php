<?php

namespace App\Console\Commands;

use App\Models\Code;
use App\Models\UserCode;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class updateWinCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-wins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update wins';

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
        $redis = Redis::connection();
        $codes = Code::all();

        foreach($codes as $code) {
            $winsPhones = $redis->zrange('code:' . $code->code, 0, $code->quantity - 1);
            $this->line($code->code);
            foreach($winsPhones as $phone) {
                $this->info("phone:" . $phone);
                UserCode::updateOrCreate(['code_id' => $code->id, 'phone' => $phone], ['code_id' => $code->id, 'phone' => $phone]);
            }
        }
        return 0;
    }
}
