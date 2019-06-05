<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Historical_alert;

class NotificationsController extends Controller
{

    public function index(){
      if(Auth::check()){
        $hist_alerts = Historical_alert::paginate(6);
        $alerts_count = Historical_alert::all()->count('id');

        return view('alerts.notifications.index', compact('hist_alerts', 'alerts_count'));
      }else{
        return redirect('login');
      }
    }

    public function destroy($id){
      $alert = Alert::find($id);

      $alert->delete();

      return redirect('alerts')->with('alert-success', 'Alerta Deletado com Sucesso!!!');
    }

}
