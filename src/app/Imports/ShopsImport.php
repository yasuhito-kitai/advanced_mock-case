<?php

namespace App\Imports;

use App\Models\Shop;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class ShopsImport implements ToModel, WithHeadingRow
{
    // エラーメッセージを格納する配列
    protected $errors = [];

    /**
     * モデルに変換
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // バリデーションルール
        $validator = Validator::make($row, [
            'name'  => 'required|string|max:50',
            'area_id'  => 'required|in:13,27,40',
            'genre_id'  => 'required|in:1,2,3,4,5',
            'image' => 'nullable|ends_with:jpeg,jpg,png',
        ]);

        // バリデーションが失敗した場合
        if ($validator->fails()) {
            // エラーメッセージを格納
            $this->errors[] = $validator->errors()->all();
            return null;  // バリデーションエラーがあった場合は null を返す
        }

        // バリデーションを通過したデータをShopモデルに保存
        return new Shop([
            'name'      => $row['name'],
            'user_id'   => $row['user_id'],
            'area_id'   => $row['area_id'],
            'genre_id'  => $row['genre_id'],
            'overview'  => $row['overview'],
            'image'     => $row['image'],
        ]);
    }

    /**
     * バリデーションエラーを取得するメソッド
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
