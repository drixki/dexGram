<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Fungsi untuk menampilkan halaman kategori
     *
     * @return void
     */
    public function index()
    {
        $category = Category::query()
            ->whereUser_id(Auth::user()->id)
            ->get();
        return view('category', compact('category'));
    }

    /**
     * Fungsi untuk menampilkan halaman create category
     *
     * @return void
     */
    public function create()
    {
        return view('form-category');
    }

    /**
     * Fungsi untuk menampilkan halaman edit category
     *
     * @param  mixed $category
     * @return void
     */
    public function edit(string $id)
    {
        $category = Category::query()
            ->find(decrypt($id));
        return view('form-category', compact('category'));
    }

    /**
     * Fungsi untuk menambah kategori
     *
     * @param  mixed $request
     * @return void
     */
    public function post(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
            'description' => 'nullable'
        ]);

        Category::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('my-category')->with('success', 'Berhasil menambah kategori');
    }

    /**
     * Fungsi untuk mengubah kategori
     *
     * @param  mixed $request
     * @param  mixed $category
     * @return void
     */
    public function update(Request $request, Category $category)
    {

        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
            'description' => 'nullable'
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        $category->save();

        return redirect()->route('my-category')->with('success', 'Berhasil mengubah kategori');
    }

    /**
     * Fungsi untuk hapus kategori
     *
     * @param  mixed $category
     * @return void
     */
    public function delete(Category $category)
    {
        if ($category->photos()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Ada foto dengan kategori ini.'
            ]);
        } else {
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus'
            ]);
        }
    }
}
