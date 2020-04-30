<?php

namespace App\Http\Controllers\Document;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use DB;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('documents_manage')) {
            return abort(500);
        }

        $categories = Category::all();

        return view('documents.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('documents.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_name' => 'required|unique:categories',
        ]);

        $one = new Category;
        $one->category_name = $data['category_name'];
        $one->save();

        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);

        return view('documents.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'category_name' => 'required|unique:categories,category_name,'.$request->category_name,
        ]);

        $one = Category::find($id);
        $one->category_name = $data['category_name'];
        $one->save();

        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $one = Category::find($id);

        $documents = DB::table('documents')->where('category_id', $id);
        $arrDoc = array();
        foreach ($documents->get() as $document) {
            array_push($arrDoc, $document->id);
        }
        DB::table('documents_revision')->whereIn('docu_id', $arrDoc)->delete();
        DB::table('notifications')->whereIn('docu_id', $arrDoc)->delete();
        $documents->delete();

        $one->delete();
    }
}
