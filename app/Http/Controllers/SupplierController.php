<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Produtos;
use App\Categories;
use App\Supplier;
use App\Historical_alert;

class SupplierController extends Controller
{
    //
    public function index(){
      if(Auth::check()){
        $suppliers = Supplier::paginate(6);
        $alerts_count = Historical_alert::whereNull('read_in')->count('id');

        return view('supplier.index', compact('suppliers', 'alerts_count'));
      }else{
        return redirect('login');
      }
    }

    public function create(){
      if(Auth::check()){
        $alerts_count = Historical_alert::whereNull('read_in')->count('id');
        return view('supplier.create', compact('alerts_count'));
      }else{
        return redirect('login');
      }
    }

    public function store(Request $request){
      $this->validate($request, [
        'nome'=>'required|String|min:2',
        'email'=>'required|E-Mail',
        'telefone'=>'required|Numeric|min:8',
        'endereco'=>'required|String|min:8',
        'cnpj'=>'required|Numeric',
      ]);

      $supplier = new Supplier();
      $supplier->name = $request->input('nome');
      $supplier->email = $request->input('email');
      $supplier->phone = $request->input('telefone');
      $supplier->address = $request->input('endereco');
      $supplier->cnpj = $request->input('cnpj');

      if($supplier->save()){
        return redirect('supplier/')->with('alert-success', 'Fornecedor Cadastrado com Sucesso!!!');
      }
    }

    public function edit($id){
      if(Auth::check()){
        $suppliers = Supplier::find($id);
        $alerts_count = Historical_alert::whereNull('read_in')->count('id');
        return view('supplier.edit', compact('suppliers', 'id', 'alerts_count'));
      }else{
        return redirect('login');
      }
    }

    public function update(Request $request, $id){

      $supplier = Supplier::find($id);

      $this->validate($request, [
        'nome'=>'required|String|min:2',
        'email'=>'required|E-Mail',
        'telefone'=>'required|Numeric|min:8',
        'endereco'=>'required|String|min:8',
        'cnpj'=>'required|Numeric',
      ]);

      $supplier->name = $request->get('nome');
      $supplier->email = $request->get('email');
      $supplier->phone = $request->get('telefone');
      $supplier->address = $request->input('endereco');
      $supplier->cnpj = $request->get('cnpj');

      if($supplier->save()){
        return redirect('supplier/')->with('alert-success', 'Fornecedor Atualizado com Sucesso!!!');
      }
    }

    public function destroy($id){
      $supplier = Supplier::find($id);

      $supplier->delete();
      return redirect('supplier')->with('alert-success', 'Fornecedor Deletado com Sucesso!!!');
    }

}
