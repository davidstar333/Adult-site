<?php
namespace App\Modules\Studio\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Modules\Studio\Models\StudioPayoutAccount;
use App\Modules\Studio\Models\StudioPayoutRequest;
use App\Modules\Api\Models\UserModel;
use App\Modules\Model\Models\PerformerPayoutRequest;
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
use App\Modules\Api\Models\PaymentTokensModel;
use App\Helpers\Session as AppSession;
use \App\Modules\Api\Models\PerformerModel;

/**
 *
 *
 * @author tuongtran
 */
class RequestPayoutController extends Controller {
  public function createAccount(Request $req) {
    if (!$req->isMethod('post')) {
      return view('Studio::request_payout.create_account')->with('account', new StudioPayoutAccount());
    }

    //TODO - validate
    $studio = $req->get('studio');
    $model = new StudioPayoutAccount([
      'studioId' => $studio->id,
      'name' => Input::get('name'),
      'info' => Input::get('info')
    ]);
    $model->save();
    //redirect to product list page
    return redirect('studio/payouts/accounts');
  }

  public function listingAccounts(Request $req) {
    $studio = $req->get('studio');

    $items = StudioPayoutAccount::where(['studioId' => $studio->id])
            ->orderBy('id', 'desc')
            ->paginate(10);
    return view('Studio::request_payout.list_accounts')->with('items', $items);
  }

  public function updateAccount(Request $req, $id) {
    $studio = $req->get('studio');
    $account = StudioPayoutAccount::where([
      'id' => $id,
      'studioId' => $studio->id
    ])->first();
    if (!$account) {
      throw new Exception('No account available!');
    }

    if (!$req->isMethod('post')) {
      return view('Studio::request_payout.create_account')->with('account', $account);
    }

    //TODO - validate

    $account->name = Input::get('name');
    $account->info = Input::get('info');

    $account->save();
    //redirect to product list page
    return redirect('studio/payouts/accounts')->with('msgInfo', 'Account updated successfully!');
  }

  public function createRequest(Request $req) {

    $studio = $req->get('studio');
    if (!$req->isMethod('post')) {
      return view('Studio::request_payout.create_request')
            ->with('request', new StudioPayoutRequest());
    }
    
    if (!empty(Input::get('dateFrom')) && !empty(Input::get('dateTo')) && strtotime(Input::get('dateFrom')) >= strtotime(Input::get('dateTo'))) {
      return redirect('studio/payouts/requests/create')
              ->with('msgWarning', 'From Date must be smaller than To Date!');
    }

    $model = new StudioPayoutRequest([
      'studioId' => $studio->id,
      'comment' => Input::get('comment'),
      'dateFrom' => Input::get('dateFrom'),
      'dateTo' => Input::get('dateTo'),
      'status' => 'pending',
      'payout' => Input::get('payout'),
      'previousPayout' => Input::get('previousPayout'),
      'pendingBalance' => Input::get('pendingBalance'),
      'paymentAccount' => Input::get('paymentAccount')
    ]);
    $model->save();

    //redirect to product list page
    return redirect('studio/payouts/requests')->with('msgInfo', 'Create request successfully!');
  }
  public function editRequest($id, Request $req) {
    $studioPayoutRequest = StudioPayoutRequest::find($id);
    if (!$studioPayoutRequest) {
      throw new Exception('Request not found!', 404);
    }
    if (!$req->isMethod('post')) {
      return view('Studio::request_payout.edit_request')
            ->with('request', $studioPayoutRequest);
    }

    $payoutRequestParams = [
      'comment' => Input::get('comment'),
      'dateFrom' => Input::get('dateFrom'),
      'dateTo' => Input::get('dateTo'),
      'payout' => Input::get('payout'),
      'previousPayout' => Input::get('previousPayout'),
      'pendingBalance' => Input::get('pendingBalance'),
      'paymentAccount' => Input::get('paymentAccount')
    ];
    
    $studioPayoutRequest->update($payoutRequestParams);

    return redirect('studio/payouts/requests')->with('msgInfo', 'update request successfully!');
  }

  public function listingRequests(Request $req) {
    $studio = $req->get('studio');
    $request = StudioPayoutRequest::where(['studioId' => $studio->id]);
    $status = $req->get('status');
    if ($status) {
      $request->where(['status' => $status]);
    }
    $startDate = $req->get('startDate');
    $endDate = $req->get('endDate');
    if ($startDate && $endDate) {
      $start = strtotime('midnight', strtotime($startDate));
      $end = strtotime('tomorrow', $start) - 1;
      $request->where('createdAt', '>=', date('Y-m-d', $start))
              ->where('createdAt', '<=', date('Y-m-d', $end));
    }

    $items = $request
            ->orderBy('id', 'desc')
            ->paginate(10);
    return view('Studio::request_payout.list_requests')
          ->with('items', $items)
          ->with('status', $status)
          ->with('startDate', $startDate)
          ->with('endDate', $endDate);
  }

  public function viewRequest(Request $req, $id) {
    $studio = $req->get('studio');
    $item = StudioPayoutRequest::where([
      'studioId' => $studio->id,
      'id' => $id
    ])
    ->first();

    if (!$item) {
      throw new Exception('Request not found!', 404);
    }

    //get model info and show here
    $performers = $item->getPerformers();

    return view('Studio::request_payout.detail_request')->with('item', $item)
            ->with('performers', $performers);
  }

  public function performerRequests(Request $req) {
    $studio = $req->get('studio');
    $query = PerformerPayoutRequest::join('performer as p', 'p.id', '=', 'performer_payout_requests.performerId')
    ->join('users as u', 'p.user_id', '=', 'u.id')
    ->select('performer_payout_requests.*', 'u.email as email', 'u.username as username', 'performer_payout_requests.id as action', 'performer_payout_requests.status as status')
    ->where('studioRequestId', $studio->id);
    $grid = new Grid(
      (new GridConfig)
        ->setDataProvider(
          new EloquentDataProvider($query)
        )
        ->setName('PayoutRequest')
        ->setPageSize(10)
        ->setColumns([
          (new FieldConfig)
          ->setName('id')
          ->setLabel('ID')
          ->setSortable(true)
          ->setSorting(Grid::SORT_ASC)
          ,
          (new FieldConfig)
          ->setName('username')
          ->setLabel('Performer')
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
              return "<a title='View' href='" . URL('studio/payouts/performer-requests/' . $val) . "'><span class='fa fa-eye'></span></a>&nbsp;&nbsp;"
                      . "<a title='View' href='" . URL('studio/payouts/performer-requests/' . $val . '/delete') . "' onclick=\"return window.confirm('Are you sure?')\">"
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

    if (isset($_GET['PayoutRequest']) && (isset($_GET['PayoutRequest']['csv']) || isset($_GET['PayoutRequest']['xls']))) {
      return $grid;
    }

    return view('Studio::request_payout.performer_requests', compact('grid'));
  }
  public function performerRequestsDelete($id) {
    $item = PerformerPayoutRequest::find($id);

    if (!$item) {
      return \Redirect::back()->with('msgError', 'Payout Request Not Found');
    }
    $userLogin = AppSession::getLoginData();
    if($item->studioRequestId !== $userLogin->id){
      return \Redirect::back()->with('msgError', 'You can not delete this Payout Request');
    }
    $item->delete();
    return \Redirect::back()->with('msgInfo', 'Deleted successfully');
  }

  public function performerRequestsView($id) {
    $item = PerformerPayoutRequest::find($id);
    if (!$item) {
      return \Redirect::back()->with('msgError', 'Payout Request Not Found');
    }
    $userLogin = AppSession::getLoginData();
    if($item->studioRequestId !== $userLogin->id){
      return \Redirect::back()->with('msgError', 'You can not delete this Payout Request');
    }
    $permomerModel = PerformerModel::find($item->performerId);
    $userModel = UserModel::find($permomerModel->user_id);
    return view('Studio::request_payout.performer_requests_view')->with('item', $item)->with('userModel', $userModel);
  }
}
