<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Historical_alert;
use App\Products_entrie;
use Carbon\Carbon;

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
    protected $description = 'Este comando verifica datas de vencimento proximas';

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
      $searchs = Products_entrie::all();

      $br = new Carbon();
      //$br->subDay(2);

      $hist_alert = new Historical_alert();

      foreach ( $searchs as $search ) {
        //dd($search);
        if($br->diffInDays($search->data_validade) <= 2){
          if(Historical_alert::where('title', '=', 'vencimento')->where('product_id', '=', $search->produto_id)->count() == 0){
            $hist_alert->product_id = $search->produto_id;
            $hist_alert->title = "Vencimento";
            $hist_alert->description = $search->produtos->titulo.' possui lotes com vencimento proximo!!!';
            $hist_alert->save();
          }
        }
      }

    }
}
