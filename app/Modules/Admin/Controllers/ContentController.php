<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\Components\ColumnHeadersRow;
use Nayjest\Grids\Components\ColumnsHider;
use Nayjest\Grids\Components\FiltersRow;
use Nayjest\Grids\Components\HtmlTag;
use Nayjest\Grids\Components\Laravel5\Pager;
use Nayjest\Grids\Components\OneCellRow;
use Nayjest\Grids\Components\RecordsPerPage;
use Nayjest\Grids\Components\ShowingRecords;
use Nayjest\Grids\Components\TFoot;
use Nayjest\Grids\Components\THead;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use Illuminate\Support\Facades\Validator;
use App\Modules\Api\Models\PageModel;

class ContentController extends Controller {

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @return Response list Pages
   */
  public function getPages() {
    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider(PageModel::query())
        )
        ->setName('Pages')
//        ->setPageSize(5)
        ->setColumns([
          (new FieldConfig)
          ->setName('id')
          ->setLabel('ID')
          ->setSortable(true)
          ->setSorting(Grid::SORT_ASC)
          ,
          (new FieldConfig)
          ->setName('name')
          ->setLabel('Name')
          ->setSortable(true)
          ,
          (new FieldConfig)
          ->setName('title')
          ->setLabel('Title')
          ->setSortable(true)
          ,
          (new FieldConfig)
          ->setName('alias')
          ->setLabel('Alias')
          ->setSortable(true)
          ,
          (new FieldConfig)
          ->setName('sort')
          ->setLabel('Sort')
          ->setSortable(true)
          ,
          (new FieldConfig)
                ->setName('id')
                ->setLabel('Actions')
                ->setCallback(function ($val) {
                    return "<a href='".URL('admin/page/edit/'.$val)."'><span class='fa fa-pencil' title='Edit page'></span></a>&nbsp;&nbsp;<a href='".URL('admin/page/delete/'.$val)."' onclick=\"return confirm('Are you sure you want to delete this page?')\" title='Delete page'><span class='fa fa-trash'></span></a>";
                })
                ->setSortable(false)
                
            ,
        ])
        ->setComponents([
          (new THead)
          ->setComponents([
            (new ColumnHeadersRow),
            (new FiltersRow)
            ,
            (new OneCellRow)
            ->setRenderSection(RenderableRegistry::SECTION_END)
            ->setComponents([
              # Control for specifying quantity of records displayed on page
              (new RecordsPerPage)
              ->setVariants([
                5,
                10,
                20,
                30,
                40,
                50
              ])
              ,
              new ColumnsHider
              ,
              (new HtmlTag)
              ->setContent('<span class="glyphicon glyphicon-refresh"></span> Filter')
              ->setTagName('button')
              ->setRenderSection(RenderableRegistry::SECTION_END)
              ->setAttributes([
                'class' => 'btn btn-success btn-sm',
                'id' => 'formFilter'
              ])
            ])
          ])
          ,
          (new TFoot)
            ->setComponents([
                (new OneCellRow)
                    ->setComponents([
                        new Pager,
                        (new HtmlTag)
                            ->setAttributes(['class' => 'pull-right'])
                            ->addComponent(new ShowingRecords)
                        ,
                    ])
            ])
        ])
    );
    $grid = $grid->render();
    return view('Admin::pageManager', compact('grid'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create() {
    //
	$totalRow = PageModel::count();
    return view('Admin::pageNew', compact('totalRow'));
  }

  /**
   * create new page
   * @param string $alias 
   * @param string $name 
   * @param string $title 
   * @param string $keyword
   * @param string $description
   * @param string $metaDescription
   */
  public function postPage() {
    $validator = Validator::make(Input::all(), [
        'name' => 'Required|Max:255|Unique:pages',
        'alias' => 'Required|Max:255|alpha_dash|Unique:pages',
        'title' => 'Required|Max:255|Unique:pages',
        'keyword' => 'Max:160',
        'metaDescription' => 'Max:160',
        'description' => 'Required',
        'status' => 'Required',
        ]);
    //check current password

    if ($validator->fails()) {
      return Back()
          ->withErrors($validator)
          ->withInput();
    }
    
    $page = new PageModel();
    $page->name = Input::get('name');
    $page->alias = str_slug(Input::get('alias'));
    $page->title = Input::get('title');
    $page->keyword = Input::get('keyword');
    $page->metaDescription = Input::get('metaDescription');
    $page->description = Input::get('description');
    $page->status = Input::get('status');
	if(Input::has('sort')){
		$page->sort = Input::get('sort');
	}
    if($page->save()){
      return redirect('admin/page/edit/'.$page->id)->with('msgInfo', 'The page was successfully created.');
    }
    return Back()->with('msgInfo', 'System errors');
    
  }
  
  /**
   * edit page
   */
  public function getEditPage($id) {
    //
    $page = PageModel::find($id);
    if(!$page){
      return Redirect('admin/pages')->with('error', 'Page does not found.');
      
    }
    $totalRow = PageModel::count();
    return view('Admin::pageForm', compact('page', 'totalRow'));
  }
  
  /**
   * create new page
   * @param string $alias 
   * @param string $name 
   * @param string $title 
   * @param string $keyword
   * @param string $description
   * @param string $metaDescription
   */
  public function putEditPage($id) {
    $page = PageModel::find($id);
    
    if(!$page){
      return Redirect('admin/pages')->with('error', 'Page does not found.');
    }
    
    $validator = Validator::make(Input::all(), [
        'name' => 'Required|Max:255|Unique:pages,name,'.$id,
        'alias' => 'Required|Max:255|alpha_dash|Unique:pages,alias,'.$id,
        'title' => 'Required|Max:255|Unique:pages,title,'.$id,
        'keyword' => 'Max:160',
        'metaDescription' => 'Max:160',
        'description' => 'Required',
        'status' => 'Required',
        ]);
    //check current password

    if ($validator->fails()) {
      return Back()
          ->withErrors($validator)
          ->withInput();
    }
    
    
    $page->name = Input::get('name');
    $page->alias = str_slug(Input::get('alias'));
    $page->title = Input::get('title');
    $page->keyword = Input::get('keyword');
    $page->metaDescription = Input::get('metaDescription');
    $page->description = Input::get('description');
    $page->status = Input::get('status');
	if(Input::has('sort')){
		$page->sort = Input::get('sort');
	}
    if($page->save()){
      return Back()->with('msgInfo', 'The page was successfully updated.');
    }
    return Back()->with('msgInfo', 'System errors')->withInput();
    
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store() {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id) {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id) {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id) {
    //
  }

  public function deletePage($id){
    $page = PageModel::find($id);
    if(!$page){
      return Back()->with('msgError', 'Page does not found');
    }
    if($page->delete()){
      return Back()->with('msgInfo', 'The page was successfully deleted');
    }
    return Back()->with('msgError', 'System error.');
  }
}
