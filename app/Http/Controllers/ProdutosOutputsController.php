<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Produtos;
use App\Products_entrie;
use App\ProductsOutput;
use App\Events\OutputProduct;
use App\Events\SystemLogin;
use App\Historical_alert;

class ProdutosOutputsController extends Controller
{
    //
    public function index(){
      if(Auth::check()){
        $products = Produtos::all();
        $products_output = ProductsOutput::paginate(6);
        $alerts_count = Historical_alert::all()->count('id');

        return view('produtos_outputs.index', array('products_output'=> $products_output, 'products'=> $products , 'buscar' => null, 'alerts_count'=>$alerts_count));
      }else{
        return redirect('login');
      }
    }

    public function create(){
      if(Auth::check()){
        $products = Produtos::all();
        $alerts_count = Historical_alert::all()->count('id');

        return view('produtos_outputs.create', compact('products', 'alerts_count'));
      }else{
        return redirect('login');
      }
    }

public function store(Request $request){

  $this->validate($request, [
    'produto'=>'required',
    'nota'=>'required|min:3|max:50',
    'quantidade'=>'required|Integer|min:1',
  ]);

  $prod = $request->input('produto');
  $qtd_output  = $request->input('quantidade');

  $products = Produtos::find($prod);

  //validação: saída supera estoque total
  if($qtd_output > $products->quantidade_total && $products->quantidade_total != 0){
      return redirect('produtos_outputs/create')->with('danger', "Não foi possível realizar a saída, a quantidade supera o estoque total!!! Estoque total é de: ".$products->quantidade_total.' item');
  }else if($products->quantidade_total == 0){
      return redirect('produtos_outputs/create')->with('danger', "Não foi possível realizar a saída, o estoque está zerado!!!");
  }

  //retirando do estoque total
  $products->quantidade_total = $products->quantidade_total - $qtd_output;
  $products->save();

  // Dispatching Event
      event(new OutputProduct($products));

  //fim
    while(1){

      $products_entrie = Products_entrie::where('produto_id', '=', $prod)
      ->where('status_output', '<>', '1')
      ->orderBy('data_validade', 'ASC')
      ->first();

      if($qtd_output > ($products_entrie->qtd_entrada)){

            $qtd_output = $qtd_output - $products_entrie->qtd_entrada;

            $products_entrie->qtd_entrada = 0;
            $products_entrie->status_output = 1;
            $products_entrie->save();

      }else if($qtd_output < ($products_entrie->qtd_entrada) || $qtd_output == ($products_entrie->qtd_entrada)){

            $products_entrie->qtd_entrada = $products_entrie->qtd_entrada - $qtd_output;
            $qtd_output = 0;

            //caso seja retirada totalmente a quantidade existente
            if($products_entrie->qtd_entrada == 0){
                $products_entrie->status_output = 1;
            }else{
                $products_entrie->status_output = 2;
            }
            $products_entrie->save();
            break;
      }
    }

    //salvando saída
    $produto = new ProductsOutput();
    $produto->product_id = $request->input('produto');
    $produto->note = $request->input('nota');
    $produto->amount = $request->input('quantidade');
    $produto->date_output = now();

    if($produto->save()){
      return redirect('produtos_outputs/')->with('alert-success', 'Saída Realizada com Sucesso!!!');
    }
  }

    public function edit($id){
      if(Auth::check()){

      $products = Produtos::all();
      $products_output = ProductsOutput::find($id);
      $alerts_count = Historical_alert::all()->count('id');

      return view('produtos_outputs.edit', compact('products', 'id', 'products_output', 'alerts_count'));

      }else{
        return redirect('login');
      }
    }

    public function update(Request $request, $id){

      $produto = ProductsOutput::find($id);

      //$this->authorize('update-produto', $produto);

      $this->validate($request, [
        'produto'=>'required',
        'nota'=>'required|min:3|max:50',
        'quantidade'=>'required|Integer',
      ]);

      $produto->product_id = $request->get('produto');
      $produto->note = $request->get('nota');
      $produto->amount = $request->get('quantidade');
      $produto->date_output = now();

      if($produto->save()){
        return redirect('produtos_outputs/')->with('alert-success', 'Saída Editada com Sucesso!!!');
      }
    }

    public function destroy($id){
      $produto = ProductsOutput::find($id);
      $produto->delete();
      return redirect('produtos_outputs')->with('alert-success', 'Saída Deletada com Sucesso!!!');//modificado
    }

    public function busca(Request $request){

      $alerts_count = Historical_alert::all()->count('id');
      $product = Produtos::all();

      $dataInicial = $request->input('dataInicial').' 00:00:00';
      $dataFinal   = $request->input('dataFinal').' 00:00:00';
      $produto     = $request->input('produto');

      $busca = ProductsOutput::where( 'product_id', '=',  $produto)
      ->whereBetween('created_at',[$dataInicial, $dataFinal])
      ->paginate(6);

      return view('produtos_outputs.index', array('products_output'=> $busca, 'products'=> $product, 'alerts_count'=> $alerts_count));
    }
}
