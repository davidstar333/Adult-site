<?php

namespace App\Modules\Studio\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Api\Models\EarningModel;
use App\Modules\Api\Models\EarningSettingModel;
use App\Modules\Api\Models\UserModel;
use Validator;
use Illuminate\Support\Facades\Input;
use Redirect;
use App\Helpers\Session as AppSession;
use Illuminate\Http\Request;
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
use App\Modules\Api\Models\PaymentTokensModel;

class StatsController extends Controller {

  /**
   * Display a Studio stats resource.
   * @author LongPham <long.it.stu@gmail.com>
   * @return Response
   */
  public function studioStats() {
    $userLogin = AppSession::getLoginData();
    $loadStats = EarningModel::select('earnings.*', 'u.username as performer', 'u1.username as customer', 'p.tokens as earned')
      ->join('users as u', 'u.id', '=', 'earnings.payTo')
      ->join('users as u1', 'u1.id', '=', 'earnings.payFrom')
      ->join('paymenttokens as p', 'p.id', '=', 'earnings.itemId')
      ->where('u.parentId', '=', $userLogin->id)
      ->get();
    return view("Studio::studioStats", compact('loadStats'));
  }

  /**
   * Action get commisstion report
   * @return response
   * @author LongPham <long.it.stu@gmail.com>
   *
   */
  public function studioCommissionReport() {
    $userLogin = AppSession::getLoginData();
    $commission = UserModel::select('e.*', 'users.username', 'users.role')
      ->where('users.parentId', '=', $userLogin->id)
      ->join('earningsettings as e', 'users.id', '=', 'e.userId')
      ->paginate(10);
    return view('Studio::studioCommissionReport', compact('commission'));
  }

  /**
   * @param int $id earningsettings id
   * @return Response 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function editModelCommission($id) {
    $commission = EarningSettingModel::earningDetail($id);
    return view('Studio::studio_edit_commission')->with('commission', $commission);
  }

  /**
   * @param int $id earningsettings id
   * @return Response 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function updateModelCommission($id) {
    $commission = EarningSettingModel::earningDetail($id);

    //TODO check other commission
    $maxReferred = ($commission && $commission->referred1 + $commission->referred2 > 0) ? (100 - ($commission->referred1 + $commission->referred2)) : 100;
    $maxPerformer = ($commission && $commission->performer1 + $commission->performer2 > 0) ? (100 - ($commission->performer1 + $commission->performer2)) : 100;
    $maxOther = ($commission && $commission->other1 + $commission->other2 > 0) ? (100 - ($commission->other1 + $commission->other2)) : 100;
    $validator = Validator::make(Input::all(), [
        'referredMember' => 'Numeric|Max:' . $commission->referred1 . '|Min:0',
        'performerSiteMember' => 'Numeric|Max:' . $maxPerformer . '|Min:0',
        'otherMember' => 'Numeric|Max:' . $maxOther . '|Min:0'
    ]);
    if ($validator->fails()) {
      return back()
          ->withErrors($validator)
          ->withInput();
    }
    $earning = ($commission) ? EarningSettingModel::find($id) : new EarningSettingModel;

    $earning->referredMember = Input::get('referredMember');
    // $earning->performerSiteMember = Input::get('performerSiteMember');
    // $earning->otherMember = Input::get('otherMember');
    if ($earning->save()) {
      return Redirect::to('studio/commission-report')->with('msgInfo', 'Commission was successfully updated.');
    }
    return Back()->withInput()->with('msgError', 'System update error.');
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
  }
  
  
  public function performerStats(Request $req){
    $studio = $req->get('studio');
    $query = UserModel::select('users.*', 'users.id as check', 'users.id as action', 'e.referredMember')
        ->join('earningsettings as e', 'users.id', '=', 'e.userId')
        ->where('users.role', UserModel::ROLE_MODEL)
        ->where('users.parentId', $studio->id);
    
    $GLOBALS['studioCommissionForGrid'] = EarningSettingModel::getCommission($studio->id);
    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('Models')
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
          ->setName('username')
          ->setLabel('Performer')
          ->setCallback(function ($val) {
              return "<span class='glyphicon glyphicon-user'></span>{$val}";
            })
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          ),
          (new FieldConfig)
          ->setName('totalEarn')
          ->setLabel('Total Earned')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = PaymentTokensModel::getMyEarned($item, 'all');
            return ($earning->totalTokens)?$earning->totalTokens:'';
          })
          ,
          (new FieldConfig)
          ->setName('tip')
          ->setLabel('Tip')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = PaymentTokensModel::getMyEarned($item, 'all', PaymentTokensModel::ITEM_TIP);
            return ($earning->totalTokens)?$earning->totalTokens:'';
          }),  
          (new FieldConfig)
          ->setName('privateChat')
          ->setLabel('Private Chat')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = PaymentTokensModel::getMyEarned($item, 'all', PaymentTokensModel::ITEM_PRIVATE);
            return ($earning->totalTokens)?$earning->totalTokens:'';
          }),
          (new FieldConfig)
          ->setName('groupChat')
          ->setLabel('Group Chat')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = PaymentTokensModel::getMyEarned($item, 'all', PaymentTokensModel::ITEM_GROUP);
            return ($earning->totalTokens)?$earning->totalTokens:'';
          }),
          (new FieldConfig)
          ->setName('video')
          ->setLabel('Videos')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = PaymentTokensModel::getMyEarned($item, 'all', PaymentTokensModel::ITEM_VIDEO);
            return ($earning->totalTokens)?$earning->totalTokens:'';
          }),
          (new FieldConfig)
          ->setName('image')
          ->setLabel('Photo albums')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = PaymentTokensModel::getMyEarned($item, 'all', PaymentTokensModel::ITEM_IMAGE);
            return ($earning->totalTokens)?$earning->totalTokens:'';
          }),
          (new FieldConfig)
          ->setName('product')
          ->setLabel('Physical products')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = PaymentTokensModel::getMyEarned($item, 'all', PaymentTokensModel::ITEM_PERFORMER_PRODUCT);
            return ($earning->totalTokens)?$earning->totalTokens:'';
          }),
          (new FieldConfig)
          ->setName('referredMember')
          ->setLabel('Commission %')
          ->setCallback(function ($val) {
            return $val;
          }),
          (new FieldConfig)
          ->setName('earned')
          ->setLabel('Model Earned')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = EarningModel::getMyEarned($item, 'all');
            return ($earning->totalTokens)?$earning->totalTokens:'';
          }),
          (new FieldConfig)
          ->setName('studioCommission')
          ->setLabel('Studio Commission %')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            return EarningSettingModel::getCommission($item->parentId);
          }),        
          (new FieldConfig)
          ->setName('studioEarned')
          ->setLabel('Studio Earned')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            return EarningModel::getStudioEarned($item, $GLOBALS['studioCommissionForGrid']);
          })
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
              (new CsvExport)
              ->setFileName('my_report' . date('Y-m-d'))
              ,
              (new ExcelExport())
              ->setFileName('Models-'.  date('Y-m-d'))->setSheetName('Excel sheet'),
              (new HtmlTag)
              ->setContent('<span class="glyphicon glyphicon-refresh"></span> Filter')
              ->setTagName('button')
              ->setRenderSection(RenderableRegistry::SECTION_END)
              ->setAttributes([
                'class' => 'btn btn-success btn-sm',
                'id' => 'formFilter',
                'onclick' => 'filterGridForm()'
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

    if (isset($_GET['Models']) && (isset($_GET['Models']['csv']) || isset($_GET['Models']['xls']))) {
      return $grid;
    }
    return view('Studio::stats.performer', compact('grid'));
  }
}
