<?php

namespace App\Listeners;

use App\Events\OutputProduct;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Alert;
use App\Historical_alert;

class AlertStockMin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  OutputProduct  $event
     * @return void
     */
    public function handle(OutputProduct $event)
    {
          $id = $event->product->id;

          $name = $event->product->titulo;
          $amount = $event->product->quantidade_total;

          //se o produto não possuir nenhuma regra de alerta --- sair
          if(!Alert::where('product_id', '=', $id)->exists()){
            return null;
          }

          $alert = Alert::where('product_id', '=', $id)->get();

          $stock_min = $alert[0]->stock_min;

              if($amount <= $stock_min){

                $update = Historical_alert::where('title','Estoque Baixo')
                ->where('alert_id', '=', $alert[0]->id)
                ->first();

                if($update){
                    $hist_alert = Historical_alert::find($update->id);
                    $hist_alert->alert_id = $alert[0]->id;
                    $hist_alert->title = "Estoque Baixo";
                    $hist_alert->description = $name.' está com estoque baixo!!!';
                }else{
                    $hist_alert = new Historical_alert();
                    $hist_alert->alert_id = $alert[0]->id;
                    $hist_alert->title = "Estoque Baixo";
                    $hist_alert->description = $name.' está com estoque baixo!!!';
                }

                if($hist_alert->save()){
                  return redirect('/')->with('alert-toastr', 'O item '.$name.' está com estoque baixo!!!');
                }
              }
    }
}
