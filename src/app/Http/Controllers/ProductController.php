<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    /**
     * 商品一覧表示
     */
    public function index()
    {
        $products = Product::paginate(6);
        return view('products.index', compact('products'));
    }


    /**
     * 商品検索・並び替え
     */
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $sort = $request->input('sort');

        $query = Product::query();

        // 商品名部分一致
        if (!empty($keyword)) {
            $query->where('name', 'like', "%{$keyword}%");
        }

        // 並び替え（価格順）
        if ($sort === 'asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'desc') {
            $query->orderBy('price', 'desc');
        }

        $products = $query->paginate(6)->appends([
            'keyword' => $keyword,
            'sort' => $sort,
        ]);

        return view('products.index', compact('products', 'keyword', 'sort'));
    }

    /**
     * 商品詳細表示(編集画面も兼用)
     */
    public function show($id)
    {
        $product = Product::with('seasons')->findOrFail($id);
        $allSeasons = Season::all();

        return view('products.show', compact('product', 'allSeasons'));
    }


    /**
     * 商品登録画面表示
     */
    public function create()
    {
        $seasons = Season::all();
        return view('products.create', compact('seasons'));
    }

    /**
     * 商品登録処理
     */
    public function store(ProductRequest $request)
    {
        // 画像アップロード
        $path = $request->file('image')->store('img','public');
        
        // 登録
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $path,
            'description' => $request->description,
        ]);

        // 季節の紐付け（多対多）
        $product->seasons()->sync($request->input('season_ids', []));

        return redirect()->route('products.index');
    }

    /**
     * 商品更新処理
     */
    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $oldImage = $product->image;
        $product->fill($request->validated());

        // 画像更新処理
        if ($request->hasFile('image')) {
            // 新しい画像を保存
            $path = $request->file('image')->store('img', 'public');
            $product->image = $path;

            // 古い画像を削除
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
        }

        $product->save();

        // 季節リレーション更新
        $product->seasons()->sync($request->input('season_ids', []));

        return redirect()->route('products.index');
    }

    /**
     * 商品削除
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // 中間テーブルの関連削除
        $product->seasons()->detach();

        // 画像削除
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // 本体削除
        $product->delete();

        return redirect()->route('products.index');
    }
}