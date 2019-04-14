<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\EarningSettingModel;
use App\Helpers\Session as AppSession;
use DB;
use Redirect;
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

class CommissionController extends Controller {

  /**
   * @author Phong Le <pt.hongphong@gmail.com>

   * @return Response
   */
  public function index() {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return redirect::to('admin/login')->with('msgError', 'Please login with admin role');
    }
    $query =  UserModel::select('e.*', 'users.username', 'users.role', 'e.id as check', 'e.id as action')
      ->join('earningsettings as e', 'users.id', '=', 'e.userId');
    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('Users')
        ->setPageSize(10)
        ->setColumns([
          (new FieldConfig)
          ->setName('check')
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
          ->setName('role')
          ->setLabel('Role')
          ->setCallback(function ($val) {
              return ucfirst($val);
            })
          ->setSortable(true)
          ->addFilter(
            (new SelectFilterConfig)
            ->setName('role')
            ->setOptions(['admin'=>'Admin','studio'=>'Studio','model'=>'Model','member'=>'Member'])
          ),
          (new FieldConfig)
          ->setName('referredMember')
          ->setLabel('Commission %')
          ->setCallback(function ($val) {
              return $val;
            })
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          )
          ,
          (new FieldConfig)
          ->setName('action')
          ->setLabel('Actions')
          ->setCallback(function ($val) {
            return '<a class="btn btn-warning btn-sm" href="'.URL('admin/manager/commission/edit/'.$val).'">Edit</a>';
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
               # Control to show/hide rows in table
              (new ColumnsHider)
                  ->setHiddenByDefault([
                      'email',
                      'name',
                      'mobilePhone',
                  ])
              ,
              (new CsvExport)
              ->setFileName('my_report' . date('Y-m-d'))
              ,
              (new ExcelExport())
              ->setFileName('Commission-'.  date('Y-m-d'))->setSheetName('Excel sheet'),
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

    return view('Admin::admin_commission')->with('title', 'List Members')->with('grid', $grid->render());
    
  }

  public function getModels(){
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return redirect::to('admin/login')->with('msgError', 'Please login with admin role');
    }
    $query =  UserModel::select('e.*', 'users.username', 'users.role', 'e.id as check', 'e.id as action')
      ->join('earningsettings as e', 'users.id', '=', 'e.userId')
      ->where('users.role', UserModel::ROLE_MODEL);

    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('Users')
        ->setPageSize(10)
        ->setColumns([
          (new FieldConfig)
          ->setName('check')
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
          ->setName('referredMember')
          ->setLabel('Commission %')
          ->setCallback(function ($val) {
              return $val;
            })
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          )
          ,
          (new FieldConfig)
          ->setName('action')
          ->setLabel('Actions')
          ->setCallback(function ($val) {
            return '<a class="btn btn-warning btn-sm" href="'.URL('admin/manager/commission/edit/'.$val).'">Edit</a>';
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
               # Control to show/hide rows in table
              (new ColumnsHider)
                  ->setHiddenByDefault([
                      'email',
                      'name',
                      'mobilePhone',
                  ])
              ,
              (new CsvExport)
              ->setFileName('my_report' . date('Y-m-d'))
              ,
              (new ExcelExport())
              ->setFileName('Commission-'.  date('Y-m-d'))->setSheetName('Excel sheet'),
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

    return view('Admin::admin_commission_model')->with('title', 'List Members')->with('grid', $grid->render());
    
  }

  public function getStudios(){
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return redirect::to('admin/login')->with('msgError', 'Please login with admin role');
    }
    $studioOptions = [];
    $studios = UserModel::where('role', UserModel::ROLE_STUDIO)->get();
    foreach($studios as $item) {
      $studioOptions[$item->id] = $item->username;
    }
    $filterParams = Input::get('Users');
    $where = 'users.role="'.UserModel::ROLE_STUDIO.'"';
    if($filterParams && $filterParams['filters']['users.parentId-eq']){
      $studioId = $filterParams['filters']['users.parentId-eq'];
      $where .= ' AND users.id='.$studioId.' OR ( users.role="'.UserModel::ROLE_MODEL.'" AND users.parentId='.$studioId.')';
    }
    $query =  UserModel::select('e.*', 'users.username', 'users.role', 'e.id as check', 'e.id as action')
      ->join('earningsettings as e', 'users.id', '=', 'e.userId')
      ->whereRaw($where);

    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('Users')
        ->setPageSize(10)
        ->setColumns([
          (new FieldConfig)
          ->setName('check')
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
          ->setName('referredMember')
          ->setLabel('Commission %')
          ->setCallback(function ($val) {
              return $val;
            })
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          )
          ,
          (new FieldConfig)
          ->setName('role')
          ->setLabel('Role')
          ->setCallback(function ($val) {
              return ucfirst($val);
            })
          ->setSortable(true)
          ,
          (new FieldConfig)
          ->setName('action')
          ->setLabel('Filter Studio\'s Models')
          ->setCallback(function ($val) {
            return '<a class="btn btn-warning btn-sm" href="'.URL('admin/manager/commission/edit/'.$val).'">Edit</a>';
            })
          ->setSortable(false)
          ->addFilter(
            (new SelectFilterConfig)
                ->setName('users.parentId')
                ->setOptions($studioOptions)
          )
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
               # Control to show/hide rows in table
              (new ColumnsHider)
                  ->setHiddenByDefault([
                      'email',
                      'name',
                      'mobilePhone',
                  ])
              ,
              (new CsvExport)
              ->setFileName('my_report' . date('Y-m-d'))
              ,
              (new ExcelExport())
              ->setFileName('Commission-'.  date('Y-m-d'))->setSheetName('Excel sheet'),
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

    return view('Admin::admin_commission_studio')->with('title', 'List Members')->with('grid', $grid->render());
    
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>

   * @return Response
   */
  public function getDetail($id) {
    $userData = AppSession::getLoginData();
    if (!$userData) {
      return redirect::to('admin/login')->with('msgError', 'Please login with admin role');
    }

    $commission = UserModel::select('e.*', 'users.username', 'users.parentId', 'u1.username as studioName', DB::raw('(SELECT e1.referredMember FROM earningsettings e1 where e1.userId=u1.id) AS studioReferredMember'), DB::raw('(SELECT e2.performerSiteMember FROM earningsettings e2 where e2.userId=u1.id) AS studioPerformerSiteMember'), DB::raw('(SELECT e3.otherMember FROM earningsettings e3 where e3.userId=u1.id) AS studioOtherMember'), 'u2.username as modelName', DB::raw('(SELECT e4.referredMember FROM earningsettings e4 where e4.userId=u2.id) AS modelReferredMember'), DB::raw('(SELECT e5.performerSiteMember FROM earningsettings e5 where e5.userId=u2.id) AS modelPerformerSiteMember'), DB::raw('(SELECT e6.otherMember FROM earningsettings e6 where e6.userId=u2.id) AS modelOtherMember'))
        ->join('earningsettings as e', 'users.id', '=', 'e.userId')
        ->leftJoin('users as u1', 'u1.parentId', '=', 'users.id')
        ->leftJoin('users as u2', 'u2.parentId', '=', 'u1.id')
        ->where('e.id', $id)
        ->where('users.role', '=', 'admin')->first();



    return view('Admin::admin_view_commission_detail')->with('commission', $commission);
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @param int $id earningsetting id
   */
  public function getEdit($id) {
   
    $commission = EarningSettingModel::earningDetail($id);
 
    return view('Admin::admin_edit_commission')->with('commission', $commission);
  }

  /**
   * @author Phong Le <pt.hongphong@gmail.com>
   * @param int $id earningsetting id
   */
  public function updateCommission($id) {

    $commission = EarningSettingModel::earningDetail($id);
    if (!$commission) {
      return Redirect::to('admin/manager/commission')->with('msgError', 'Commission does not exist.');
    }
      //TODO check other commission
    $maxReferred = ($commission->referred1 + $commission->referred2 > 0) ? (100 - ($commission->referred1 + $commission->referred2)) : 100;
    $maxPerformer = ($commission->performer1 + $commission->performer2 > 0) ? (100 - ($commission->performer1 + $commission->performer2)) : 100;
    $maxOther = ($commission->other1 + $commission->other2 > 0) ? (100 - ($commission->other1 + $commission->other2)) : 100;
    $validator = Validator::make(Input::all(), [
        'referredMember' => 'Numeric|Max:' . $maxReferred . '|Min:0',
        'performerSiteMember' => 'Numeric|Max:' . $maxPerformer . '|Min:0',
        'otherMember' => 'Numeric|Max:' . $maxOther . '|Min:0'
    ]);
    if ($validator->fails()) {
      return back()
          ->withErrors($validator)
          ->withInput();
    }
    $earning = EarningSettingModel::find($id);
    if (!$earning) {
      return Redirect::to('admin/manager/commission')->with('msgError', 'Commission does not exist.');
    }
    $earning->referredMember = Input::get('referredMember');
    $earning->performerSiteMember = Input::get('performerSiteMember');
    $earning->otherMember = Input::get('otherMember');
    if ($earning->save()) {
      return Back()->with('msgInfo', 'Commission was successfully updated.');
    }
    return Back()->withInput()->with('msgError', 'System update error.');
  }

}
