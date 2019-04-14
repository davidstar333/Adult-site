<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Api\Models\EarningModel;
use App\Modules\Model\Models\PerformerPayoutRequest;
use Illuminate\Http\Request;
use App\Helpers\Session as AppSession;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\SettingModel;
use Redirect;
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

class AdminController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index() {
    $userLogin = AppSession::getLoginData();
    if (!$userLogin) {
      return Redirect('admin/login');
    }
    return Redirect('admin/dashboard');
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
	public function dashboard() {
		$userInfo = UserModel::select(DB::raw("(SELECT COUNT(u1.id) FROM users u1 WHERE u1.role='member') AS totalMember"), DB::raw("(SELECT COUNT(u2.id) FROM users u2 WHERE u2.role = 'model') AS totalModel"), DB::raw("(SELECT COUNT(u3.id) FROM users u3 WHERE u3.role = 'studio') AS totalStudio"))->first();
		$pendingModel = $this->getModelPending();
		$pendingStudio = $this->getStudioPending();
		$highestEarnModel = $this->getModelHighestEarn();
		$payoutRequest = $this->payoutRequest();
		return view("Admin::index", array(
			'pendingModel' => $pendingModel,
			'pendingStudio' => $pendingStudio,
			'highestEarnModel' => $highestEarnModel,
			'payoutRequest' => $payoutRequest,
		))->with('userInfo', $userInfo);
	}

	public function getModelPending(){
		$query = UserModel
			::leftJoin('countries as c', 'users.countryId', '=', 'c.id')
			->select('users.*', 'users.id as check', 'users.id as action')
			->addSelect('c.name')
			->where('users.role', UserModel::ROLE_MODEL)
			->where('accountStatus', 'waiting');
		$studios = UserModel::where('role', UserModel::ROLE_STUDIO)->get();
		$dropdownStudios = [];
		foreach($studios as $studio) {
			$dropdownStudios[$studio->id] = $studio->username;
		}
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
						->setName('id')
						->setLabel('ID')
						->setSortable(true)
						->setSorting(Grid::SORT_ASC)
					,
					(new FieldConfig)
						->setName('username')
						->setLabel('Username')
						->setCallback(function ($val) {
							return "{$val}";
						})
						->setSortable(true)
						->addFilter(
							(new FilterConfig)
								->setOperator(FilterConfig::OPERATOR_LIKE)
						)
					,
					(new FieldConfig)
						->setName('parentId')
						->setLabel('Studio')
						->setCallback(function ($val) {
							if(!$val || $val === 1){
								return '';
							}
							$user = UserModel::findMe($val);
							return $user->username;
						})
						->setSortable(true)
						->addFilter(
							(new SelectFilterConfig)
								->setName('parentId')
								->setOptions($dropdownStudios)
						)
					,
					(new FieldConfig)
						->setName('email')
						->setLabel('Email')
						->setSortable(true)
						->setCallback(function ($val) {
							$icon = '<span class="glyphicon glyphicon-envelope"></span>&nbsp;';
							return
								'<small>'
								. HTML::link("mailto:$val", $val)
								. '</small>';
						})
						->addFilter(
							(new FilterConfig)
								->setOperator(FilterConfig::OPERATOR_LIKE)
						)
					,
					(new FieldConfig)
						->setName('tokens')
						->setLabel('Tokens')
						->setSortable(true)
					,

					(new FieldConfig)
						->setName('minPayment')
						->setLabel('Min Payment')
						->setSortable(true)
						->setCallback(function($val){
							return $val . '$';
						})
					,

					(new FieldConfig)
						->setName('gender')
						->setLabel('Gender')
						->setSortable(true)
						->addFilter(
							(new SelectFilterConfig)
								->setName('gender')
								->setOptions(['male'=>'Male','female'=>'Female', 'transgender' => 'Transgender'])
						)
					,
					(new FieldConfig)
						->setName('suspendReason')
						->setLabel('Suspend Reason')
					,
					(new FieldConfig)
						->setName('mobilePhone')
						->setLabel('Phone')
						->setSortable(true)
						->addFilter(
							(new FilterConfig)
								->setOperator(FilterConfig::OPERATOR_LIKE)
						)
					,
					(new FieldConfig)
						->setName('name')
						->setLabel('Country')
						->addFilter(
							(new FilterConfig)
								->setOperator(FilterConfig::OPERATOR_LIKE)
						)
						->setSortable(true)
					,
					(new FieldConfig)
						->setName('createdAt')
						->setLabel('reg. Date')
						->setSortable(true)
						->setCallback(function($val){
							$d = new \DateTime($val);
							return $d->format('M d, Y');
						})
					,
					(new FieldConfig)
						->setName('action')
						->setLabel('Actions')
						->setCallback(function ($val, $row) {
							$item = $row->getSrc();
							$url = "<a href='" . URL('admin/manager/model-profile/' . $val) . "' title='Edit account'><span class='fa fa-pencil'></span></a>&nbsp;&nbsp;<a title='Delete account' onclick=\"return confirm('Are you sure you want to delete this account?')\" href='" . URL('admin/manager/profile/delete/' . $val) . "'><span class='fa fa-trash'></span></a>";
							if($item->accountStatus != UserModel::ACCOUNT_ACTIVE){
								$url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/profile/approve/' . $val)."' title='Approve account'><i class='fa fa-check-circle-o' aria-hidden='true'></i></a>";
							}
							if($item->accountStatus != UserModel::ACCOUNT_DISABLE){
								$url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/profile/disable/' . $val) . "' title='Disable account' onclick=\"return confirm('Are you sure you want to disable this account?')\"><span class='fa fa-ban'></span></a>";
							}
							if($item->accountStatus == UserModel::ACCOUNT_ACTIVE){
								$url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/profile/suspend/' . $val)."' title='Suspend account'><i class='fa fa-exclamation-circle' aria-hidden='true'></i></a>";
							}
							$url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/image-gallery/' . $val) . "' title='Image galleries'><span class='fa fa-picture-o'></span></a>&nbsp;&nbsp;<a href='" . URL('admin/manager/video-gallery/' . $val) . "' title='Video galleries'><span class='fa fa-video-camera'></span></a>&nbsp;&nbsp;<a href='" . URL('admin/manager/profile/identification/' . $val) . "' title='Model Identification'><span class='fa fa-file-text-o'></span></a>&nbsp;&nbsp;<a href='" . URL('admin/manager/model/chat/' . $val) . "' title='Manage Chat Messages'><span class='fa fa-comments-o' aria-hidden='true'></span></a>";
							return $url;

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
		return $grid->render();
	}

	public function getModelHighestEarn(){
		$query = EarningModel::select([
			DB::raw('sum(earnings.tokens) as totalEarning'),
			'u.*',
		])->join('users as u', 'u.id', '=', 'earnings.payTo')
			->where('u.role', UserModel::ROLE_MODEL)
			->groupBy('u.id');
		$studios = UserModel::where('role', UserModel::ROLE_STUDIO)->get();
		$dropdownStudios = [];
		foreach($studios as $studio) {
			$dropdownStudios[$studio->id] = $studio->username;
		}
		$grid = new Grid(
			(new GridConfig)
				->setDataProvider(
					new EloquentDataProvider($query)
				)
				->setName('EarnModels')
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
							return "{$val}";
						})
						->setSortable(true)
						->addFilter(
							(new FilterConfig)
								->setOperator(FilterConfig::OPERATOR_LIKE)
						)
					,
					(new FieldConfig)
						->setName('parentId')
						->setLabel('Studio')
						->setCallback(function ($val) {
							if(!$val || $val === 1){
								return '';
							}
							$user = UserModel::findMe($val);
							return $user->username;
						})
						->setSortable(true)
						->addFilter(
							(new SelectFilterConfig)
								->setName('parentId')
								->setOptions($dropdownStudios)
						)
					,
					(new FieldConfig)
						->setName('email')
						->setLabel('Email')
						->setSortable(true)
						->setCallback(function ($val) {
							return
								'<small>'
								. HTML::link("mailto:$val", $val)
								. '</small>';
						})
						->addFilter(
							(new FilterConfig)
								->setOperator(FilterConfig::OPERATOR_LIKE)
						)
					,
					(new FieldConfig)
						->setName('totalEarning')
						->setLabel('Total Token')
						->setSortable(true)
					,
					(new FieldConfig)
						->setName('gender')
						->setLabel('Gender')
						->setSortable(true)
						->addFilter(
							(new SelectFilterConfig)
								->setName('gender')
								->setOptions(['male'=>'Male','female'=>'Female', 'transgender' => 'Transgender'])
						)
					,
					(new FieldConfig)
						->setName('mobilePhone')
						->setLabel('Phone')
						->setSortable(true)
						->addFilter(
							(new FilterConfig)
								->setOperator(FilterConfig::OPERATOR_LIKE)
						)
					,
					(new FieldConfig)
						->setName('createdAt')
						->setLabel('reg. Date')
						->setSortable(true)
						->setCallback(function($val){
							$d = new \DateTime($val);
							return $d->format('M d, Y');
						})
					,
					(new FieldConfig)
						->setName('action')
						->setLabel('Actions')
						->setCallback(function ($val, $row) {
							$item = $row->getSrc();
							$val = $item['id'];
							$url = "<a href='" . URL('admin/manager/model-profile/' . $val) . "' title='Edit account'><span class='fa fa-pencil'></span></a>&nbsp;&nbsp;<a title='Delete account' onclick=\"return confirm('Are you sure you want to delete this account?')\" href='" . URL('admin/manager/profile/delete/' . $val) . "'><span class='fa fa-trash'></span></a>";
							if($item->accountStatus != UserModel::ACCOUNT_ACTIVE){
								$url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/profile/approve/' . $val)."' title='Approve account'><i class='fa fa-check-circle-o' aria-hidden='true'></i></a>";
							}
							if($item->accountStatus != UserModel::ACCOUNT_DISABLE){
								$url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/profile/disable/' . $val) . "' title='Disable account' onclick=\"return confirm('Are you sure you want to disable this account?')\"><span class='fa fa-ban'></span></a>";
							}
							if($item->accountStatus == UserModel::ACCOUNT_ACTIVE){
								$url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/profile/suspend/' . $val)."' title='Suspend account'><i class='fa fa-exclamation-circle' aria-hidden='true'></i></a>";
							}
							$url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/image-gallery/' . $val) . "' title='Image galleries'><span class='fa fa-picture-o'></span></a>&nbsp;&nbsp;<a href='" . URL('admin/manager/video-gallery/' . $val) . "' title='Video galleries'><span class='fa fa-video-camera'></span></a>&nbsp;&nbsp;<a href='" . URL('admin/manager/profile/identification/' . $val) . "' title='Model Identification'><span class='fa fa-file-text-o'></span></a>&nbsp;&nbsp;<a href='" . URL('admin/manager/model/chat/' . $val) . "' title='Manage Chat Messages'><span class='fa fa-comments-o' aria-hidden='true'></span></a>";
							return $url;

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
		return $grid->render();
	}

	public function getStudioPending() {
		$query = UserModel
			::leftJoin('countries as c', 'users.countryId', '=', 'c.id')
			->select('users.*', 'users.id as check', 'users.id as action')
			->addSelect('c.name')
			->where('users.role', UserModel::ROLE_STUDIO)
			->where('accountStatus', 'waiting');

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
						->setName('id')
						->setLabel('ID')
						->setSortable(true)
						->setSorting(Grid::SORT_ASC)
					,
					(new FieldConfig)
						->setName('username')
						->setLabel('Username')
						->setCallback(function ($val) {
							return "{$val}";
						})
						->setSortable(true)
						->addFilter(
							(new FilterConfig)
								->setOperator(FilterConfig::OPERATOR_LIKE)
						)
					,
					(new FieldConfig)
						->setName('email')
						->setLabel('Email')
						->setSortable(true)
						->setCallback(function ($val) {
							$icon = '<span class="glyphicon glyphicon-envelope"></span>&nbsp;';
							return
								'<small>'
								. HTML::link("mailto:$val", $val)
								. '</small>';
						})
						->addFilter(
							(new FilterConfig)
								->setOperator(FilterConfig::OPERATOR_LIKE)
						)
					,
					(new FieldConfig)
						->setName('tokens')
						->setLabel('Tokens')
						->setSortable(true)

					,

					(new FieldConfig)
						->setName('minPayment')
						->setLabel('Min Payment')
						->setSortable(true)
						->setCallback(function($val){
							return $val . '$';
						})
					,
					(new FieldConfig)
						->setName('gender')
						->setLabel('Gender')
						->setSortable(true)
						->addFilter(
							(new SelectFilterConfig)
								->setName('gender')
								->setOptions(['male'=>'Male','female'=>'Female', 'transgender' => 'Transgender'])
						)
					,
					(new FieldConfig)
						->setName('mobilePhone')
						->setLabel('Phone')
						->setSortable(true)
						->addFilter(
							(new FilterConfig)
								->setOperator(FilterConfig::OPERATOR_LIKE)
						)
					,
					(new FieldConfig)
						->setName('name')
						->setLabel('Country')
						->addFilter(
							(new FilterConfig)
								->setOperator(FilterConfig::OPERATOR_LIKE)
						)
						->setSortable(true)
					,
					(new FieldConfig)
						->setName('createdAt')
						->setLabel('reg. Date')
						->setSortable(true)
						->setCallback(function($val){
							$d = new \DateTime($val);
							return $d->format('M d, Y');
						})
					,
					(new FieldConfig)
						->setName('action')
						->setLabel('Actions')
						->setCallback(function ($val, $row) {
							$item = $row->getSrc();
							$url = "<a title='Edit account' href='" . URL('admin/manager/studio-profile/' . $val) . "'><span class='fa fa-pencil'></span></a>&nbsp;&nbsp;<a title='Delete account' onclick=\"return confirm('Are you sure you want to delete this account?')\" href='" . URL('admin/manager/profile/delete/' . $val) . "'><span class='fa fa-trash'></span></a>";
							if($item->accountStatus != UserModel::ACCOUNT_ACTIVE){
								$url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/profile/approve/' . $val)."' title='Approve account'><i class='fa fa-check-circle-o' aria-hidden='true'></i></a>";
							}
							if($item->accountStatus != UserModel::ACCOUNT_DISABLE){
								$url .= "&nbsp;&nbsp;<a href='" . URL('admin/manager/profile/disable/' . $val) . "' title='Disable account' onclick=\"return confirm('Are you sure you want to disable this account?')\"><span class='fa fa-ban'></span></a>";
							}
							if($item->accountStatus == UserModel::ACCOUNT_ACTIVE){
								$url .= "&nbsp;&nbsp;<a href='".URL('admin/manager/profile/suspend/' . $val)."' title='Suspend account'><i class='fa fa-exclamation-circle' aria-hidden='true'></i></a>";
							}
							return $url;
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
									(new CsvExport)
										->setFileName('my_report' . date('Y-m-d'))
									,
									(new ExcelExport())
										->setFileName('Studio-'.  date('Y-m-d'))->setSheetName('Excel sheet'),
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
		return $grid->render();
	}

	public function payoutRequest() {
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

		return $grid->render();

	}

  /**
   * @return response 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function getSettings() {
    $settings = SettingModel::first();

    return view('Admin::admin_settings')->with('settings', $settings);
  }

  /**
   * @param int $modelDefaultReferredPercent 
   * @param int $studioDefaultReferredPercent 
   * @param int $modelDefaultPerformerPercent
   * @param int $modelDefaultPerformerPercent
   * @param int $studioDefaultPerformerPercent 
   * @param int $modelDefaultOtherPercent
   * @param int $modelDefaultOtherPercent 
   * @param int $memberJoinBonus  
   * @param string $fb_client_id 
   * @param string $fb_client_secret 
   * @param string $google_client_id 
   * @param string $google_client_secret 
   * @param string $tw_client_id 
   * @param string $tw_client_secret 
   * @return response 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function updateSettings() {
    
      $validator = Validator::make(Input::all(), [
        'modelDefaultReferredPercent' => 'Integer|Max:100|Min:0',
        'studioDefaultReferredPercent' => 'Integer|Max:100|Min:0',
        'modelDefaultPerformerPercent' => 'Integer|Max:100|Min:0',
        'modelDefaultPerformerPercent' => 'Integer|Max:100|Min:0',
        'studioDefaultPerformerPercent' => 'Integer|Max:100|Min:0',
        'modelDefaultOtherPercent' => 'Integer|Max:100|Min:0',
        'studioDefaultOtherPercent' => 'Integer|Max:100|Min:0',
        'memberJoinBonus' => 'Integer|Min:0',
        'private_price' => 'Required|Integer|Min:0',
        'group_price' => 'Required|Integer|Min:0',
        'min_tip_amount' => 'Required|Integer|Min:1',
        'conversionRate' => 'Required|Numeric|Min:0',
        'registerImage' => 'mimes:jpeg,bmp,png',
        'banner' => 'mimes:jpeg,bmp,png',
        'offlineImage' => 'mimes:jpeg,bmp,png',
        'privateImage' => 'mimes:jpeg,bmp,png',
        'groupImage' => 'mimes:jpeg,bmp,png',
        'bannerLink' => 'url',
        'placeholderAvatar1' => 'mimes:jpeg,bmp,png',
        'placeholderAvatar2' => 'mimes:jpeg,bmp,png',
        'placeholderAvatar3' => 'mimes:jpeg,bmp,png'
    ]);
    $validator->after(function ($validator) {
    	if (Input::file('tipSound')) {
	    	$tipExtension = Input::file('tipSound')->getClientOriginalExtension(); 
		    if($tipExtension !== 'mp3'){
		    	$validator->errors()->add('tipSound', "The tip sound must be a file of type: audio/mp3");	
		    }
		}
	});

    if ($validator->fails()) {
      return Back()
          ->withErrors($validator)
          ->withInput();
    }
      
    $modelReferred = (Input::has('modelDefaultReferredPercent')) ? Input::get('modelDefaultReferredPercent') : 0;
    $studioReferred = (Input::has('studioDefaultReferredPercent')) ? Input::get('studioDefaultReferredPercent') : 0;
    $modelPerformer = (Input::has('modelDefaultPerformerPercent')) ? Input::get('modelDefaultPerformerPercent') : 0;
    $studioPerformer = (Input::has('studioDefaultPerformerPercent')) ? Input::get('studioDefaultPerformerPercent') : 0;
    $modelOther = (Input::has('modelDefaultOtherPercent')) ? Input::get('modelDefaultOtherPercent') : 0;
    $studioOther = (Input::has('studioDefaultOtherPercent')) ? Input::get('studioDefaultOtherPercent') : 0;

    $message = null;
    // if ($modelReferred + $studioReferred > 100) {
    //   $message .= 'Total referred member percent of model and studio have to less than 100%';
    // }
    // if ($modelPerformer + $studioPerformer > 100) {
    //   $message .= '<br>Total Performer member percent of model and studio have to less than 100%';
    // }
    // if ($modelOther + $studioOther > 100) {
    //   $message .= '<br>Total Other member percent of model and studio have to less than 100%';
    // }
    if (!$message) {
      $settings = SettingModel::first();//(Input::has('id')) ? SettingModel::find(Input::get('id')) : new SettingModel;
      $settings->modelDefaultReferredPercent = $modelReferred;
      $settings->studioDefaultReferredPercent = $studioReferred;

      $settings->modelDefaultPerformerPercent = $modelPerformer;
      $settings->studioDefaultPerformerPercent = $studioPerformer;

      $settings->modelDefaultOtherPercent = $modelOther;
      $settings->studioDefaultOtherPercent = $studioOther;

      $settings->memberJoinBonus = (Input::has('memberJoinBonus')) ? Input::get('memberJoinBonus') : 0;
      $settings->private_price = (Input::has('private_price')) ? Input::get('private_price') : 0;
      $settings->group_price = (Input::has('group_price')) ? Input::get('group_price') : 0;
      $settings->min_tip_amount = (Input::has('min_tip_amount')) ? Input::get('min_tip_amount') : 10;
      $settings->conversionRate = Input::get('conversionRate');
      $settings->bannerLink = Input::get('bannerLink');
      if (Input::file('banner')) {
        
        $extension = Input::file('banner')->getClientOriginalExtension(); // getting image extension
        $banner = 'banner.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$banner)) {
         \File::Delete(public_path('images').'/'.$banner);
        }
        Input::file('banner')->move(public_path('images'), $banner); // uploading file to given path
        // sending back with message
       
        $settings->banner = 'images/' . $banner;
      }
      if (Input::file('offlineImage')) {
        $extension = Input::file('offlineImage')->getClientOriginalExtension(); // getting image extension
        $offline = 'offline-image.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$offline)) {
          \File::Delete(public_path('images').'/'.$offline);
        }
        Input::file('offlineImage')->move(public_path('images'), $offline); // uploading file to given path
        // sending back with message
        
        $settings->offlineImage = 'images/' . $offline;
      }
      if (Input::file('privateImage')) {
        $extension = Input::file('privateImage')->getClientOriginalExtension(); // getting image extension
        $private = 'private-image.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$private)) {
          \File::Delete(public_path('images').'/'.$private);
        }
        Input::file('privateImage')->move(public_path('images'), $private); // uploading file to given path
        // sending back with message
        
        $settings->privateImage = 'images/' . $private;
      }
      if (Input::file('groupImage')) {
        $extension = Input::file('groupImage')->getClientOriginalExtension(); // getting image extension
        $group = 'group-image.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$group)) {
          \File::Delete(public_path('images').'/'.$group);
        }
        Input::file('groupImage')->move(public_path('images'), $group); // uploading file to given path
        // sending back with message
        
        $settings->groupImage = 'images/'.$group;
      }
      if (Input::file('registerImage')) {
        $extension = Input::file('registerImage')->getClientOriginalExtension(); // getting image extension
        $registerImage = 'register-image.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$registerImage)) {
          \File::Delete(public_path('images').'/'.$registerImage);
        }
        Input::file('registerImage')->move(public_path('images'), $registerImage); // uploading file to given path
        
        $settings->registerImage = 'images/'.$registerImage;
      }

      if (Input::file('tipSound')) {
        
        $extension = Input::file('tipSound')->getClientOriginalExtension(); // getting image extension
        $tipSound = 'received_message.' . $extension; // renameing image
        if (file_exists(public_path('sounds').'/'.$tipSound)) {
         \File::Delete(public_path('sounds').'/'.$tipSound);
        }
        Input::file('tipSound')->move(public_path('sounds'), $tipSound); // uploading file to given path
        // sending back with message
       
        $settings->tipSound = 'sounds/' . $tipSound;
      }

      if (Input::file('placeholderAvatar1')) {
        
        $extension = Input::file('placeholderAvatar1')->getClientOriginalExtension(); // getting image extension
        $placeholderAvatar1 = 'avatar1.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$placeholderAvatar1)) {
         \File::Delete(public_path('images').'/'.$placeholderAvatar1);
        }
        Input::file('placeholderAvatar1')->move(public_path('images'), $placeholderAvatar1); // uploading file to given path
        $settings->placeholderAvatar1 = 'images/' . $placeholderAvatar1;
      }
      if (Input::file('placeholderAvatar2')) {
        $extension = Input::file('placeholderAvatar2')->getClientOriginalExtension(); // getting image extension
        $placeholderAvatar2 = 'avatar2.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$placeholderAvatar2)) {
         \File::Delete(public_path('images').'/'.$placeholderAvatar2);
        }
        Input::file('placeholderAvatar2')->move(public_path('images'), $placeholderAvatar2); // uploading file to given path
        $settings->placeholderAvatar2 = 'images/' . $placeholderAvatar2;
        
      }
      if (Input::file('placeholderAvatar3')) {
        $extension = Input::file('placeholderAvatar3')->getClientOriginalExtension(); // getting image extension
        $placeholderAvatar3 = 'avatar3.' . $extension; // renameing image
        if (file_exists(public_path('images').'/'.$placeholderAvatar3)) {
         \File::Delete(public_path('images').'/'.$placeholderAvatar3);
        }
        Input::file('placeholderAvatar3')->move(public_path('images'), $placeholderAvatar3); // uploading file to given path
        $settings->placeholderAvatar3 = 'images/' . $placeholderAvatar3;
      }

      if(Input::get('deleteImg')){
        foreach (Input::get('deleteImg') as $value){
          if (file_exists(public_path('images') . $settings->$value)) {
              \File::Delete(public_path('images') . '/' . $settings->$value);
          }
          $settings->$value = null;
      }
    }
      
      if ($settings->save()) {
        return Redirect::to('admin/dashboard/settings')->with('msgInfo', 'Setting was successfully updated.');
      }
      $message = 'System error.';
    }
    return Back()->withInput()->with('msgError', $message);
  }

  /**
   * @return response 
   * 
   */
  public function getSeoSettings() {
    $settings = SettingModel::first();
    
    return view('Admin::admin_seo_settings')->with('settings', $settings);
  }

  /**
   * @param string $Title
   * @param string $Description
   * @param String $Keywords
   * @param file $logo
   * @return response 
   * @author Phong Le <pt.hongphong@gmail.com>
   */
  public function updateSeoSettings() {
    $this->validate(request(), [
        'title' => 'Required|Max:160',
        'siteName' => 'Required|Max:100',
        'description' => 'Max:160',
        'keywords' => 'Max:160',
        'logo' => 'Max:1000|Mimes:jpg,jpeg,png',
        'favicon' => 'Max:1000|Mimes:jpg,jpeg,png',
        'code_before_head_tag' => 'Max:100',
        'code_after_body_tag' => 'Max:100'
    ]);

    $settings = SettingModel::first();//(Input::has('id')) ? SettingModel::find(Input::get('id')) : new SettingModel;
    $settings->title = Input::get('title');
    $settings->siteName = Input::get('siteName');
    $settings->description = Input::get('description');

    $settings->keywords = Input::get('keywords');

    if (Input::file('logo')) {
      // checking file is valid.
      if (!Input::file('logo')->isValid()) {
        return Back()->with('msgInfo', 'uploaded file is not valid');
      }
      $destinationPath = PATH_UPLOAD; // upload path
      $extension = Input::file('logo')->getClientOriginalExtension(); // getting image extension
      $fileName = 'logo-' . rand(11111, 99999) . '.' . $extension; // renameing image
      if (file_exists($destinationPath . '/' . $settings->logo)) {
        \File::Delete($destinationPath . '/' . $settings->logo);
      }
      Input::file('logo')->move($destinationPath, $fileName); // uploading file to given path
      // sending back with message
      
      $settings->logo = $fileName;
    }
      if (Input::file('favicon')) {
          // checking file is valid.
          if (!Input::file('favicon')->isValid()) {
              return Back()->with('msgInfo', 'uploaded file is not valid');
          }
          $destinationPath = PATH_UPLOAD; // upload path
          $extension = Input::file('favicon')->getClientOriginalExtension(); // getting image extension
          $fileName = 'favicon-' . rand(11111, 99999) . '.' . $extension; // renameing image
          if (file_exists($destinationPath . '/' . $settings->favicon)) {
              \File::Delete($destinationPath . '/' . $settings->favicon);
          }
          Input::file('favicon')->move($destinationPath, $fileName); // uploading file to given path
          // sending back with message
          
          $settings->favicon = $fileName;
      }
      if(Input::get('deleteImg')){
        foreach (Input::get('deleteImg') as $value){
            $destinationPath = PATH_UPLOAD;
            if (file_exists($destinationPath . '/' . $settings->$value)) {
                \File::Delete($destinationPath . '/' . $settings->$value);
            }
            $settings->$value = null;
        }
      }
    $settings->code_before_head_tag = Input::get('code_before_head_tag');
    $settings->code_before_body_tag = Input::get('code_before_body_tag');
    if ($settings->save()) {
      return Back()->with('msgInfo', 'Setting was successfully updated');
    }

    return Back()->withInput()->with('msgError', 'System error.');
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

}
