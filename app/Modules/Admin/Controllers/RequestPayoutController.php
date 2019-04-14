<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Model\Models\PerformerPayoutRequest;
use App\Modules\Studio\Models\StudioPayoutRequest;
use App\Modules\Api\Models\UserModel;
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
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use Nayjest\Grids\SelectFilterConfig;
use Redirect;
use \App\Modules\Api\Models\PerformerModel;
class RequestPayoutController extends Controller {

  public function listing(Request $req) {
    $type = $req->get('type');
    $query = PerformerPayoutRequest::join('performer as p', 'p.id', '=', 'performer_payout_requests.performerId')
    ->join('users as u', 'p.user_id', '=', 'u.id')
    ->select('performer_payout_requests.*', 'u.email as email', 'u.username as username', 'performer_payout_requests.id as action', 'performer_payout_requests.status as status')
    ->where('studioRequestId', 0);
    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('PayoutRequest')
        ->setPageSize(20)
        ->setColumns([
          (new FieldConfig)
          ->setName('id')
          ->setLabel('ID')
          ->setSortable(true)
          ->setSorting(Grid::SORT_ASC)
          ,
          (new FieldConfig)
          ->setName('username')
          ->setLabel('Model')
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setFilteringFunc(function($val, EloquentDataProvider $dp) {
              /** @var Illuminate\Database\Eloquent\Builder $builder */
              $builder = $dp->getBuilder();
              $builder->where('u.username', 'like', "%$val%");
            })
          ),
          (new FieldConfig)
          ->setName('email')
          ->setLabel('Email')
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setFilteringFunc(function($val, EloquentDataProvider $dp) {
              /** @var Illuminate\Database\Eloquent\Builder $builder */
              $builder = $dp->getBuilder();
              $builder->where('u.email', 'like', "%$val%");
            })
          ),
          (new FieldConfig)
          ->setName('dateFrom')
          ->setLabel('Date from')
          ->setSortable(true)
          ->setCallback(function($val){
            $d = new \DateTime($val);
            return $d->format('M d, Y');
          }),
          (new FieldConfig)
          ->setName('dateTo')
          ->setLabel('Date to')
          ->setSortable(true)
          ->setCallback(function($val){
            $d = new \DateTime($val);
            return $d->format('M d, Y');
          }),
          (new FieldConfig)
          ->setName('status')
          ->setLabel('Status')
          ->setSortable(true)
          ->addFilter(
            (new SelectFilterConfig)
            ->setName('status')
            ->setOptions([
              'pending' => 'Pending',
              'approved' => 'Approved',
              'canecelled' => 'Cancelled',
              'done' => 'Done'
            ])
            ->setFilteringFunc(function($val, EloquentDataProvider $dp) {
              /** @var Illuminate\Database\Eloquent\Builder $builder */
              $builder = $dp->getBuilder();
              $builder->where('performer_payout_requests.status', $val);
            })
          ),
          (new FieldConfig)
          ->setName('createdAt')
          ->setLabel('Request date')
          ->setSortable(true)
          ->setCallback(function($val){
            $d = new \DateTime($val);
            return $d->format('M d, Y');
          }),

          (new FieldConfig)
          ->setName('action')
          ->setLabel('Actions')
          ->setCallback(function ($val, $row) {
              //$item = $row->getSrc();
              return "<a title='View' href='" . URL('admin/requestpayout/' . $val) . "'><span class='fa fa-eye'></span></a>"
                      . "<a title='View' href='" . URL('admin/requestpayout/' . $val . '/delete') . "' onclick=\"return window.confirm('Are you sure?')\">"
                      . "<span class='fa fa-trash'></span>"
                      . "</a>";
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
                100
              ]),
              new ColumnsHider,
              (new CsvExport)
              ->setFileName('my_report' . date('Y-m-d'))
              ,
              (new ExcelExport())
              ->setFileName('Request-'.  date('Y-m-d'))->setSheetName('Excel sheet'),
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

    $view = 'Admin::payout.listing';

    if (isset($_GET['PayoutRequest']) && (isset($_GET['PayoutRequest']['csv']) || isset($_GET['PayoutRequest']['xls']))) {
      return $grid;
    }

    return view($view)->with('grid', $grid)->with('notUseAngular', true);
  }

  public function listingStudio(Request $req) {
    $query = StudioPayoutRequest
    ::join('users as u', 'studio_payout_requests.studioId', '=', 'u.id')
    ->select('studio_payout_requests.*', 'u.email as email', 'u.username as username', 'studio_payout_requests.id as action', 'studio_payout_requests.status as status');
    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('PayoutRequest')
        ->setPageSize(20)
        ->setColumns([
          (new FieldConfig)
          ->setName('id')
          ->setLabel('ID')
          ->setSortable(true)
          ->setSorting(Grid::SORT_ASC)
          ,
          (new FieldConfig)
          ->setName('username')
          ->setLabel('Studio')
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setFilteringFunc(function($val, EloquentDataProvider $dp) {
              /** @var Illuminate\Database\Eloquent\Builder $builder */
              $builder = $dp->getBuilder();
              $builder->where('u.username', 'like', "%$val%");
            })
          ),
          (new FieldConfig)
          ->setName('email')
          ->setLabel('Email')
          ->setSortable(true)
          ->addFilter(
            (new FilterConfig)
            ->setFilteringFunc(function($val, EloquentDataProvider $dp) {
              /** @var Illuminate\Database\Eloquent\Builder $builder */
              $builder = $dp->getBuilder();
              $builder->where('u.email', 'like', "%$val%");
            })
          ),
          (new FieldConfig)
          ->setName('dateFrom')
          ->setLabel('Date from')
          ->setSortable(true)
          ->setCallback(function($val){
            $d = new \DateTime($val);
            return $d->format('M d, Y');
          }),
          (new FieldConfig)
          ->setName('dateTo')
          ->setLabel('Date to')
          ->setSortable(true)
          ->setCallback(function($val){
            $d = new \DateTime($val);
            return $d->format('M d, Y');
          }),
          (new FieldConfig)
          ->setName('status')
          ->setLabel('Status')
          ->setSortable(true)
          ->addFilter(
            (new SelectFilterConfig)
            ->setName('status')
            ->setOptions([
              'pending' => 'Pending',
              'approved' => 'Approved',
              'canecelled' => 'Cancelled',
              'done' => 'Done'
            ])
            ->setFilteringFunc(function($val, EloquentDataProvider $dp) {
              /** @var Illuminate\Database\Eloquent\Builder $builder */
              $builder = $dp->getBuilder();
              $builder->where('studio_payout_requests.status', $val);
            })
          ),
          (new FieldConfig)
          ->setName('createdAt')
          ->setLabel('Request date')
          ->setSortable(true)
          ->setCallback(function($val){
            $d = new \DateTime($val);
            return $d->format('M d, Y');
          }),

          (new FieldConfig)
          ->setName('action')
          ->setLabel('Actions')
          ->setCallback(function ($val, $row) {
              //$item = $row->getSrc();
              return "<a title='View' href='" . URL('admin/requestpayout/' . $val . '?type=studio') . "'><span class='fa fa-eye'></span></a>"
                      . "<a title='View' href='" . URL('admin/requestpayout/' . $val . '/delete') . "' onclick=\"return window.confirm('Are you sure?')\">"
                      . "<span class='fa fa-trash'></span>"
                      . "</a>";
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
                100
              ]),
              new ColumnsHider,
              (new CsvExport)
              ->setFileName('my_report' . date('Y-m-d'))
              ,
              (new ExcelExport())
              ->setFileName('Request-'.  date('Y-m-d'))->setSheetName('Excel sheet'),
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
    $view = 'Admin::payout.listing_studio';

    if (isset($_GET['PayoutRequest']) && (isset($_GET['PayoutRequest']['csv']) || isset($_GET['PayoutRequest']['xls']))) {
      return $grid;
    }

    return view($view)->with('grid', $grid)->with('notUseAngular', true);
  }


  public function view(Request $req, $id) {
    $type = $req->get('type');
    $performers = [];
    if ($type == 'studio') {
      $item = StudioPayoutRequest::where([
        'id' => $id
      ])
      ->first();
      if (!$item) {
        throw new Exception('Request not found!', 404);
      }

      $userModel = UserModel::find($item->studioId);
      $performers = UserModel::where('parentId', $item->studioId)->get();
    } else {
      $item = PerformerPayoutRequest::where([
        'id' => $id
      ])
      ->first();

      if (!$item) {
        throw new Exception('Request not found!', 404);
      }
      $permomerModel = PerformerModel::find($item->performerId);
      $userModel = UserModel::find($permomerModel->user_id);
    }
    

    return view('Admin::payout.view')->with('item', $item)->with('performers', $performers)->with('userModel', $userModel);
  }

  public function delete(Request $req, $id) {
    $type = $req->get('type');
    $performers = [];
    if ($type == 'studio') {
      $item = StudioPayoutRequest::where([
        'id' => $id
      ])
      ->first();
      if (!$item) {
        throw new Exception('Request not found!', 404);
      }

      $performers = $performers = $item->getPerformers();
    } else {
      $item = PerformerPayoutRequest::where([
        'id' => $id
      ])
      ->first();

      if (!$item) {
        throw new Exception('Request not found!', 404);
      }
    }

    $item->delete();
    return Redirect::back()->withErrors(['msgInfo', 'Deleted successfully']);
  }
}
