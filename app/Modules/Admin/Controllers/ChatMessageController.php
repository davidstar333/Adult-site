<?php

  namespace App\Modules\Admin\Controllers;

  use App\Http\Controllers\Controller;
  use App\Modules\Api\Models\UserModel;
  use App\Modules\Api\Models\ChatMessageModel;
  
  use Nayjest\Grids\Components\Base\RenderableRegistry;
  use Nayjest\Grids\Components\ColumnHeadersRow;
  use Nayjest\Grids\Components\ColumnsHider;
  use Nayjest\Grids\Components\CsvExport;
  use Nayjest\Grids\Components\ExcelExport;
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
  use Nayjest\Grids\FilterConfig;
  use Nayjest\Grids\SelectFilterConfig;
  use Nayjest\Grids\Grid;
  use Nayjest\Grids\GridConfig;

  class ChatMessageController extends Controller {

      /**
       * @author Phong Le <pt.hongphong@gmail.com>
       * @return Response list categories
       */
      public function getMessages($id) {
          $query = UserModel::select('users.username', 'users.role', 'c.text', 'c.tip', 'c.type', 'c.id')
                  ->join('chatmessages as c', 'c.ownerId', '=', 'users.id')
                  ->join('chatthreads as t', 't.id', '=', 'c.threadId')
                  ->where('c.tip', ChatMessageModel::TIP_NO)
                  ->where('t.ownerId', $id);


          $grid = new Grid(
                  (new GridConfig)
                          ->setDataProvider(
                                  new EloquentDataProvider($query)
                          )
                          ->setName('Models')
                          ->setPageSize(10)
                          ->setColumns([
                              (new FieldConfig)
                              ->setName('id')
                              ->setLabel('<input type="checkbox" name="checklist[]" class="check-all">')
                              ->setCallback(function ($val) {
                                          return '<input type="checkbox" name="checklist[]" class="case" value="' . $val . '">';
                                      })
                              ->setSortable(false)
                              ,
                              (new FieldConfig)
                              ->setName('id')
                              ->setLabel('ID')
                              ->setSortable(true)
                              ->setSorting(Grid::SORT_ASC)
                              ,
                              (new FieldConfig)
                              ->setName('username')
                              ->setLabel('Username')
                              ->setCallback(function ($val) {
                                          return "<span class='glyphicon glyphicon-user'></span>{$val}";
                                      })
                              ->setSortable(true)
                              ->addFilter(
                                      (new FilterConfig)
                                      ->setOperator(FilterConfig::OPERATOR_LIKE)
                              ),
                              (new FieldConfig)
                              ->setName('type')
                              ->setLabel('Chat Type')
                              ->setSortable(true)
                              ->addFilter(
                                      (new SelectFilterConfig)
                                      ->setName('c.type')
                                      ->setOptions(['group' => 'Group', 'private' => 'Private', 'public' => 'Public'])
                              ),
                              (new FieldConfig)
                              ->setName('text')
                              ->setLabel('Message')
                              ->setSortable(true)
                              ->addFilter(
                                      (new FilterConfig)
                                      ->setOperator(FilterConfig::OPERATOR_LIKE)
                              ),
                              (new FieldConfig)
                              ->setName('createdAt')
                              ->setLabel('Chat Date')
                              ->setSortable(true)
                              ->setCallback(function($val) {
                                  $d = new \DateTime($val);
                                  return $d->format('M d, Y');
                              })
                              ,
                              (new FieldConfig)
                              ->setName('id')
                              ->setLabel('Actions')
                              ->setCallback(function ($val) {
                                  return "<a href='" . URL('admin/manager/message/delete/' . $val) . "' onclick=\"return confirm('Are you sure you want to delete this message?')\"><span class='fa fa-ban'></span></a>";
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
                                      (new RecordsPerPage)
                                      ->setVariants([
                                          10,
                                          20,
                                          30,
                                          40,
                                          50,
                                          100,
                                          200,
                                          300,
                                          400,
                                          500
                                      ]),
                                      new ColumnsHider,
                                      
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
          return view('Admin::model-chat-message', compact('grid'));
      }

      /**
       * Show the form for creating a new resource.
       *
       * @return Response
       */
      public function create() {
          //
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
          $chat = ChatMessageModel::find($id);
          if (!$chat) {
              return Back()->with('msgError', 'Chat message does not found.');
          }
          if ($chat->delete()) {
              return back()->with('msgInfo', 'Chat message was successfully deleted.');
          }
          return back()->with('msgError', 'Delete chat message error.');
      }

  }
  