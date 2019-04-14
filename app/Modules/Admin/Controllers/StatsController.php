<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\Session as AppSession;
use App\Helpers\Helper as AppHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\PerformerModel;
use App\Modules\Api\Models\CategoryModel;
use App\Events\AddModelPerformerChatEvent;
use App\Events\AddModelScheduleEvent;
use App\Events\AddEarningSettingEvent;
use App\Events\AddModelPerformerEvent;
use App\Modules\Api\Models\CountryModel;
use App\Events\MakeChatRoomEvent;
use App\Modules\Api\Models\PerformerChatModel;
use App\Modules\Api\Models\AttachmentModel;
use App\Modules\Api\Models\EarningModel;
use App\Modules\Api\Models\PaymentTokensModel;
use App\Modules\Api\Models\FavoriteModel;
use App\Modules\Api\Models\MessageReplyModel;
use App\Modules\Api\Models\MessageConversationModel;
use App\Modules\Api\Models\GalleryModel;
use App\Modules\Api\Models\ScheduleModel;
use App\Modules\Api\Models\EarningSettingModel;
use App\Jobs\DeleteGalleryByOwner;
use App\Jobs\deleteAttachmentByOwner;
use DB;
use HTML;
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
use App\Modules\Model\Models\PerformerTag;
use App\Modules\Api\Models\ChatThreadModel;
use App\Helpers\Helper;
use App\Modules\Api\Models\SettingModel;

class StatsController  extends Controller{
   public function getModelStats() {
    $admin = UserModel::where('role', UserModel::ROLE_ADMIN)->first();
    $query = UserModel::select('users.*', 'users.id as check', 'users.id as action', 'e.referredMember')
        ->join('earningsettings as e', 'users.id', '=', 'e.userId')
        ->where('users.role', UserModel::ROLE_MODEL)
        ->whereIn('users.parentId', [0, $admin->id]);
    $setting = SettingModel::first();
    $GLOBALS['conversionRateForGrid'] = $setting->conversionRate;
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
          ->setLabel('Model')
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
          ->setLabel('Total Earned($)')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = PaymentTokensModel::getMyEarned($item, 'all');
            return ($earning->totalTokens)?$earning->totalTokens*$GLOBALS['conversionRateForGrid']:'';
          })
          ,
          (new FieldConfig)
          ->setName('tip')
          ->setLabel('Tip($)')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = PaymentTokensModel::getMyEarned($item, 'all', PaymentTokensModel::ITEM_TIP);
            return ($earning->totalTokens)?$earning->totalTokens*$GLOBALS['conversionRateForGrid']:'';
          }),  
          (new FieldConfig)
          ->setName('privateChat')
          ->setLabel('Private Chat($)')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = PaymentTokensModel::getMyEarned($item, 'all', PaymentTokensModel::ITEM_PRIVATE);
            return ($earning->totalTokens)?$earning->totalTokens*$GLOBALS['conversionRateForGrid']:'';
          }),
          (new FieldConfig)
          ->setName('groupChat')
          ->setLabel('Group Chat($)')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = PaymentTokensModel::getMyEarned($item, 'all', PaymentTokensModel::ITEM_GROUP);
            return ($earning->totalTokens)?$earning->totalTokens*$GLOBALS['conversionRateForGrid']:'';
          }),
          (new FieldConfig)
          ->setName('video')
          ->setLabel('Videos($)')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = PaymentTokensModel::getMyEarned($item, 'all', PaymentTokensModel::ITEM_VIDEO);
            return ($earning->totalTokens)?$earning->totalTokens*$GLOBALS['conversionRateForGrid']:'';
          }),
          (new FieldConfig)
          ->setName('image')
          ->setLabel('Photo albums($)')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = PaymentTokensModel::getMyEarned($item, 'all', PaymentTokensModel::ITEM_IMAGE);
            return ($earning->totalTokens)?$earning->totalTokens*$GLOBALS['conversionRateForGrid']:'';
          }),
          (new FieldConfig)
          ->setName('product')
          ->setLabel('Physical products($)')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = PaymentTokensModel::getMyEarned($item, 'all', PaymentTokensModel::ITEM_PERFORMER_PRODUCT);
            return ($earning->totalTokens)?$earning->totalTokens*$GLOBALS['conversionRateForGrid']:'';
          }),
          (new FieldConfig)
          ->setName('referredMember')
          ->setLabel('Commission %')
          ->setCallback(function ($val) {
            return $val;
          }),
          (new FieldConfig)
          ->setName('earned')
          ->setLabel('Earned($)')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = EarningModel::getMyEarned($item, 'all');
            return ($earning->totalTokens)?$earning->totalTokens*$GLOBALS['conversionRateForGrid']:'';
          }),
          (new FieldConfig)
          ->setName('adminEarned')
          ->setLabel('Admin Earned($)')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $totalTokens = EarningModel::getAdminEarned($item, $item->referredMember, $GLOBALS['conversionRateForGrid']);
            return $totalTokens;
          }),
           (new FieldConfig)
          ->setName('action')
          ->setLabel('Actions')
          ->setCallback(function ($val, $row) {
              $item = $row->getSrc();
              $url = "<a title='Reset payment' class=\"btn btn-danger btn-sm\" onclick=\"return confirm('Are you sure you want to reset payment of this account?')\" href='" . URL('admin/stats/reset-earning/' . $val) . "'>Reset</a>";
              return $url;
            })
          ->setSortable(false)
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

    if (isset($_GET['Models']) && (isset($_GET['Models']['csv']) || isset($_GET['Models']['xls']))) {
      return $grid;
    }
    return view('Admin::stats.performer', compact('grid'))->with('title', 'List Models')->with('notUseAngular', true);
  }
  
  public function getStudioStats() {
      $query = UserModel::select('users.*', 'users.id as check', 'users.id as action')
      ->where('users.role', UserModel::ROLE_STUDIO);
    $setting = SettingModel::first();
    $GLOBALS['conversionRateForGrid'] = $setting->conversionRate;
    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('Studio')
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
          ->setLabel('Studio')
          ->setCallback(function ($val) {
              return "<span class='glyphicon glyphicon-user'></span>{$val}";
            })
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setOperator(FilterConfig::OPERATOR_LIKE)
          ),
            (new FieldConfig)
          ->setName('tokens')
          ->setLabel('Earned($)')
          ->setCallback(function ($val, $row) {                      
            return $val*$GLOBALS['conversionRateForGrid'];
          })
          ,
          
          (new FieldConfig)
          ->setName('totalModel')
          ->setLabel('Total Models')
          ->setCallback(function ($val, $row) { 
            $item = $row->getSrc();
            $totalModel = UserModel::getTotalModels($item->id); 
            return '<a href="'.URL('admin/stats/studio-model/'.$item->id).'">View '.$totalModel.' model(s)</a>';
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

    if (isset($_GET['Models']) && (isset($_GET['Models']['csv']) || isset($_GET['Models']['xls']))) {
      return $grid;
    }
    return view('Admin::stats.studio', compact('grid'))->with('title', 'List Studio')->with('notUseAngular', true);
  }
  
  
  public function getStudioModels($studioId) {
    $studio = UserModel::find($studioId);
    $query = UserModel::select('users.*', 'users.id as check', 'users.id as action', 'e.referredMember')
        ->join('earningsettings as e', 'users.id', '=', 'e.userId')
        ->where('users.role', UserModel::ROLE_MODEL)
        ->where('users.parentId', $studioId);
    $setting = SettingModel::first();
    $GLOBALS['conversionRateForGrid'] = $setting->conversionRate;
    $GLOBALS['studioCommissionForGrid'] = EarningSettingModel::getCommission($studioId);
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
          ->setLabel('Model')
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
          ->setLabel('Total Earned($)')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = PaymentTokensModel::getMyEarned($item, 'all');
            return ($earning->totalTokens)?$earning->totalTokens*$GLOBALS['conversionRateForGrid']:'';
          })
          ,
          (new FieldConfig)
          ->setName('tip')
          ->setLabel('Tip($)')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = PaymentTokensModel::getMyEarned($item, 'all', PaymentTokensModel::ITEM_TIP);
            return ($earning->totalTokens)?$earning->totalTokens*$GLOBALS['conversionRateForGrid']:'';
          }),  
          (new FieldConfig)
          ->setName('privateChat')
          ->setLabel('Private Chat($)')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = PaymentTokensModel::getMyEarned($item, 'all', PaymentTokensModel::ITEM_PRIVATE);
            return ($earning->totalTokens)?$earning->totalTokens*$GLOBALS['conversionRateForGrid']:'';
          }),
          (new FieldConfig)
          ->setName('groupChat')
          ->setLabel('Group Chat($)')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = PaymentTokensModel::getMyEarned($item, 'all', PaymentTokensModel::ITEM_GROUP);
            return ($earning->totalTokens)?$earning->totalTokens*$GLOBALS['conversionRateForGrid']:'';
          }),
          (new FieldConfig)
          ->setName('video')
          ->setLabel('Videos($)')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = PaymentTokensModel::getMyEarned($item, 'all', PaymentTokensModel::ITEM_VIDEO);
            return ($earning->totalTokens)?$earning->totalTokens*$GLOBALS['conversionRateForGrid']:'';
          }),
          (new FieldConfig)
          ->setName('image')
          ->setLabel('Photo albums($)')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = PaymentTokensModel::getMyEarned($item, 'all', PaymentTokensModel::ITEM_IMAGE);
            return ($earning->totalTokens)?$earning->totalTokens*$GLOBALS['conversionRateForGrid']:'';
          }),
          (new FieldConfig)
          ->setName('product')
          ->setLabel('Physical products($)')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = PaymentTokensModel::getMyEarned($item, 'all', PaymentTokensModel::ITEM_PERFORMER_PRODUCT);
            return ($earning->totalTokens)?$earning->totalTokens*$GLOBALS['conversionRateForGrid']:'';
          }),
          (new FieldConfig)
          ->setName('referredMember')
          ->setLabel('Commission %')
          ->setCallback(function ($val) {
            return $val;
          }),
          (new FieldConfig)
          ->setName('earned')
          ->setLabel('Model Earned($)')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $earning = EarningModel::getMyEarned($item, 'all');
            return ($earning->totalTokens)?$earning->totalTokens*$GLOBALS['conversionRateForGrid']:'';
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
          ->setLabel('Studio Earned($)')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            return EarningModel::getStudioEarned($item, $GLOBALS['studioCommissionForGrid']);
          }),        
          (new FieldConfig)
          ->setName('adminEarned')
          ->setLabel('Admin Earned($)')
          ->setCallback(function ($val, $row) {
            $item = $row->getSrc();
            $totalTokens = EarningModel::getAdminEarned($item, $GLOBALS['studioCommissionForGrid'], $GLOBALS['conversionRateForGrid']);
            return $totalTokens;
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

    if (isset($_GET['Models']) && (isset($_GET['Models']['csv']) || isset($_GET['Models']['xls']))) {
      return $grid;
    }
    return view('Admin::stats.studio-performer', compact('grid', 'studio'))->with('title', 'List Models')->with('notUseAngular', true);
  }
  public function resetEarning($userId) {
    $user  = UserModel::find($userId);
    $performer = PerformerModel::where('user_id', $userId)->first();
    if(!$user || !$performer){
      return Back()->with('msgError', 'User not found');
    }
    if($user) {
      $user->tokens = 0 ;
      $user->save();
    }
    DB::table('paymenttokens')->where('itemId', '=', $userId)->delete();
    DB::table('performer_payout_requests')->where('performerId', '=', $performer->id)->delete();
    DB::table('earnings')->where('payTo', '=', $userId)->delete();
    return Back()->with('msgInfo', 'Reset successfully!');
  }
}
