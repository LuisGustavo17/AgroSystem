<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Historical_alert;
class Alertas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Alertas:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando verifica e informa os alertas do sistema';

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
      $hist_alert = new Historical_alert();
      $hist_alert->alert_id = 1;
      $hist_alert->title = "Estoque Baixo";
      $hist_alert->description = 'está com estoque baixosadfsdf!!!';
      $hist_alert->save();
    }
}
