<?php

namespace App\Http\Controllers;

use App\Imports\ShopsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;



class CsvImportController extends Controller
{
    public function import(Request $request)
    {

        // ファイルのバリデーション
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        try {
            // アップロードされたファイルを取得
            $file = $request->file('csv_file');

            // ファイルのパスを取得
            $path = $file->getRealPath();

            // ShopsImportインスタンスを作成
            $import = new ShopsImport();

            // CSVをインポート（ファイルパスを渡す）
            Excel::import($import, $file);

            // エラーメッセージがあればビューに渡す
            $errors = $import->getErrors();
            if (!empty($errors)) {
                return back()->withErrors($errors)->withInput();
            }

            // 成功メッセージ
            return back()->with('success', 'CSVデータをインポートしました。');
        } catch (\Exception $e) {
            dd($e->getMessage());
            // その他のエラーをキャッチ（バリデーション以外）
            return back()->with('error', 'エラーが発生しました。もう一度お試しください。' . $e->getMessage());
        }
    }
}
