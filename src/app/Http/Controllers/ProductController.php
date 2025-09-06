<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\RegisterProductRequest;

class ProductController extends Controller
{
    // 商品一覧
    public function index(Request $request)
{
    $query = Product::query();

    // 検索
    if ($request->search) {
        $query->where('name', 'like', "%{$request->search}%");
    }
    // ソート
    if ($request->sort === 'high') {
        $query->orderBy('price', 'desc');
    } elseif ($request->sort === 'low') {
        $query->orderBy('price', 'asc');
    }

    $products = $query->paginate(6)->appends($request->query());

    // Bladeにsearchも渡す
    return view('products.index', compact('products', 'request'));
}

    // 商品詳細兼編集
    public function show($productId)
{
    $product = Product::with('seasons')->findOrFail($productId);
    $seasons = Season::all();

    // 商品に紐づいている季節IDを配列に変換
    $selectedSeasons = $product->seasons->pluck('id')->toArray();

    // old() があればそれを優先、なければ $selectedSeasons を使う
    $selectedSeasons = old('seasons', $selectedSeasons);

    return view('products.show', compact('product', 'seasons', 'selectedSeasons'));
}

    // 商品更新
    public function update(UpdateProductRequest $request, $productId)
    {
        $product = Product::findOrFail($productId);

        // 基本情報更新
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;

        // 画像アップロード処理
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->save();

        $product->seasons()->sync($request->seasons);

        return redirect()->route('products.index');
    }

    // 商品登録フォーム
    public function create()
    {
        $seasons = Season::all();
        return view('products.register', compact('seasons'));
    }

    // 商品登録処理
    public function store(RegisterProductRequest $request)
    {
        $data = $request->only(['name', 'price', 'description']);

        // 画像アップロード
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        $product = Product::create($data);

        // 多対多リレーション保存
        $product->seasons()->sync($request->seasons);

        return redirect()->route('products.index')->with('success', '商品を登録しました');
    }

    

    // 削除
    public function destroy($productId)
    {
        $product = Product::findOrFail($productId);
        $product->delete();
        return redirect()->route('products.index')->with('success', '商品を削除しました');
    }
}