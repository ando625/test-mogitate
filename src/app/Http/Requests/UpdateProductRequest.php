<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product; 

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
     public function rules()
    {
        // ルートパラメータから productId を取得
        $productId = $this->route('productId');
        $product = $productId ? Product::find($productId) : null;

        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0|max:10000',
            'seasons' => 'required|array',
            'seasons.*' => 'integer|exists:seasons,id',
            'description' => 'required|string|max:120',
            // 更新時は既存画像があれば nullable、それ以外は必須
            'image' => $product && $product->image
                ? 'nullable|image|mimes:png,jpeg,jpg'
                : 'required|image|mimes:png,jpeg,jpg',
        ];
    }

    /**
     * Custom error messages for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.numeric' => '数値で入力してください',
            'price.min' => '0~10000円以内で入力してください',
            'price.max' => '0~10000円以内で入力してください',
            'seasons.required' => '季節を選択してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
            
            'image.required' => '商品画像を登録してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
        ];
    }
}
